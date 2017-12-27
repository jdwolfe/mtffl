<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\NewsController;
use App\Mtffl\Mtffl;

class HomeController extends Controller	{
	private $mflUrl = '';
	private $currentSeason = 2017;
	private $currentWeek = 1;
	private $team_info = array();
	private $mfl_server = '';
	private $mfl_number = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
		$mflInfo = DB::table('mfl_info')->select('season','mfl_number','mfl_server')->where('league','mtffl')->orderBy('id','desc')->take(1)->first();
		$this->mflUrl = 'https://' . $mflInfo->mfl_server . '.myfantasyleague.com/' . $mflInfo->season . '/home/' . $mflInfo->mfl_number;
		$this->mfl_server = $mflInfo->mfl_server;
		$this->mfl_number = $mflInfo->mfl_number;
		$config = DB::table('mtffl_config')->get();
		foreach( $config as $c ) {
			if( 'current_season' == $c->config_name ) { $this->currentSeason = $c->config_value; }
			if( 'current_week' == $c->config_name ) { $this->currentWeek = $c->config_value; }
		}
    }

	private function returnView( $template = '', $data = NULL ) {
		$data['mflUrl'] = $this->mflUrl;
		$News = new NewsController();
		$data['news'] = $News->getNews();
		$data['season'] = $this->currentSeason;
		$data['week'] = $this->currentWeek;
		return view( $template, $data );
	}
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function index() {
		$data = array();
		$currentHome = DB::table('mtffl_config')->where('config_name','homepage')->value('config_value');
		if( 'Matches' == $currentHome ) {
			$matches_cache = DB::table('mtffl_config')->where('config_name', 'matches')->value('config_value');
			$matches_cache = json_decode( $matches_cache );
			if ( NULL == $matches_cache || ( time() - $matches_cache->update_time > 60 * 5 ) ) {
				$cache = new \StdClass();
				$cache->update_time = time();
				$data['matches_update'] = date( 'Y-m-d H:i:s', $cache->update_time );
				$data['matches'] = $this->getMatches();
				$cache->matches = $data['matches'];
				$cache = json_encode( $cache );
				if( NULL == $matches_cache ) {
					DB::table('mtffl_config')->insert( [ 'config_name' => 'matches', 'config_value' => $cache ] );
				} else {
					DB::table('mtffl_config')->where('config_name', 'matches')->update( ['config_value' => $cache ] );
				}
			} else {
				$data['matches_update'] = date( 'Y-m-d H:i:s', $matches_cache->update_time );
				$data['matches'] = $matches_cache->matches;
			}

		}

		if( 'Champion' == $currentHome ) {
			$data['champ'] = DB::table('team_details')->join('team_season_results', 'team_details.team_id', '=', 'team_season_results.team_id')
				->select('team_details.team_id','team_details.team_longname','team_details.owner_name')
				->where('team_season_results.league', 'mtffl')
				->where('team_season_results.season', $this->currentSeason)
				->where('team_season_results.league_finish', 1)->first();
			if( NULL == $data['champ'] ) {
				$data['champ'] = new \stdClass();
				$data['champ']->team_id = 0;
				$data['champ']->team_longname = 'No team selected';
				$data['champ']->owner_name = '';
			}
		}

		$data['currentSeason'] = $this->currentSeason;
		$data['currentHome'] = $currentHome;
		return $this->returnView( 'home', $data );
	}

	/*
	* STATIC PAGES
	*/
	public function trophies() {
		return $this->returnView('trophies');
	}
	public function rulebook() {
		return $this->returnView('rulebook');
	}
	public function ruleAmendments() {
		return $this->returnView('ruleAmendments');
	}
	public function scoringRules() {
		return $this->returnView('scoringRules');
	}
	public function cost() {
		return $this->returnView('cost');
	}
	public function tieBreakers() {
		return $this->returnView('tieBreakers');
	}
	public function pointCalculator() {
		return $this->returnView('pointCalculator');
	}
	public function draftDay() {
		return $this->returnView('draftDay');
	}
	/*
	* DYNAMIC PAGES
	*/
	public function hallofChampions() {
		$query = DB::table('team_season_results');
		$query->join('team_details','team_season_results.team_id','=','team_details.team_id');
		$query->select('team_details.team_id','team_details.team_longname','team_season_results.season','team_season_results.league_finish');
		$query->where('team_season_results.league','mtffl')->where('league_finish','<=','3')->orderBy('season','asc')->orderBy('league_finish');
		$results = $query->get();

		$seasons = array();
		foreach( $results as $r ) {
			if( !array_key_exists( $r->season, $seasons ) ) {
				$s = new \stdClass();
				$s->season = $r->season;
				$s->place1 = '';
				$s->place1_id = 0;
				$s->place2 = '';
				$s->place2_id = 0;
				$s->place3 = '';
				$s->place3_id = 0;
				$seasons[ $r->season ] = $s;
			}
			switch( $r->league_finish ) {
				case 1: $seasons[ $r->season ]->place1 = $r->team_longname; $seasons[ $r->season ]->place1_id = $r->team_id; break;
				case 2: $seasons[ $r->season ]->place2 = $r->team_longname; $seasons[ $r->season ]->place2_id = $r->team_id; break;
				case 3: $seasons[ $r->season ]->place3 = $r->team_longname; $seasons[ $r->season ]->place3_id = $r->team_id; break;
			}
		}

		return $this->returnView('hallofChampions', [ 'seasons' => $seasons ] );
	}
	public function divisionWinners() {
		$query = DB::table('team_season_results');
		$query->join('team_details','team_season_results.team_id','=','team_details.team_id');
		$query->select('team_details.team_id','team_details.team_longname','team_season_results.season','team_season_results.division_finish','team_details.division','team_season_results.wildcard');
		$query->where('team_season_results.league','mtffl');
		$query->where( function( $q ) { $q->where('division_finish','=','1')->orwhere('wildcard','y'); } );
		$query->orderBy('season','asc');
		$results = $query->get();

		$seasons = array();
		foreach( $results as $r ) {
			if( !array_key_exists( $r->season, $seasons ) ) {
				$s = new \stdClass();
				$s->season = $r->season;
				$s->division1 = '';
				$s->division1_id = 0;
				$s->division2 = '';
				$s->division2_id = 0;
				$s->division3 = '';
				$s->division3_id = 0;
				$s->wildcard = '';
				$s->wildcard_id = 0;
				$seasons[ $r->season ] = $s;
			}
			if( 'y' == $r->wildcard ) {
				$seasons[ $r->season ]->wildcard = $r->team_longname;
				$seasons[ $r->season ]->wildcard_id = $r->team_id;
			} else {
				switch( $r->division ) {
					case 'Paydirt': $seasons[ $r->season ]->division1 = $r->team_longname; $seasons[ $r->season ]->division1_id = $r->team_id; break;
					case 'Red Zone': $seasons[ $r->season ]->division2 = $r->team_longname; $seasons[ $r->season ]->division2_id = $r->team_id; break;
					case 'Gridiron': $seasons[ $r->season ]->division3 = $r->team_longname; $seasons[ $r->season ]->division3_id = $r->team_id; break;
				}
			}
		}

		return $this->returnView('divisionWinners', [ 'seasons' => $seasons ] );
	}
	public function historyGrid( $status = '' ) {
		if( '' == $status ) {
			$status = 'active';
		} else {
			$status = 'all';
		}

		$empty_results = array();
		$currentSeason = DB::table('mtffl_config')->where('config_name','current_season')->value('config_value');

		$seasons = array();
		for( $i = 1998; $i<=$currentSeason; $i++ ) {
			$seasons[] = $i;
			$empty_results[$i] = array(
				'active' => 'inactive',
				'overall' => '',
				'division' => '',
				'made_playoffs' => '',
				'league_finish' => ''
			);
		}

		$query = DB::table('team_details');
		$query->select( 'team_longname','team_id','division' );
		$query->where( 'league', 'mtffl' );
		if( 'active' == $status ) {
			$query->where('status', 'active');
		}
		$query->orderBy( 'division' )->orderBy('mfl_id')->orderBy('member_since');
		$teams = $query->get();

		$history = array();
		$team_ids = array();
		foreach( $teams as $a ) {
			$team_ids[] = $a->team_id;
			$history[$a->team_id] = array(
				'team_longname' => $a->team_longname,
				'team_id' => $a->team_id,
				'division' => $a->division,
				'results' => $empty_results
			);
		}

		$results = DB::table('team_season_results')
			->select( 'team_id','season','wins','losses','ties','division_wins','division_losses','division_ties','division_finish','league_finish','wildcard','league' )
			->where( 'league', 'mtffl' )
			->whereIn( 'team_id', $team_ids )
			->get();
		foreach( $results as $r ) {
			$overall = $r->wins.'-'.$r->losses;
			if( '0' != $r->ties ) { $overall .= '-'.$r->ties; }
			$division = $r->division_wins.'-'.$r->division_losses;
			if( '0' != $r->division_ties ) { $overall .= '-'.$r->division_ties; }

			if ( 'y' == $r->wildcard ) { $made_playoffs = 'wildcardwinner'; }
			elseif ( '1' == $r->division_finish ) { $made_playoffs = 'divisionwinner'; }
			else { $made_playoffs = ''; }

			$history[ $r->team_id ]['results'][ $r->season ] = array(
				'active' => 'active',
				'overall' => $overall,
				'division' => $division,
				'made_playoffs' => $made_playoffs,
				'league_finish' => $r->league_finish
			);
		}

		return $this->returnView('historyGrid', [ 'seasons' => $seasons, 'allresults' => $history ] );
	}

	private function getMatches() {
		$Mtffl = new Mtffl;

		$this->team_info = DB::table('team_details')
			->select('team_longname', 'team_id', 'division', 'user_id', 'mfl_id', 'owner_name')
			->where('league','mtffl')->where('status','active')
			->get();

		$schedule = array();
		// get live scoring
		$strURL = "http://" . $this->mfl_server . ".myfantasyleague.com/" . $this->currentSeason . "/export/export?TYPE=liveScoring&L=" . $this->mfl_number . "&W=" . $this->currentWeek;

		$xml = $Mtffl->GetXML( $strURL );
		if ( $xml !== FALSE ) {
			foreach ( $xml as $match) {
				$A_id=0;
				$H_id=0;
				$home_team = array();
				$away_team = array();

				foreach ($match->franchise as $franchise) {
					$t = strval($franchise['id']);
					if ( $franchise['isHome'] == "0" ) {
						$A_id = $t;
						$away_score = strval($franchise['score']);
						$away_ytp = strval($franchise['playersYetToPlay']);
						$away_ip = strval($franchise['playersCurrentlyPlaying']);
						$away_gmr = ceil( intval($franchise['gameSecondsRemaining']) );
						$away_team = $this->getTeamByMFLId( $franchise['id'] );
					}
					else {
						$H_id = $t;
						$home_score = strval($franchise['score']);
						$home_ytp = strval($franchise['playersYetToPlay']);
						$home_ip = strval($franchise['playersCurrentlyPlaying']);
						$home_gmr = ceil( intval($franchise['gameSecondsRemaining']) );
						$home_team = $this->getTeamByMFLId( $franchise['id'] );
					}
				}

				if ( isset( $away_team->team_id ) && isset( $home_team->team_id ) ) {
					$away_min = floor( $away_gmr / 60 );
					$away_sec = sprintf( '%02d', ( $away_gmr % 60 ) );
					$home_min = floor( $home_gmr / 60 );
					$home_sec = sprintf( '%02d', ( $home_gmr % 60 ) );
					$schedule[] = array(
						'away_team_id' => $away_team->team_id,
						'away_team' => $away_team->team_longname,
						'away_score' => $away_score,
						'away_ytp' => $away_ytp,
						'away_ip' => $away_ip,
						'away_gmr' => $away_min . ':' . $away_sec,
						'home_team_id' => $home_team->team_id,
						'home_team' => $home_team->team_longname,
						'home_score' => $home_score,
						'home_ytp' => $home_ytp,
						'home_ip' => $home_ip,
						'home_gmr' => $home_min . ':' . $home_sec,
					);
				}
			}
		}

		return json_decode( json_encode( $schedule ) );
	}

	private function getTeamByMFLId( $mfl_id = 0 ) {
		foreach( $this->team_info as $t ) {
			if ( $t->mfl_id == $mfl_id ) {
				return $t;
			}
		}
		return array();
	}

}
