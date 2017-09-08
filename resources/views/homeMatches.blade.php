<h3>{{ $season }} Week {{ $week }}</h3>
<div class="row">
	<div class="col-md-12">
		<table class="table">
		@foreach( $matches as $m )
		<tr>
			<td colspan="3">{{ $m->away_team }}</td>
			<td class="matchup-score" rowspan="2"><b>{{ $m->away_score }}</b></td>
			<td></td>
			<td class="matchup-score" rowspan="2"><b>{{ $m->home_score }}</b></td>
			<td colspan="3">{{ $m->home_team }}</td>
		</tr>
		<tr class="matchup-sub-info">
			<td>IP: <b>{{ $m->away_ip }}</b></td>
			<td>YTP: <b>{{ $m->away_ytp }}</b></td>
			<td>RT: <b>{{ $m->away_gmr }}</b></td>
			<td>vs</td>
			<td>IP: <b>{{ $m->home_ip }}</b></td>
			<td>YTP: <b>{{ $m->home_ytp }}</b></td>
			<td>RT: <b>{{ $m->home_gmr }}</b></td>
		</tr>
		@endforeach
		</table>
	</div>
	<div class="col-sm-12">
		<ul class="list-inline matchup-sub-info">
			<li>Updated: {{ $matches_update }}</li>
			<li>IP = In Play</li>
			<li>YTP = Yet to Play</li>
			<li>RT = Remaining Time</li>
		</ul>
	</div>
</div>