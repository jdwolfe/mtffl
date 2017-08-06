@extends('layouts.site')

@section('content')

<h1>MTFFL Hall of Champions</h1>
<div class="row">

<table class="table division-winners">
	<tr class="division-winners-header">
		<th class="division-winners-set season">Season</th>
		<th class="team leaguefirst winner-box">1st Place <i class="icon ion-trophy"></i></th>
		<th class="team leaguesecond winner-box">2nd Place <i class="icon ion-ribbon-a"></i></th>
		<th class="team leaguethird winner-box">3rd Place <i class="icon ion-ribbon-b"></i></th>
	</tr>
	@foreach( $seasons as $s )
	<tr class="division-winners-row">
		<td class="season">{{ $s->season }}</td>
		<td class="team"><a href="/team/info/{{ $s->place1_id }}">{{ $s->place1 }}</a></td>
		<td class="team"><a href="/team/info/{{ $s->place2_id }}">{{ $s->place2 }}</a></td>
		<td class="team"><a href="/team/info/{{ $s->place3_id }}">{{ $s->place3 }}</a></td>
	</tr>
	@endforeach
</table>

</div>
@endsection