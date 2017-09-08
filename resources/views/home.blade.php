@extends('layouts.app')

@section('content')
<div class="row">
	<div class="text-center">
		<img src="{{ asset('images/mtffl_logo.png') }}" alt="M T F F L" title="M T F F L" />
	</div>
</div>
@if( $currentHome == 'Champion' )
	@include('homeChampion')
@elseif( $currentHome == 'DraftDay' )
	@include('homeDraftDay')
@elseif( $currentHome == 'Matches' )
	@include('homeMatches')
@endif

@endsection
