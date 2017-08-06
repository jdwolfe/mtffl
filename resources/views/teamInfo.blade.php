@extends('layouts.site')

@section('content')

<div class="row">
	<h1>{{ $teamInfo->team_longname }}</h1>
	<div class="col-md-12">
		<ul>
			<li>Owner: {{ $teamInfo->owner_name }}</li>
			<li>League: {{ strtoupper($teamInfo->league) }} ( {{ $teamInfo->member_since . ' - ' . $teamInfo->retired_from_league }} )</li>
			@if ( $teamInfo->team_longname != $teamInfo->team_longname_history )
				<li>AKA: {{ $teamInfo->team_longname_history }}</li>
			@endif
		</ul>
		<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Regular Season</div>
				<table class="table">
					<tr><th>Seasons</th><th>Wins</th><th>Losses</th><th>Ties</th><th>Avg Rank</th></tr>
					<tr>
						<td>{{ $teamDetails['seasons'] }}</td>
						<td>{{ $teamDetails['total_wins'] }}</td>
						<td>{{ $teamDetails['total_losses'] }}</td>
						<td>{{ $teamDetails['total_ties'] }}</td>
						<td>{{ number_format( $teamDetails['avg_league_finish'], 2) }}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">{{ $teamInfo->division }} Division</div>
				<table class="table">
					<tr><th>Wins</th><th>Losses</th><th>Ties</th><th>Avg Rank</th></tr>
					<tr>
						<td>{{ $teamDetails['total_div_wins'] }}</td>
						<td>{{ $teamDetails['total_div_losses'] }}</td>
						<td>{{ $teamDetails['total_div_ties'] }}</td>
						<td>{{ number_format( $teamDetails['avg_division_finish'], 2) }}</td>
					</tr>
				</table>
			</div>
		</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">Playoffs</div>
					<table class="table">
						<tr><th>Appearances</th><th>Wins</th><th>Losses</th><th>Championships</th><th>Div Titles</th><th>Wildcards</th></tr>
						<tr>
							<td>{{ ($teamDetails['division_titles'] + $teamDetails['wildcards']) }}</td>
							<td>{{ $teamDetails['total_playoff_wins'] }}</td>
							<td>{{ $teamDetails['total_playoff_losses'] }}</td>
							<td><div class="leaguefirst winner-box">{{ $teamDetails['championships'] }} <i class="icon ion-trophy"></i></div></td>
							<td><div class="divisionwinner winner-box">{{ $teamDetails['division_titles'] }} <i class="icon ion-ribbon-a"></i></div></td>
							<td><div class="wildcardwinner winner-box">{{ $teamDetails['wildcards'] }} <i class="icon ion-ribbon-b"></i></div></td>
						</tr>
					</table>
				</div>
			</div>

			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">Misc</div>
					<table class="table">
						<tr><th title="Average Power Rank per Season">Avg PR <span class="glyphicon glyphicon-info-sign"></span></th><th title="Average All Play Wins per Season (out of 182)">Avg APW <span class="glyphicon glyphicon-info-sign"></span></th></tr>
						<tr>
							<td>{{ number_format( $teamDetails['avg_power_rank'], 2) }}</td>
							<td>{{ number_format( $teamDetails['avg_all_play_wins'], 2) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
					<h3>Season Details</h3>
			<div class="panel panel-default">
				<table class="table">
					<tr>
						<th><br>Season</th><th><br>W - L - T</th>
						<th>Division<br>W - L - T</th><th>Div<br>Finish</th>
						<th>Playoff<br>W - L</th><th>League<br>Finish</th>
						<th>Power<br>Rank</th><th>All Play<br>Wins</th>
					</tr>
					<?php
					foreach( $teamDetails['season_detail'] as $d ) {
						$division_div = '';
						$d_icon = '';
						$league_div = '';
						$icon = '';
						if ( 1 == $d->division_finish ) { $division_div = 'divisionwinner winner-box'; $d_icon = ' <i class="icon ion-ribbon-a"></i>'; }
						if ( 'y' == $d->wildcard ) { $division_div = 'wildcardwinner winner-box'; $d_icon = ' <i class="icon ion-ribbon-b"></i>'; }
						switch( $d->league_finish ) {
							case 1: $league_div = 'leaguefirst winner-box'; $icon = ' <i class="icon ion-trophy"></i>'; break;
							case 2: $league_div = 'leaguesecond winner-box'; break;
							case 3: $league_div = 'leaguethird winner-box'; break;
							default: $league_div = ''; $icon = '';
						}
						?>
						<tr>
						<td><a href="{{ url('team/schedule/' . $teamInfo->team_id . '/' . $d->season ) }}">{{ $d->season }}</a></td>
							<td class="">{{ $d->wins . '-' . $d->losses . '-' . $d->ties }}</td>
							<td>{{ $d->division_wins . '-' . $d->division_losses . '-' . $d->division_ties }}</td>

							<td><div class="{{ $division_div }}">{{ $d->division_finish }}<?php echo $d_icon; ?></div></td>

							<td>
							@if ( 'championship' == $d->playoffbracket )
								{{ $d->postseason_wins . '-' . $d->postseason_losses }}
							@endif
							</td><td><div class="{{ $league_div }}">{{ $d->league_finish }}<?php echo $icon; ?></div></td>
							<td>{{ number_format( $d->power_rank, 2) }}</td>
							<td>{{ $d->all_play_wins }}</td>
						</tr>
					<?php
					}
					?>
				</table>

			</div>
		</div>

		<div class="row">
					<h3>Head to Head Results</h3>
			<table class="table">
				<tr><th>Team</th><th>Home</th><th>Away</th><th>Overall</th><th></th></tr>
				@foreach( $headtohead as $opp_id => $h2h )
					<?php
					if ( ( $h2h['overall_wins'] + $h2h['overall_losses'] + $h2h['overall_ties'] ) == 0 ) { continue; }
					?>
					<tr>
						<td><a href="{{ url( '/team/info/' . $opp_id ) }}">{{ $h2h['team_longname'] }}</a></td>
						<td>{{ $h2h['home_wins'] . '-' . $h2h['home_losses'] . '-' . $h2h['home_ties'] }}</td>
						<td>{{ $h2h['away_wins'] . '-' . $h2h['away_losses'] . '-' . $h2h['away_ties'] }}</td>
						<td>{{ $h2h['overall_wins'] . '-' . $h2h['overall_losses'] . '-' . $h2h['overall_ties'] }}</td>
						<td>[ <a href="{{ url('team/matchup/' . $teamInfo->team_id . '/' . $opp_id ) }}">matchups</a> ]</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>

</div>

@endsection