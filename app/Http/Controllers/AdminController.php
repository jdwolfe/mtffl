<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AdminController extends Controller {
	private $mflUrl = '';
	private $currentSeason = 0;
	private $currentWeek = 0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
		$mflInfo = DB::table('mfl_info')->select('season','mfl_number','mfl_server')->where('league','mtffl')->orderBy('id','desc')->take(1)->first();
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
}
