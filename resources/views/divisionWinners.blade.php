@extends('layouts.app')

@section('content')

<h1>MTFFL Division Winners</h1>
<div class="row">
<table class=" table division-winners">
	<tr class="division-winners-header">
		<th class="division-winners-set season">Season</th>
		<th class="team">Paydirt Division</th>
		<th class="team">Red Zone Division</th>
		<th class="team">Gridiron Division</th>
		<th class="team">Wild Card</th>
	</tr>
	@foreach( $seasons as $s )
	<tr class="division-winners-row">
		<td class="season">{{ $s->season }}</td>
		<td class="team"><a href="/team/info/{{ $s->division1_id }}">{{ $s->division1 }}</a></td>
		<td class="team"><a href="/team/info/{{ $s->division2_id }}">{{ $s->division2 }}</a></td>
		<td class="team"><a href="/team/info/{{ $s->division3_id }}">{{ $s->division3 }}</a></td>
		<td class="team"><a href="/team/info/{{ $s->wildcard_id }}">{{ $s->wildcard }}</a></td>
	</tr>
	@endforeach
</table>

</div>
@endsection