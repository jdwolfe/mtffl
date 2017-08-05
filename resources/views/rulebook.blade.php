@extends('layouts.app')

@section('content')

<h1>MTFFL Rulebook</h1>

<p><b>This is the official rule book and supercedes any previous posting or published rule book.</b></br>
Last Modified: 2015-08-22 <a href="rule-amendments/#update20150822">?</a></p>

<ol>
	<li>
		<div class="ruleheader">
			League Structure
		</div>

		<ol>
			<li>
				<div>
					The league has twelve teams, divided into 3 Divisions.
				</div>
			</li>

			<li>
				<div>
					Head-to-head games are played every week. The team with the most fantasy points scored in the head-to-head contest will be declared the winner. A tie is awarded to each team if both sides score equal points.
				</div>
			</li>

			<li>
				<div>
					Each owner may only own one team per league
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Schedule
		</div>

		<ol>
			<li>
				<div>
					The <b>regular season</b> is played during the NFL's Weeks 1 to 14.
				</div>
			</li>

			<li>
				<div>
					Each team plays its division rival twice and everyone else once.
				</div>
			</li>

			<li>
				<div>
					In each weekly contest one team is designated as the Home Team. <span class="rule-change-strike">which receives a 7point bonus referred to as Home Field Advantage (<b>HFA</b>). <a href="rule-amendments/#amendment6">amendment #6</a></span> <a href="rule-amendments/#amendment11">amendment #11</a>
				</div>
			</li>

			<li>
				<div>
					Each team will have an equal amount of home and away games. A home-and-away series will be played for each division rival, meaning you will play each division rival at both home and away during each season.
				</div>
			</li>

			<li>
				<div>
					Typically, non-divisional games are scheduled for the weeks that the NFL teams have their bye weeks. The NFL schedule changes from year to year, but the divisional matchups will try to be scheduled when none of the NFL teams are on bye.
				</div>
			</li>

			<li>
				<div>
					The schedule is copied from the previous year and rotated in the following manner.
				</div>

				<table width="80%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="50%" valign="top">
							<div class="text-center">
								Divisional Game Rotation<br>
								Move Division Game #1 to #2<br />
								Move Division Game #2 to #3<br />
								Move Division Game #3 to #4<br />
								Move Division Game #4 to #5<br />
								Move Division Game #5 to #6<br />
								Move Division Game #6 to #1
							</div>
						</td>

						<td width="47%">
							<div class="text-center">
								Non-Division Game Rotation<br>
								Move and flip Non-Division Game #1 to #2<br />
								Move and flip Non-Division Game #2 to #3<br />
								Move and flip Non-Division Game #3 to #4<br />
								Move and flip Non-Division Game #4 to #5<br />
								Move and flip Non-Division Game #5 to #6<br />
								Move and flip Non-Division Game #6 to #7<br />
								Move and flip Non-Division Game #7 to #8<br />
								Move and flip Non-Division Game #8 to #1
							</div>
						</td>
					</tr>
				</table>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Playoffs
		</div>

		<ol>
			<li>
				<div>
					The <b>post-season</b> is during the NFL's 15th and 16th week.
				</div>
			</li>

			<li>
				<div>
					Four teams make the playoffs each year. The teams with the best overall head-to-head records from each of the three divisions will go to the playoffs.
				</div>
			</li>

			<li>
				<div>
					Teams with the same overall record will use our <a href="/tie-breakers">tiebreaker scheme</a> to determine the division winner.
				</div>
			</li>

			<li>
				<div>
					The wild card team is the one who scores the most fantasy points (but doesn't win their division).
				</div>
			</li>

			<li>
				<div>
					Teams will seeded by best overall record, with the wild card always receiving the 4th seed. (Ties in overall record are decided by our <a href="/tie-breakers">tiebreaker scheme</a>).
				</div>
			</li>

			<li>
				<div>
					The first week of the playoffs will match seed #1 with #4 and #2 with #3. The winners in the first week will play each other in the second week of the playoffs to determine the League Championship.
				</div>
			</li>

			<li>
				<div>
					The other two teams will play to decide third place.
				</div>
			</li>

			<li>
				<div>
					The team with the lowest seed number will have <b>HFA</b>.
				</div>
			</li>

			<li>
				<div>
					<span class="rule-change-strike">The teams that don't make the playoff will be grouped into mini-tournament brackets to determine the draft order for the next year. Teams ranked 9-12 will have their own tournament to determine draft picks 1 through 4. Teams ranked 5-8 will have their own tournament to determine draft picks 5 through 8.</span> <a href="rule-amendments/#amendment4">amendment #4</a><br>
					Teams that don't make the playoff will no longer have their draft position determined by a post season tournament.<a href="rule-amendments/#amendment10">amendment #10</a>
				</div>
			</li>

			<li>
				<div>
					All second round playoff games will be played on 'neutral' fields and will be exempt from the Home Field Advantage (HFA) rule. <a href="rule-amendments/#amendment7">amendment #7</a>
				</div>
			</li>

			<li>
				<div>
					Games ending in a tie in postseason games are broken by the total number of starter points in the regular season. <a href="rule-amendments/#amendment5">amendment #5</a>
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			League Fees/Prizes
		</div>

		<ol>
			<li>
				<div>
					League Fees are due from each owner on or before <a href="/draft-day">Draft Day</a> which is determined and posted by The Commish.
				</div>
			</li>

			<li>
				<div>
					Some money is taken out to pay for the software that runs the league, any <a href="/trophies">trophies</a> that we buy and <a href="/cost">other costs</a>.
				</div>
			</li>

			<li>
				<div>
					Typical breakdown is 3rd place is rewarded with 1 times the league fee.	2nd place is rewarded with 3 times the league fee.	1st place gets the remainder after all other league costs are subtracted.
				</div>
			</li>
		</ol>
	</li>


	<li>
		<div class="ruleheader">
			The Draft
		</div>

		<ol>
			<li>
				<div>
					A live draft is held every year at a place/time to be determined. Usually the last weekend in August..
				</div>
			</li>

			<li>
				<div>
					Every owner needs to be present on <a href="/draft-day">Draft Day</a>.
				</div>
			</li>

			<li>
				<div>
					The Draft is a full live draft to fill each owner's roster.
				</div>
			</li>

			<li>
				<div>
					All NFL players are available in the draft including NFC and AFC players, offensive and defensive players and rookies.
				</div>
			</li>

			<li>
				<div>
					The number of rounds is determined by the difference in the number of Keeper players allowed subtracted from the Maximum allowable roster size.
				</div>
			</li>

			<li>
				<div>
					Each pick in the draft is limited to 2 minutes (120 seconds) per pick in the first three rounds and 1 minute (60 second) per pick.
				</div>
			</li>

			<li>
				<div>
					Draft order is determined bythe previous years performance. <span class="rule-change-strike">The eight teams that don't make the playoffs are ranked according to their overall record. The team with the worst record gets the first pick, best record gets the eighth pick.</span> <a href="rule-amendments/#amendment10">amendment #10</a> is a reversal of <a href="rule-amendments/#amendment4">amendment #4</a>
				</div>
			</li>

			<li>
				<div>
					<span class="rule-change-strike">Draft positions nine through 12 are ordered by the previous year's playoff results. League Champion will always pick twelfth and the fourth place team will pick ninth.</span> <a href="rule-amendments/#amendment10">amendment #10</a> Draft Positions are determined by the non-divisional tiebreaking procedures with the worst team getting the first pick and the best team getting the eigth pick.
				</div>
			</li>

			<li>
				<div>
					Teams will pick in the same position in each round.
				</div>
			</li>

			<li>
				<div>
					Trades may affect the individual picks in the rounds.
				</div>
			</li>

			<li>
				<div>
					Exceptions in this draft sequence are made in a league's first year.
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Roster
		</div>

		<ol>
			<li>
				<div>
					Each team's roster may contain up to 25 players including quarterbacks (QB), running backs (RB), wide receivers (WR), tight ends (TE), place kickers (K), defensive linemen (DL), linebackers (LB) and defensive backs (DB).
				</div>
			</li>

			<li>
				<div>
					There is no minimum or maximum for each individual position, but it is expected that each team maintain enough of each position to field a competitive starting lineup each week.
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Starting Lineup
		</div>

		<ol>
			<li>
				<div>
					The <b>Offensive Starting Lineup</b> should be a valid NFL formation. There will always be only one quaterback with 5 other offensive players made up of Running Backs, Wide Receivers and Tight Ends. According to NFL rules, there must be seven players on the line of scrimmage, five of these players are the interior linemen. By MTFFL rules Tight Ends must always be on the line of scrimmage and Running Backs cannot be on the line. Receivers can be on or off the line.
				</div>
			</li>

			<li>
				<p>Offensive Lineup Examples:<br>
				<ul class="list-inline">
				<li><img src="/images/3wide.gif" width="150" height="75" alt="Example: 3 wide" title="Example: 3 wide"></li>
				<li><img src="/images/bone.gif" width="150" height="75" alt="Example: Wish Bone" title="Example: Wish Bone"></li>
				<li><img src="/images/shoot.gif" width="150" height="75" alt="Example: Run &amp; Shoot" title="Example: Run &amp; Shoot"></li>
				<li><img src="/images/single.gif" width="150" height="75" alt="Example: Single Back" title="Example: Single Back"></li>
				</ul>
				</p>
			</li>

			<li>
				<div>
					The <b>Defensive Starting Lineup</b> consists of two Defensive Lineman, two Linebackers and two Defensive Backs.
				</div>
			</li>

			<li>
				<div>
					Each team also has one Kicker for a total of thirteen starters each week.
				</div>
			</li>
			<li>
				<div>Because of a <a href="http://mtffl.com/smackroom/viewtopic.php?f=1&t=2349">bug</a> we found in the MyFantasyLeague.com software, we now use their <a href="http://football5.myfantasyleague.com/2015/support?L=12293&&CATEGORY=Players%20%26%20Lineups&SUBCATEGORY=Lineup%20Setup">official formations</a> as the only valid lineups.<br>
                We allow:
				<ul>
					<li>Full T:&nbsp;RB:3, WR:1, TE:1</li>
					<li>Pro Set:&nbsp;RB:2, WR: 2, TE:1</li>
					<li>Single Back:&nbsp;RB:1, WR:3, TE:1</li>
					<li>Run and Shoot:&nbsp;RB:1, WR:4</li>
					<li>Double Tight:&nbsp;RB:2, WR:1, TE:2</li>
					<li>Ace:&nbsp;RB:1, WR:2, TE:2</li>
					<li>Spread:&nbsp;RB:2, WR:3</li>
					<li>Full House:&nbsp;RB:3, TEL:2</li>
					<li>5 Wide:&nbsp;WR:5</li>
					<li>Power I:&nbsp;RB:3, WR:2</li>
					<li>Shotgun 4-wide:&nbsp;WR:4, TE:1</li>
					<li>Shotgun 3-wide:&nbsp;WR:3, TE:2</li>
				</ul>
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Starting Lineup Deadline
		</div>
		<div>
			<ol>
				<li>Starting Lineups are to be submitted before the start of the first game of the NFL week.</li>

				<li>NOTE: In the case of Early Games (meaning non-Sunday games), teams may submit a partial lineup containing the NFL teams playing Early Games. These players can not be removed from the starting lineup after the game has started. Other players from the NFL teams Early Games can not be added after the Early Games start. Players on other NFL teams may be moved as normal.</li>
			</ol>
		</div>
	</li>

	<li>
		<div class="ruleheader">
			Scoring
		</div>
		<div>
			<ol>
				<li>Points are awarded using this <a href="scoring-rules/">Scoring Formula</a>. <a href="rule-amendments/#amendment3">amendment #3</a></li>

				<li>Stats are provided through the software hosted by <a href="http://www.myfantasyleague.com" target="_blank">MyFantasyLeague.com</a>. <b>Stats are not debatable</b>. If an error is detected in the stats, inform The Commish who will address the error with proper officials at MyFantasyLeague.com who will contact their stat provider for confirmation.</li>

				<li>Players earn points for offensive, defensive and special teams plays. This rule, know as 'the Deion Rule' rewards players who play on both sides of the ball or for offensive players brave enough to tackle Warren Sapp returning a fumble.</li>

				<li>The home team will receive a 7 point bonus known as the Home Field Advantage (HFA) rule. <a href="rule-amendments/#amendment6">amendment #6</a></li>
			</ol>
		</div>
	</li>

	<li>
		<div class="ruleheader">
			Injured Reserve
		</div>
		<div>
			<ol>
				<li>Each team may place a player on Injured Reserve (IR) when that player <b>is listed as OUT</b> by the NFL's official injury report (<a href="http://www.nfl.com/injuries" target="_blank">www.nfl.com/injuries</a>). Players listed as Probable, Questionable or Doubtful will not be allowed to go on IR.</li>

				<li>Players on IR do not count against the Roster Limit.</li>
			</ol>
		</div>
	</li>

	<li>
		<div class="ruleheader">
			Keepers
		</div>

		<ol>
			<li>
				<div>
					At the beginning of the NFL season, each team may "<b>Freeze</b>" a certain amount of players on their roster.
				</div>
			</li>

			<li>
				<div>
					The remaining players are returned to the general pool of players before Draft Day.
				</div>
			</li>

			<li>
				<div>
					Currently each team may freeze 7 players. <a href="rule-amendments/#amendment1">amendment #1</a> <a href="rule-amendments/#amendment2">amendment #2</a>
				</div>
			</li>

			<li>
				<div>
					The Commish will decide and announce the Freeze Date.
				</div>
			</li>
		</ol>
	</li>

	<li>
		<div class="ruleheader">
			Trades
		</div>
		<div>
			<ol>
				<li>Trades are allowed between any two or more teams in the same league.</li>

				<li>Trades may involve players and/or future draft picks.</li>

				<li>The fairness of trades is judged by the other owners in the league. Unfair trades must be contested by <b>at least four owners</b> within <b>three days</b> of the announced trade. During this evaluatory period, players may be inserted in starting lineups and are allowed to earn points for their team. The Commish will review a contested trade in a open forum with all owners of the league. If a trade is decided to be unfair, the players will be returned to their original team and points earned by the players involved will be expunged from the scores and the outcomes of the games re-calculated.</li>

				<li>This league has a trade deadline which prohibits trades from the start of Week 11 games until the end of the MTFFL championship game.<a href="rule-amendments/#amendment8">amendment #8</a></li>
			</ol>
		</div>
	</li>

	<li>
		<div class="ruleheader">
			Transactions
		</div>

		<ol>
			<li>
				<div>
					Transactions include dropping players from a team's roster, adding players to a roster, trades, IR movement and starting lineup changes.
				</div>
			</li>

			<li>
				<div>
					<b>All Transactions must take place on the MyFantasyLeague.com website</b> <a href="rule-amendments/#amendment9">amendment #9</a>. This website is the official record for rosters and starting lineups.
				</div>
			</li>

			<li>
				<div>
					In special cases, The Commish may receive a transaction over phone or in person. But your computer better be a melted glob of plastic and metal and you need to be hundreds of miles from the nearest library, campus computer lab or friend/relative/neighbor with a computer.
				</div>
			</li>
		</ol>
	</li>
</ol>

<p><b>The owners can ammend any rules by getting 2/3 of the owners to agree. Meaning eight votes in favor of changing a rule listed on this web site.</b></p>


@endsection