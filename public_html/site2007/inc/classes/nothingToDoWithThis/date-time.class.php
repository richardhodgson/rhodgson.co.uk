<?php

class DateTime extends MasterClass {


	var $periodNames = array(0 => 'Good Morning', 'Registration', 'Period 1' ,'Period 2', 'Morning Break', 'Period 3', 'Lunch', 'Period 4', 'Period 5', 'Good Afternoon', 'Good Evening');

	function showClock() {

		?>
		
<!--
<div id="time">&nbsp;</div>
<div id="date">&nbsp;</div>
<div id="period">&nbsp;</div>
	-->
	<div id="container">&nbsp;</div>
		
		<?
	}
	
	function currentTime() {
		
		$hourClock = date("g\:i");
		
		$seconds = date("s");
		
		$amPm = date("a");
		
		$longDate = date("l jS F");


?>
	<div id="time">
		<?= $hourClock?><span id="seconds"><?= $seconds?></span><span id="amPm"><?= $amPm?></span>
	</div>
	
	<div id="date"><?= $longDate ?></div>
	<div id="period"><?= $this->timetable()?></div>

		<?
	}

	function timetable() {

		$currentTime = date("Hi");
		//var $currentTime = (timeSource().getHours());
		//$currentTime -= 1200;

		//return $currentTime;
		if (date("l") == "Wednesday") {


			if ( ($currentTime >= 0) && ($currentTime < 850) ) {

				return $this->periodNames[0];

			} elseif ( ($currentTime >= 850) && ($currentTime < 905) ) {

				return $this->periodNames[1];

			} elseif ( ($currentTime >= 905) && ($currentTime < 1005) ) {

				return $this->periodNames[2];

			} elseif ( ($currentTime >= 1005) && ($currentTime < 1105) ) {

				return $this->periodNames[3];

			} elseif ( ($currentTime >= 1105) && ($currentTime < 1125) ) {

				return $this->periodNames[4];

			} elseif ( ($currentTime >= 1125) && ($currentTime < 1225) ) {

				return $this->periodNames[5];

			} elseif ( ($currentTime >= 1225) && ($currentTime < 1310) ) {

				return $this->periodNames[6];

			} elseif ( ($currentTime >= 1310) && ($currentTime < 1410) ) {

				return $this->periodNames[7];

			} elseif ( ($currentTime >= 1410) && ($currentTime < 1515) ) {

				return $this->periodNames[8];

			} elseif ( ($currentTime >= 1515) && ($currentTime < 1700) ) {

				return $this->periodNames[9];

			} elseif ( ($currentTime >= 1700) && ($currentTime <= 2359) ) {

				return $this->periodNames[10];
			} else {

				return $currentTime;
			}

		} else {

			if ( ($currentTime >= 0) && ($currentTime < 850) ) {

				return $this->periodNames[0];

			} elseif ( ($currentTime >= 850) && ($currentTime < 905) ) {

				return $this->periodNames[1];

			} elseif ( ($currentTime >= 905) && ($currentTime < 1005) ) {

				return $this->periodNames[2];

			} elseif ( ($currentTime >= 1005) && ($currentTime < 1105) ) {

				return $this->periodNames[3];

			} elseif ( ($currentTime >= 1105) && ($currentTime < 1125) ) {

				return $this->periodNames[4];

			} elseif ( ($currentTime >= 1125) && ($currentTime < 1225) ) {

				return $this->periodNames[5];

			} elseif ( ($currentTime >= 1225) && ($currentTime < 1310) ) {

				return $this->periodNames[6];

			} elseif ( ($currentTime >= 1310) && ($currentTime < 1410) ) {

				return $this->periodNames[7];

			} elseif ( ($currentTime >= 1410) && ($currentTime < 1515) ) {

				return $this->periodNames[8];

			} elseif ( ($currentTime >= 1515) && ($currentTime < 1700) ) {

				return $this->periodNames[9];

			} elseif ( ($currentTime >= 1700) && ($currentTime <= 2359) ) {

				return $this->periodNames[10];
			} else {

				return $currentTime;
			}
		}
	}
	
}
?>