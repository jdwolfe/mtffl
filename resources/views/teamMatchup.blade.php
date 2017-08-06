@extends('layouts.site')

@section('content')

<h1><a href="/team/info/{{ $teamInfo->team_id }}">{{ $teamInfo->team_longname }}</a> vs <a href="/team/info/{{ $oppInfo->team_id }}">{{ $oppInfo->team_longname }}</a></h1>
<h3>{{ $record }}</h3>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr><th>Season / Week</th><th>Away Team</th><th></th><th>Home Team</th></tr>
        	<?php
            foreach( $headtohead as $h2h ) {
				$home = ""; $home_class = ""; $home_icon = "";
				$away = ""; $away_class = ""; $away_icon = "";
            	if ( 'away' == $h2h->location ) {
                	$away = $teamInfo->team_longname . ' ' . $h2h->team_score;
                	$home = $oppInfo->team_longname . ' ' . $h2h->opp_score;
					if ( $h2h->team_score > $h2h->opp_score ) {
						$home_class = ""; $home_icon = "";
						$away_class = "gamewinner"; $away_icon = "<span class='icon ion-ios7-americanfootball'></span> ";
					}
					if ( $h2h->team_score < $h2h->opp_score ) {
						$home_class = "gamewinner"; $home_icon = " <span class='icon ion-ios7-americanfootball'></span>";
						$away_class = ""; $away_icon = "";
					}
				} else {
                	$away = $oppInfo->team_longname . ' ' . $h2h->opp_score;
                	$home = $teamInfo->team_longname . ' ' . $h2h->team_score;
					if ( $h2h->team_score > $h2h->opp_score ) {
						$home_class = "gamewinner"; $home_icon = " <span class='icon ion-ios7-americanfootball'></span>";
						$away_class = ""; $away_icon = "";
					}
					if ( $h2h->team_score < $h2h->opp_score ) {
						$home_class = ""; $home_icon = "";
						$away_class = "gamewinner"; $away_icon = "<span class='icon ion-ios7-americanfootball'></span> ";
					}
				}

            	?>
                <tr>
					<td>{{ $h2h->season . ' / ' . $h2h->week }}</td>
					<td><div class="{{ $away_class }}"><?php echo $away_icon; ?>{{ $away }}</div></td>
					<td> @ </td>
					<td><div class="{{ $home_class }}">{{ $home }} <?php echo $home_icon; ?></div></td>
				</tr>
				<?php
            }
			?>
		</table>

	</div>
</div>

@endsection