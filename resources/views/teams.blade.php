@extends('layouts.app')

@section('content')

<h1>MTFFL Teams</h1>
<ul>
<?php $division = ''; ?>
	@foreach( $teams as $t )
		<?php if( $division != $t->division ) {
			$division = $t->division;
		?>
</ul>
<h2>{{ $division }}</h2>
<ul>
		<?php
		}
		?>
	<li><a href="{{ url('team/info/' . $t->team_id) }}">{{ $t->team_longname }}</a>
	@if( 'active' == $t->status )
		(est. {{ $t->member_since }})
	@else
		({{ $t->member_since }} - {{ $t->retired_from_league }})
	@endif
	</li>
	@endforeach
</ul>

<div>
	<a href="{{ url('teams/all') }}">Show Retired Teams</a>
</div>
@endsection