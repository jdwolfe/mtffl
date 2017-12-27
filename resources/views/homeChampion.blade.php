<div class="col-md-12">
	<div class="text-center lead">{{ $currentSeason }} Champion</div>
	<div class="text-center">
		<h2><a href="{{ url('/team/info/' . $champ->team_id ) }}">{{ $champ->team_longname }}</a></h2>
		<h3>{{ $champ->owner_name }}</h3>
	</div>
</div>