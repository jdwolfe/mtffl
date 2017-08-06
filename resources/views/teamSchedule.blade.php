@extends('layouts.site')

@section('content')

<h1><a href="/team/info/{{ $teamInfo->team_id }}">{{ $teamInfo->team_longname }} {{ $teamInfo->season }} Schedule</a></h1>
<h3>{{ $teamInfo->record }}</h3>
<div class="row">

	<div class="chart">
		<canvas id="canvas" height="200px" width="900px"></canvas>
	</div>

<script>

jQuery(document).ready(function ($) {
	var lineChartData = {
		labels : [<?php echo $chart['chart_labels']; ?>],
		datasets : [
			{
				fillColor : "rgba(214,96,17	,0.5)",
				strokeColor : "rgba(189,85,15,1)",
				pointColor : "rgba(189,85,15,1)",
				pointStrokeColor : "#fff",
				data : [<?php echo $chart['chart_data']; ?>]
			}
		]

	}

	var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
});

</script>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr><th>Season / Week</th><th>Away Team</th><th></th><th>Home Team</th></tr>
				<?php
				foreach( $schedule as $s ) {
					$home = ""; $home_class = ""; $home_icon = "";
					$away = ""; $away_class = ""; $away_icon = "";
					if ( 'away' == $s['location'] ) {
									$away = $teamInfo->team_longname . ' ' . $s['team_score'];
									$home = $s['opp_team_longname'] . ' ' . $s['opp_score'];
					if ( $s['team_score'] > $s['opp_score'] ) {
						$home_class = ""; $home_icon = "";
						$away_class = "gamewinner"; $away_icon = "<span class='icon ion-ios7-americanfootball'></span> ";
					}
					if ( $s['team_score'] < $s['opp_score'] ) {
						$home_class = "gamewinner"; $home_icon = " <span class='icon ion-ios7-americanfootball'></span>";
						$away_class = ""; $away_icon = "";
					}
				} else {
									$away = $s['opp_team_longname'] . ' ' . $s['opp_score'];
									$home = $teamInfo->team_longname . ' ' . $s['team_score'];
					if ( $s['team_score'] > $s['opp_score'] ) {
						$home_class = "gamewinner"; $home_icon = " <span class='icon ion-ios7-americanfootball'></span>";
						$away_class = ""; $away_icon = "";
					}
					if ( $s['team_score'] < $s['opp_score'] ) {
						$home_class = ""; $home_icon = "";
						$away_class = "gamewinner"; $away_icon = "<span class='icon ion-ios7-americanfootball'></span> ";
					}
				}

				?>
				<tr>
					<td><?php echo $s['season'] . ' / ' . $s['week']; ?></td>
					<td><div class="<?php echo $away_class; ?>"><?php echo $away_icon . $away; ?></div></td>
					<td> @ </td>
					<td><div class="<?php echo $home_class; ?>"><?php echo $home . $home_icon; ?></div></td>
				</tr>
				<?php
				}
			?>
		</table>

	</div>
</div>

@endsection