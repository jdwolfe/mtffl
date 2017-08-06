@extends('layouts.site')

@section('content')

<div>Also try the <a href="/point-calculator">Point Calculator</a></div>
<h1>Scoring Rules</h1>

<table class="table">
	<tr>
		<td><b><i>Number of Passing TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Passing Yardage:</i></b></td>

		<td><b><i>Every 3 Yds = 0.1 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>300+ Yds = +3.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Pass Interception (thrown):</i></b></td>

		<td><b><i>Every 1 Qty = -4.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Rushing TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Rushing Yardage:</i></b></td>

		<td><b><i>Every 1 Yds = 0.1 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>100+ Yds = +3.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Receiving TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Receiving Yardage:</i></b></td>

		<td><b><i>Every 1 Yds = 0.1 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>100+ Yds = +3.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>2 Pt Conversion (Pass):</i></b></td>

		<td><b><i>Every 1 Qty = 2.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>2 Pt Conversion (Rush):</i></b></td>

		<td><b><i>Every 1 Qty = 2.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>2 Pt Conversion (Receive):</i></b></td>

		<td><b><i>Every 1 Qty = 2.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Field Goals Made:</i></b></td>

		<td><b><i>Every 1 Qty = 3.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Make an Extra Point:</i></b></td>

		<td><b><i>Every 1 Qty = 1.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Punt Return TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Kickoff Return TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Fumble Lost:</i></b></td>

		<td><b><i>Every 1 Qty = -4.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Fumble Recovery:</i></b></td>

		<td><b><i>Every 1 Qty = 4.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Fumble Recovery TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Interception (by Defense):</i></b></td>

		<td><b><i>Every 1 Qty = 4.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Intercept Return TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Blocked FG TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Number of Blocked Punt TDs:</i></b></td>

		<td><b><i>Every 1 TDs = 6.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Tackle:</i></b></td>

		<td><b><i>Every 1 Qty = 2.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Assist:</i></b></td>

		<td><b><i>Every 1 Qty = 1.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Sack (by Defense):</i></b></td>

		<td><b><i>Every 0.50 Qty = 2.0 Pts</i></b></td>
	</tr>

	<tr>
		<td><b><i>&#160;</i></b></td>

		<td><b><i>&#160;</i></b></td>
	</tr>

	<tr>
		<td><b><i>Safety:</i></b></td>

		<td><b><i>Every 1 Qty = 2.0 Pts</i></b></td>
	</tr>


</table>

@endsection