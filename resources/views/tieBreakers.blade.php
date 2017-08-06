@extends('layouts.site')

@section('content')

<h1>Tiebreaker Rules</h1>

<p>If two or more teams have the same overall head-to-head record.</p>

<p><b>Division Tiebreaker between two teams:</b><br></p>

<div>
	<ol>
		<li>Division head-to-head Record</li>

		<li>Head-to-head results between both teams</li>

		<li>Division Points</li>

		<li>Overall Points</li>

		<li>Coin Flip</li>
	</ol>
</div>

<p>&#160;</p>

<p><b>Division Tiebreaker between three or more teams:</b><br></p>

<div>
	<ol>
		<li>Division head-to-head Record</li>

		<li>Combined head-to-head record of games involving disputed teams only</li>

		<li>Division Points</li>

		<li>Overall Points</li>

		<li>Coin Flip</li>
	</ol>
</div>

<p>&#160;</p>

<p><b>Tiebreaker between two teams for Playoff Seeding:</b><br></p>

<div>
	<ol>
		<li>Head-to-head results between both teams</li>

		<li>Overall Points</li>

		<li>Coin Flip</li>
	</ol>
</div>

<p>&#160;</p>

<p><b>Tiebreaker between three or more teams for Playoff Seeding:</b></p>

<div>
	<ol>
		<li>Combined head-to-head record of games involving disputed teams only</li>

		<li>Overall Points</li>

		<li>Coin Flip<br></li>
	</ol>
</div>

@endsection