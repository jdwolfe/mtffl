@extends('layouts.admin')

@section('content')
<div class="container">
	<h1>End Season Results</h1>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="/admin/setEndSeasonResults" method="post">
					<table class="table table-striped">
						<tr><th>Team</th><th>Division</th><th>League</th><th>Wildcard</th></tr>
						@foreach( $teams as $t )
						<tr><td>{{ $t->team_longname }}</td>
							<td><input type="text" name="team_id_{{ $t->team_id }}_division_finish" value="{{ $t->season_results->division_finish }}" size="2" maxlength="2" /></td>
							<td><input type="text" name="team_id_{{ $t->team_id }}_league_finish" value="{{ $t->season_results->league_finish }}" size="2" maxlength="2" /></td>
							<td><input type="text" name="team_id_{{ $t->team_id }}_wildcard" value="{{ $t->season_results->wildcard }}" size="2" maxlength="2" /></td>
						</tr>
						@endforeach
					</table>
					{{ csrf_field() }}
					<button type="submit" value="Submit" class="btn btn-success">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
