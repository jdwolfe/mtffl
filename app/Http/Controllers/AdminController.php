<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Mtffl\Mtffl;

class AdminController extends Controller {
	private $mflUrl = '';
	private $currentSeason = 0;
	private $currentWeek = 0;
	private $mfl_server = '';
	private $mfl_number = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
		$mflInfo = DB::table('mfl_info')->select('season','mfl_number','mfl_server')->where('league','mtffl')->orderBy('id','desc')->take(1)->first();
		$this->mfl_server = $mflInfo->mfl_server;
		$this->mfl_number = $mflInfo->mfl_number;
		$this->mflUrl = 'https://' . $mflInfo->mfl_server . '.myfantasyleague.com/' . $mflInfo->season . '/home/' . $mflInfo->mfl_number;

		$config = DB::table('mtffl_config')->get();
		foreach( $config as $c ) {
			if( 'current_season' == $c->config_name ) { $this->currentSeason = $c->config_value; }
			if( 'current_week' == $c->config_name ) { $this->currentWeek = $c->config_value; }
		}
    }

	private function returnView( $template = '', $data = NULL ) {
		$data['mflUrl'] = $this->mflUrl;
		$data['currentSeason'] = $this->currentSeason;
		$data['currentWeek'] = $this->currentWeek;
		return view( $template, $data );
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function index() {
		$this->middleware('auth');
		$currentHome = DB::table('mtffl_config')->where('config_name','homepage')->value('config_value');
		$nfl_start = DB::table('mtffl_config')->where('config_name','nfl_start')->value('config_value');
		$teams = DB::table('team_details')->select('team_id','team_longname')->where('league','mtffl')->where('status','active')->orderBy('team_longname')->get();
		$active_teams = array();
		foreach( $teams as $t ) {
			$active_teams[ $t->team_id ] = $t->team_longname;
		}
		return $this->returnView('admin', [ 'currentHome' => $currentHome, 'nfl_start' => $nfl_start, 'active_teams' => $active_teams ] );
	}

	public function showHome( $option = '' ) {
		// check
		$options = array( 'Champion', 'DraftDay', 'Matches' );
		if ( in_array( $option, $options ) ) {
			DB::table('mtffl_config')->where('config_name','homepage')->update( [ 'config_value' => $option ] );
			Session::flash('message', 'Homepage updated to ' . $option );
		} else {
			Session::flash('message', 'Invalid Selection' );
		}
		return redirect('admin');
	}

	public function newSeason( Request $request ) {
		$input = $request->all();
		$nfl_start = date('Y-m-d', strtotime( $input['nfl_start'] ) );
		$current_season = date('Y', strtotime( $input['nfl_start'] ) );
		$current_week = 1;
		DB::table('mtffl_config')->where('config_name', 'nfl_start')->update( [ 'config_value' => $nfl_start ] );
		DB::table('mtffl_config')->where('config_name', 'current_season')->update( [ 'config_value' => $current_season ] );
		DB::table('mtffl_config')->where('config_name', 'current_week')->update( [ 'config_value' => $current_week ] );
		$mfl['league'] = 'mtffl';
		$mfl['mfl_server'] = $input['mfl_server'];
		$mfl['season'] = date('Y', strtotime( $input['nfl_start'] ) );
		$mfl['mfl_number'] = $input['mfl_number'];
		DB::table('mfl_info')->insert( $mfl );

		Session::flash('message', 'Updated to season ' . $current_season );
		return redirect('admin');
	}

	public function replaceTeam( Request $request ) {
		$input = $request->all();
		$old_team_id = $input['retire_team'];
		$old_team = DB::table('team_details')->select('team_longname','mfl_id','division')->where('team_id', $old_team_id)->first();
		$retired_season = intval( $this->currentSeason ) - 1;
		$update = array(
			'retired_from_league' => $retired_season,
			'status' => 'retired',
		);
		DB::table('team_details')->where('team_id',$old_team_id)->update( $update );

		$insert = array(
			'mfl_id' => $old_team->mfl_id,
			'division' => $old_team->division,
			'member_since' => $this->currentSeason,
			'team_longname' => $input['new_team_longname'],
			'owner_name' => $input['new_owner_name']
		);
		DB::table('team_details')->insert( $insert );

		Session::flash('message', 'Retired ' . $old_team->team_longname . '; Added ' . $input['new_team_longname'] );
		return redirect('admin');
	}

	private function getTeamIdByMFLId( $mfl_id = 0 ) {
		foreach( $this->team_info as $t ) {
			if ( $t->mfl_id == $mfl_id ) {
				return $t->team_id;
			}
		}
		return array();
	}

	private function getTeamInfoByMFLId( $mfl_id = 0 ) {
		foreach( $this->team_info as $t ) {
			if ( $t->mfl_id == $mfl_id ) {
				return $t;
			}
		}
		return array();
	}

	public function updateSchedule() {
		$Mtffl = new Mtffl;

		$this->team_info = DB::table('team_details')
			->select('team_longname', 'team_id', 'division', 'user_id', 'mfl_id', 'owner_name')
			->where('league','mtffl')->where('status','active')
			->get();

		// get schedule from live scoring
		$message = '';
		for( $week = 1; $week <= 14; $week++ ) {
			$strURL = "http://" . $this->mfl_server . ".myfantasyleague.com/" . $this->currentSeason . "/export/export?TYPE=liveScoring&L=" . $this->mfl_number . "&W=" . $week;

			$xml = $Mtffl->GetXML( $strURL );
			if ( $xml !== FALSE ) {
				foreach ( $xml as $match) {
					foreach ($match->franchise as $franchise) {
						$t = strval($franchise['id']);
						if ( $franchise['isHome'] == "0" ) {
							$away_team = $this->getTeamInfoByMFLId( $t );
						}
						else {
							$home_team = $this->getTeamInfoByMFLId( $t );
						}
					}

					$match_check = DB::table('schedule')->select('gid')
						->where('season', $this->currentSeason)
						->where('week', $week)
						->where('home_team_id', $home_team->id)
						->where('away_team_id', $away_team->id)
						->first();

					if( NULL != $match_check ) {
						$message .= 'Week ' . $week . ' ' . $away_team->id . '@' . $home_team->id . ' already exists<br>';
						continue;
					}

					$message .= 'Week ' . $week . ' ' . $away_team->id . '@' . $home_team->id . ' inserting<br>';
					$insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $week,
						'away_team_id' => $away_team->id,
						'home_team_id' => $home_team->id,
						'playoffbracket' => 'regular',
						'playoffbrackettier' => 'none'
					);
					DB::table('schedule')->insert( $insert );

					if( $home_team->division == $away_team->division ) {
						$division = $home_team->division;
						$game_type = 'intra';
					} else {
						$division = '';
						$game_type = 'inter';
					}
					$home_insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $week,
						'team_id' => $home_team->id,
						'opp_id' => $away_team->id,
						'location' => 'home',
						'division' => $division,
						'game_type' => $game_type
					);
					DB::table('team_records')->insert( $home_insert );

					$away_insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $week,
						'team_id' => $away_team->id,
						'opp_id' => $home_team->id,
						'location' => 'away',
						'division' => $division,
						'game_type' => $game_type
					);
					DB::table('team_records')->insert( $away_insert );

				}
			}
		} // end for week 1 to 14

		$this->updateSeasonResults();

		Session::flash('message', $message);
		return redirect('admin');
	}

	public function updateScores() {
		$Mtffl = new Mtffl;

		$this->team_info = DB::table('team_details')
			->select('team_longname', 'team_id', 'division', 'user_id', 'mfl_id', 'owner_name')
			->where('league','mtffl')->where('status','active')
			->get();

		// get schedule from live scoring
		$message = '';
		$strURL = "http://" . $this->mfl_server . ".myfantasyleague.com/" . $this->currentSeason . "/export/export?TYPE=liveScoring&L=" . $this->mfl_number . "&W=" . $this->currentWeek;

		$xml = $Mtffl->GetXML( $strURL );
		if ( $xml !== FALSE ) {
			foreach ( $xml as $match) {
				foreach ($match->franchise as $franchise) {
					$t = strval($franchise['id']);
					if ( $franchise['isHome'] == "0" ) {
						$away_score = strval($franchise['score']);
						$away_team = $this->getTeamInfoByMFLId( $t );
						$away_team_id = $away_team->team_id;
					}
					else {
						$home_score = strval($franchise['score']);
						$home_team = $this->getTeamInfoByMFLId( $t );
						$home_team_id = $home_team->team_id;
					}
				}

				if( $home_team->division == $away_team->division ) {
					$division = $home_team->division;
					$game_type = 'intra';
				} else {
					$division = '';
					$game_type = 'inter';
				}

				$match_check = DB::table('schedule')->select('gid')
					->where('season', $this->currentSeason)
					->where('week', $this->currentWeek)
					->where('home_team_id', $home_team_id)
					->where('away_team_id', $away_team_id)
					->first();

				if( NULL == $match_check ) {
					$insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'away_team_id' => $away_team_id,
						'home_team_id' => $home_team_id,
						'away_score' => $away_score,
						'home_score' => $home_score
					);
					DB::table('schedule')->insert( $insert );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' inserting<br>';
				} else {
					$where = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'away_team_id' => $away_team_id,
						'home_team_id' => $home_team_id
					);
					$update = array(
						'away_score' => $away_score,
						'home_score' => $home_score
					);
					DB::table('schedule')->where( $where )->update( $update );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' updating<br>';
				}

				//update team_records
				$home_record_check = DB::table('team_records')->select('rid')
					->where('season', $this->currentSeason)
					->where('week', $this->currentWeek)
					->where('team_id', $home_team_id)
					->where('opp_id', $away_team_id)
					->first();
				if( NULL == $home_record_check ) {
					$insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'team_id' => $home_team_id,
						'opp_id' => $away_team_id,
						'team_score' => $home_score,
						'opp_score' => $away_score,
						'location' => 'home',
						'division' => $division,
						'game_type' => $game_type
					);
					DB::table('team_records')->insert( $insert );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' inserting team_records<br>';

				} else {
					$where = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'team_id' => $home_team_id,
						'opp_id' => $away_team_id
					);
					$update = array(
						'team_score' => $home_score,
						'opp_score' => $away_score
					);
					DB::table('team_records')->where( $where )->update( $update );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' updating team_records<br>';
				}


				$away_record_check = DB::table('team_records')->select('rid')
					->where('season', $this->currentSeason)
					->where('week', $this->currentWeek)
					->where('team_id', $away_team_id)
					->where('opp_id', $home_team_id)
					->first();
				if( NULL == $away_record_check ) {

					$insert = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'team_id' => $away_team_id,
						'opp_id' => $home_team_id,
						'team_score' => $away_score,
						'opp_score' => $home_score,
						'location' => 'away',
						'division' => $division,
						'game_type' => $game_type
					);
					DB::table('team_records')->insert( $insert );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' inserting team_records<br>';
				} else {
					$where = array(
						'league' => 'mtffl',
						'season' => $this->currentSeason,
						'week' => $this->currentWeek,
						'team_id' => $away_team_id,
						'opp_id' => $home_team_id
					);
					$update = array(
						'team_score' => $away_score,
						'opp_score' => $home_score
					);
					DB::table('team_records')->where( $where )->update( $update );
					$message .= 'Week ' . $this->currentWeek . ' ' . $away_team_id . '@' . $home_team_id . ' updating team_records<br>';
				}

			}
		}

		$this->updateSeasonResults();

		Session::flash('message', $message);
		return redirect('admin');
	}

	public function updateSeasonResults() {
		$this->team_info = DB::table('team_details')->select('team_id','team_longname','division','mfl_id')->where('league','mtffl')->where('status','active')->get();

		$season_results_check = DB::table('team_season_results')->where('league','mtffl')->where('season', $this->currentSeason)->first();
		if( NULL == $season_results_check ) {
			foreach( $this->team_info as $t ) {
				$insert = array(
					'league' => 'mtffl',
					'season' => $this->currentSeason,
					'team_id' => $t->team_id,
					'division_name' => $t->division,
				);
				DB::table('team_season_results')->insert( $insert );
			}
		}

		$Mtffl = new Mtffl();
		$strURL = "http://" . $this->mfl_server . ".myfantasyleague.com/" . $this->currentSeason . "/export/export?TYPE=standings&L=" . $this->mfl_number;
		$xml = $Mtffl->GetXML( $strURL );
		if ( $xml !== FALSE ) {
			foreach ( $xml as $f ) {
				$team_id = $this->getTeamIdByMFLId( $f['id']);
				$where = array(
					'season' => $this->currentSeason,
					'team_id' => $team_id
				);
				$update = array(
					'wins' => $f->h2hw,
					'losses' => $f->h2hl,
					'ties' => $f->h2ht,
					'division_wins' => $f->divw,
					'division_losses' => $f->divl,
					'division_ties' => $f->divt,
					'points_for' => $f->pf,
					'power_rank' => $f->power_rank,
					'all_play_wins' => $f->all_play_w
				);
				DB::table('team_season_results')->where( $where )->update( $update );
			}
		}

		$results = DB::table('team_season_results')->select('id')
			->where('league','mtffl')->where('season', $this->currentSeason)
			->orderBy('points_for', 'desc')->get();
		$rank = 1;
		foreach( $results as $r ) {
			DB::table('team_season_results')->where('id', $r->id)->update( [ 'points_rank' => $rank ] );
			$rank++;
		}

	}
}
