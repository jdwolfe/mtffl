@extends('layouts.site')

@section('content')

<script language="JavaScript" type="text/javascript">
	function calcPoints(form) {
		var modpass=form.passyds.value%3
		var passyds=(form.passyds.value - modpass)/30
		if ( form.passyds.value >= 300 ) { passyds=passyds+3 }
		var rushyds=form.rushyds.value/10
		if ( form.rushyds.value >= 100 ) { rushyds=rushyds+3 }
		var recyds=form.recyds.value/10
		if ( form.recyds.value >= 100 ) { recyds=recyds+3 }
		var tds=form.tds.value*6
		var two_pts=form.two_pts.value*2
		var to_minus=form.to_minus.value*-4
		var to_plus=form.to_plus.value*4
		var tackles=form.tackles.value*2
		var ast_tackles=form.ast_tackles.value*1
		var sacks=form.sacks.value*4
		var safety=form.safety.value*2
		var fg=form.fg.value*3
		var xp=form.xp.value*1
		var total=passyds+rushyds+recyds+tds+two_pts+to_minus+to_plus+tackles+ast_tackles+sacks+safety+fg+xp
		form.total.value=formatPoints(total)
	}
	function formatPoints (expr) {
		var str=""+Math.round(eval(expr) * 10)
		var decpoint=str.length-1
		return str.substring(0,decpoint)+"."+str.substring(decpoint,str.length);
	}

</script>
<h1>Point Calculator</h1>
<form>
	<table class="table">
		<tr>
			<td>Passing yards</td>

			<td ><input name="passyds" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Rushing yards</td>

			<td><input name="rushyds" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Receiving yards</td>

			<td><input name="recyds" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Total TD's&nbsp;(passing, rushing, receiving, defense or special teams)</td>

			<td><input name="tds" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>
				Interceptions thrown plus fumbles lost
			</td>

			<td><input name="to_minus" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>2-pt conversion (pass, rush or receive)</td>

			<td><input name="two_pts" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Interceptions made or fumbles recovered</td>

			<td><input name="to_plus" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Tackles</td>

			<td><input name="tackles" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Asst Tackles</td>

			<td><input name="ast_tackles" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Sacks</td>

			<td><input name="sacks" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Safety</td>

			<td><input name="safety" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td> Field Goals Made</td>

			<td><input name="fg" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Extra Points Made</td>

			<td><input name="xp" type="text" onkeyup="calcPoints(this.form)" value="0" size="3" maxlength="3"></td>
		</tr>

		<tr>
			<td>Point Total</td>

			<td><input type="text" name="total" size="5" maxlength="5" onkeyup="calcPoints(this.form)" style="font-size: 2em; border: 2px solid #FF0000"></td>
		</tr>
	</table><br>
</form>


@endsection