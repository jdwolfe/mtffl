@extends('layouts.admin')

@section('content')
<div class="container">
	<h1>Dashboard</h1>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Current Home: {{ $currentHome }}</div>
				<div class="panel-body">
					<ul>
						<li><a href="{{ url('admin/showHome/Champion') }}">Champion</a></li>
						<li><a href="{{ url('admin/showHome/DraftDay') }}">Draft Day</a></li>
						<li><a href="{{ url('admin/showHome/MatchUps') }}">Match Ups</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Current Season: {{ $currentSeason }}<br>Week: {{ $currentWeek }}</div>
				<div class="panel-body">
					Advance to next season by picking the Tuesday before the first game.
					<form action="{{ url('admin/newSeason') }}" method="post">
						<input type="text" name="nfl_start" id="nfl_start" value="{{ $nfl_start }}" /><br>
						MLF Server: <input type="text" name="mfl_server" value="" /><br>
						MLF Number: <input type="text" name="mfl_number" value="" /><br>
						{{ csrf_field() }}
						<button type="submit" value="Next" class="btn btn-success">Next</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
