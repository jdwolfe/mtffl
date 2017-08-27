@extends('layouts.site')

@section('content')

<div class="row">
	<h1>Team History Grid</h1>
	<div class="col-md-12">
		<ul class="list-inline">
		<li><i class="divisionwinner icon ion-ribbon-a" title="Division"></i> = Division Winner</li>
		<li><i class="wildcardwinner icon ion-ribbon-b" title="Wildcard"></i> = Wild Card</li>
    	<li><i class="leaguefirst icon ion-trophy" title="MTFFL Champ"></i> = MTFFL Champ</li>
		<li><a href="/history-grid/all">Show All Teams</a></li>
		</ul>
	</div>
	<div class="col-md-12" style="overflow: auto">
		<table class="history-grid">
            @foreach( $allresults as $teamId => $team )
				<tr>
					<td colspan="20"><h3><a href="/team/info/{{ $teamId }}">{{ $team['team_longname'] }}</a></h3></td>
				</tr>
				<tr>
					@foreach( $seasons as $s )
						<th>{{ $s }}</th>
					@endforeach
				</tr>
				<tr>
					@foreach( $team['results'] as $result )
						<td class="{{ $result['active'] . ' ' . $result['made_playoffs'] }}">{{ $result['overall'] }}<br>{{ $result['division'] }}<br>
                        @if ( 'divisionwinner' == $result['made_playoffs'] ) <i class="divisionwinner icon ion-ribbon-a" title="Division"></i>@endif
                        @if ( 'wildcardwinner' == $result['made_playoffs'] ) <i class="wildcardwinner icon ion-ribbon-b" title="Wildcard"></i>@endif
                        @if ( '1' == $result['league_finish'] ) <i class="leaguefirst icon ion-trophy" title="MTFFL Champ"></i> @endif
						</td>
					@endforeach
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-12">
		&nbsp;
	</div>
</div>

@endsection