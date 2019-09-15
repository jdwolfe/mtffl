<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TeamController extends Controller	{
	private $mflUrl = '';
	private $team_id = 0;
	private $mflInfo = NULL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
		$this->mflInfo = DB::table('mfl_info')->select('season','mfl_number','mfl_server')->where('league','mtffl')->orderBy('id','desc')->take(1)->first();
		$this->mflUrl = 'https://' . $this->mflInfo->mfl_server . '.myfantasyleague.com/' . $this->mflInfo->season . '/home/' . $this->mflInfo->mfl_number;
    }

	private function returnView( $template = '', $data = NULL ) {
		$data['mflUrl'] = $this->mflUrl;
		return view( $template, $data );
	}
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function index( $option = '' ) {
		$query = DB::table('team_details')->select( 'team_id', 'team_longname', 'division', 'member_since', 'status', 'retired_from_league');
		if( '' == $option ) {
			$query->where('status', 'active');
		}
		$query->where('league', 'mtffl');
		$query->orderBy('division')->orderBy('member_since')->orderBy('team_longname');
		$teams = $query->get();

		return $this->returnView( 'teams', [ 'teams' => $teams ] );
	}

	public function info( $team_id = 0 ) {
		$team['teamInfo'] = $this->getTeam( $team_id );
		if( NULL === $team['teamInfo'] ) {
			return $this->returnView('notFound');
		}

		$team['teamDetails'] = $this->getTeamDetails( $team_id );
		$team['headtohead'] = $this->getH2H( $team_id );
		return $this->returnView('teamInfo', $team );
	}

	public function schedule( $team_id = 0, $season = 0 ) {
		$team['teamInfo'] = DB::table('team_details')->select('team_id', 'team_longname')->where('team_id', $team_id)->first();
		$team['teamInfo']->season = $season;
		$record = DB::table('team_season_results')->select('wins', 'losses', 'ties', 'division_wins', 'division_losses', 'division_ties')
			->where('team_id', $team_id)->where('season', $season)->first();
		if( NULL !== $record ) {
			$team['teamInfo']->record = $record->wins . '-' . $record->losses . '-' . $record->ties .
			' (' . $record->division_wins . '-' . $record->division_losses . '-' . $record->division_ties . ')';
			$team['schedule'] = $this->getSchedule( $team_id, $season );
		} else {
			$team['teamInfo']->record = '';
			$team['schedule'] = array();
		}
		$team['chart'] = array(
			'chart_labels' => '',
			'chart_data' => '',
		);
		return $this->returnView('teamSchedule', $team );
	}

	public function matchup( $team_id = 0, $opp_id = 0 ) {
		// sanitize and check the id's
		$team_id = intval( $team_id );
		$opp_id = intval( $opp_id );
		if( $team_id == 0 || $opp_id == 0 || $team_id == $opp_id ) {
			return $this->returnView('error', [ 'message' => 'Invalid Team Matchup' ] );
		}

		$team['teamInfo'] = DB::table('team_details')->select('team_id', 'team_longname')->where('team_id', $team_id)->first();
		$team['oppInfo'] = DB::table('team_details')->select('team_id', 'team_longname')->where('team_id', $opp_id)->first();
   		if( $team['teamInfo'] === NULL || $team['oppInfo'] === NULL ) {
			return $this->returnView('error', [ 'message' => 'One of those teams does not exist.' ] );
		}

		$this->team_id = $team_id;
		$team['headtohead'] = $this->getMatchup( $team_id, $opp_id );
		$team['record'] = '';
		$wins = 0; $losses = 0; $ties = 0;
		foreach( $team['headtohead'] as $h2h ) {
			if ( $h2h->team_score > $h2h->opp_score ) {
				$wins++;
			} elseif( $h2h->team_score < $h2h->opp_score ) {
				$losses++;
			} elseif( $h2h->team_score > 0 && $h2h->opp_score > 0 && $h2h->team_score == $h2h->opp_score ) {
				$ties++;
			}
		}
		$team['record'] = $wins . '-' . $losses . '-' . $ties;
		return $this->returnView('teamMatchup', $team );
	}

	private function getTeam( $teamId = 0 ) {
		if ( $teamId > 0 ) {
			$this->team_id = $teamId;
		}

		# get franchise name
		$team = new \stdClass();
		$team->team_id = $teamId;
		$team->team_longname = '';
		$team->member_since = 2100;
		$team->retired_from_league = 1900;

		$info = DB::table('team_details')
			->select( 'team_id', 'team_longname', 'league', 'member_since', 'retired_from_league', 'user_id', 'team_longname_history', 'owner_name', 'division' )
			->where( 'team_id', $this->team_id )
			->orderBy( 'member_since' )
			->get();
		foreach( $info as $i ) {
		    if ( '' == $team->team_longname ) {
		    	$team->team_longname = $i->team_longname;
				$team->team_longname_history = $i->team_longname;
			}
		    if ( $i->team_longname_history != "" ) { $team->team_longname_history .= "/" . $i->team_longname_history; }
		    $team->owner_name = $i->owner_name;
		    $team->league = $i->league;
		    $team->division = $i->division;
		    $team->user_id = $i->user_id;
		    if ( $i->member_since < $team->member_since ) { $team->member_since = $i->member_since; }
		    if ( $i->retired_from_league > $team->retired_from_league ) { $team->retired_from_league = $i->retired_from_league; }

		}
		if ( $team->retired_from_league == 2100 ) { $team->retired_from_league="present"; }
		if ( '' == $team->team_longname ) { $team = NULL; }

		return $team;
	}

	private function getTeamDetails() {

		$seasons = array();
		$total_wins = 0;
		$total_losses = 0;
		$total_ties = 0;
		$total_div_wins = 0;
		$total_div_losses = 0;
		$total_div_ties = 0;
		$total_playoff_wins = 0;
		$total_playoff_losses = 0;
		$total_division_finish = 0;
		$total_league_finish = 0;
		$total_power_rank = 0;
		$total_all_play_wins = 0;
		$seasons = 0;
		$division_titles = 0;
		$wildcards = 0;
		$championships = 0;
		$season_detail = array();

		$info = DB::table('team_season_results')
			->select( '*' )
			->where( 'team_id', $this->team_id )
			->orderBy( 'season' )
			->get();
		foreach( $info as $i ) {

			$total_wins += $i->wins;
			$total_losses  += $i->losses;
			$total_ties += $i->ties;
			$total_div_wins += $i->division_wins;
			$total_div_losses += $i->division_losses;
			$total_div_ties += $i->division_ties;
			if ( 'championship' == $i->playoffbracket ) {
				$total_playoff_wins += $i->postseason_wins;
				$total_playoff_losses += $i->postseason_losses;
			}
			$total_division_finish += $i->division_finish;
			$total_league_finish += $i->league_finish;
			$total_power_rank += $i->power_rank;
			$total_all_play_wins += $i->all_play_wins;
			if ( 1 == $i->division_finish ) { $division_titles++; }
			if ( 'y' == $i->wildcard ) { $wildcards ++; }
			if ( 1 == $i->league_finish ) { $championships++; }
			$seasons++;
		}

		$teamDetails = array(
			'total_wins' => $total_wins,
			'total_losses' => $total_losses,
			'total_ties' => $total_ties,
			'total_div_wins' => $total_div_wins,
			'total_div_losses' => $total_div_losses,
			'total_div_ties' => $total_div_ties,
			'total_playoff_wins' => $total_playoff_wins,
			'total_playoff_losses' => $total_playoff_losses,
			'division_titles' => $division_titles,
			'wildcards' => $wildcards,
			'championships' => $championships,
			'seasons' => $seasons
		);
		$teamDetails['total_avg'] = ($total_wins + $total_losses + $total_ties) > 0 ? ( ( $total_wins + $total_ties/2 ) / ($total_wins + $total_losses + $total_ties) ) : 0;
		$teamDetails['total_div_avg'] = ($total_div_wins + $total_div_losses + $total_div_ties) > 0 ? ( ( $total_div_wins + $total_div_ties/2 ) / ($total_div_wins + $total_div_losses + $total_div_ties) ) : 0;
		$teamDetails['total_playoff_avg'] = ($total_playoff_wins + $total_playoff_losses) > 0 ? ( ( $total_playoff_wins ) / ($total_playoff_wins + $total_playoff_losses) ) : 0;

		$teamDetails['avg_league_finish'] = $seasons > 0 ? ( $total_league_finish / $seasons ) : 0;
		$teamDetails['avg_division_finish'] = $seasons > 0 ? ( $total_division_finish / $seasons ) : 0;
		$teamDetails['avg_power_rank'] = $seasons > 0 ? ( $total_power_rank / $seasons ) : 0;
		$teamDetails['avg_all_play_wins'] = $seasons > 0 ? ( $total_all_play_wins / $seasons ) : 0;
		$teamDetails['season_detail'] = $info;

		return $teamDetails;

	}

	private function getH2H() {

		$h2h = array();

		// get team ids and names
		$teams = DB::table('team_details')
			->select( 'team_id', 'team_longname' )
			->where( 'league', 'mtffl' )
			->orderBy( 'team_longname' )
			->get();
		foreach( $teams as $t ) {
			if ( $t->team_id == $this->team_id ) { continue; }
			$h2h[$t->team_id] = array(
				'team_longname' => $t->team_longname,
				'home_wins' => 0,
				'home_losses' => 0,
				'home_ties' => 0,
				'away_wins' => 0,
				'away_losses' => 0,
				'away_ties' => 0,
				'overall_wins' => 0,
				'overall_losses' => 0,
				'overall_ties' => 0
			);
		}

		$matchups = DB::table('team_records')
			->select( 'team_score', 'opp_id', 'opp_score', 'location' )
			->where( 'league', 'mtffl' )->where( 'playoffbracket', 'regular' )->where( 'team_id', $this->team_id )
			->get();

		foreach( $matchups as $m ) {
        	if( 'home' == $m->location ) {
        		if ( $m->team_score > $m->opp_score ) { $h2h[$m->opp_id]['home_wins']++; $h2h[$m->opp_id]['overall_wins']++; }
        		if ( $m->team_score < $m->opp_score ) { $h2h[$m->opp_id]['home_losses']++; $h2h[$m->opp_id]['overall_losses']++; }
        		if ( $m->team_score == $m->opp_score ) { $h2h[$m->opp_id]['home_ties']++; $h2h[$m->opp_id]['overall_ties']++; }
        	} else {
        		if ( $m->team_score > $m->opp_score ) { $h2h[$m->opp_id]['away_wins']++; $h2h[$m->opp_id]['overall_wins']++; }
        		if ( $m->team_score < $m->opp_score ) { $h2h[$m->opp_id]['away_losses']++; $h2h[$m->opp_id]['overall_losses']++; }
        		if ( $m->team_score == $m->opp_score ) { $h2h[$m->opp_id]['away_ties']++; $h2h[$m->opp_id]['overall_ties']++; }
        	}

		}

		return $h2h;

	}

	private function getMatchup( $team_id = 0, $opp_id = 0 ) {

		$matchups = DB::table('team_records')
			->select( 'season', 'week', 'team_score', 'opp_id', 'opp_score', 'location' )
			->where( 'league', 'mtffl' )->where( 'playoffbracket', 'regular' )->where( 'team_id', $team_id )->where( 'opp_id', $opp_id )
			->get();

		return $matchups;
	}

	private function getSchedule( $team_id = 0, $season = 0 ) {

		// get team ids and names
		$teams = DB::table('team_details')
			->select( 'team_id', 'team_longname' )
			->where( 'league', 'mtffl' )
			->orderBy( 'team_longname' )
			->get();
		$team_longnames = array();
		foreach( $teams as $t ) {
			if ( $t->team_id == $team_id ) { continue; }
			$team_longnames[ $t->team_id ] = $t->team_longname;
		}

		$query = DB::table('team_records')
			->select( 'season', 'week', 'team_score', 'opp_id', 'opp_score', 'location' )
			->where( 'league', 'mtffl' )->where( 'team_id', $team_id )->where( 'season', $season )
			->orderBy( 'week' )
			->get();

		$schedule = array();
		foreach( $query as $q ) {
			$schedule[] = array(
            	'season' => $q->season,
            	'week' => $q->week,
				'team_score' => $q->team_score,
				'opp_id' => $q->opp_id,
				'opp_score' => $q->opp_score,
				'location' => $q->location,
				'opp_team_longname' => $team_longnames[ $q->opp_id ],
			);
		}

		return $schedule;
	}

	public function rankTeams( $type = 'bySeason', $order = 'worst' ) {
		$team_list = array();
		if( 'bySeason' == $type ) {
			$title = ucfirst( $order ) . ' by Season';
			for( $season=1998; $season<=$this->mflInfo->season; $season++ ) {
				$teams = DB::table('team_season_results')
					->select('season', 'team_id', 'points_for', 'wins', 'losses', 'ties', 'power_rank', 'all_play_wins',
					'wins', 'losses', 'ties', 'division_wins', 'division_losses', 'division_ties')
					->where('season', $season)
					->where('league', 'mtffl')
					->get();
				if( 'worst' == $order ) {
					$extreme_points_for = 9999;
				} else { // best
					$extreme_points_for = 0;
				}
				$total_points_for = 0;
				foreach( $teams as $t ) {
					$total_points_for += $t->points_for;
					if( 'worst' == $order && $t->points_for < $extreme_points_for ) {
						$team_list[ $season ] = $t;
						$extreme_points_for = $t->points_for;
					}

					if( 'best' == $order && $t->points_for > $extreme_points_for ) {
						$team_list[ $season ] = $t;
						$extreme_points_for = $t->points_for;
					}
				}
				if( $total_points_for > 0 ) {
					$team = $this->getTeam( $team_list[ $season ]->team_id );
					$team_list[ $season ]->teamname = $team->team_longname;
					$team_list[ $season ]->league_average = sprintf( '%0.2f', $total_points_for / 12 );
					$team_list[ $season ]->pct_of_avg = sprintf( '%0.2f', ( $team_list[ $season ]->points_for / $team_list[ $season ]->league_average) * 100 );
				} else {
					unset( $team_list[ $season ] );
				}
	 		}
		}

		return $this->returnView( 'teamsRank', [ 'title' => $title, 'teams' => $team_list ] );
 	}

}
