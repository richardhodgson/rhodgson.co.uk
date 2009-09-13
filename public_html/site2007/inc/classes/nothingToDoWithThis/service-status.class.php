<?php

class ServiceStatus extends MasterClass {

	var $ServerPing;
	var $pingedHostName;
	var $NetPingArguments = array('timeout' => 100, 'count' => 1, 'ttl' => 5);

	function ServiceStatus() {

		//require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/classes/shared/ServerPing.class.php");

		//$this->ServerPing = new ServerPing();

		require("Net/Ping.php");

		//Net_Ping::setArgs($this->ServerPing);
		
		$this->ServerPing = Net_Ping::factory();
		
		/*$this->ServerPing = new Net_Ping();
		
		$this->ServerPing->setArgs($this->NetPingArguments);
		
		$this->ServerPing->factory();*/
		
		
		
	}
	
	function output() {
		
		?>
		
		<style>
		
		ul {
		  font-size:24pt;
		}
		
		</style>
		
		<!--<div id="count">&nbsp;</div>-->
		<ul id="serverContainer"></ul>
		
		<?
	}
	
	function ping($addess) {
		
		//echo $addess;

		if(PEAR::isError($this->ServerPing))
		{
			
			echo $this->ServerPing->getMessage();
		} else {
			
			$this->ServerPing->setArgs($this->NetPingArguments);
			
			$response = $this->ServerPing->ping($addess);
			
			$this->getHostName($addess);
			
			/*
			echo "<pre>";
			print_r($response);
			echo "</pre>";
			*/
			
			$this->makeLabel($response);
			//echo $response->getReceived() . " : " . $response->getTransmitted();
			
			
		}
	}
	
	function makeLabel($response) {
		
		//echo "(" . $response->getTargetIp() . ")";
		
		if ($this->pingedHostName == "Fyndoune.cc" || $this->pingedHostName == "64.233.161.147") {
			
			$hostName = "Internet";
			
			$notRespondingMsg = ' connection lost';
			
		} else {
			
			$hostName = $this->pingedHostName;
			
			$notRespondingMsg = 'is not responding';
		}
		
		
		//echo $response->getReceived() . " : " . $response->getTransmitted();
		
		switch (true) {
			
			case $response->getReceived() == 0:
			
				$state = "red";
				$message = "<b>$hostName $notRespondingMsg</b>";
			break;
			
			case $response->getTransmitted() == $response->getReceived():
			
				$state = "green";
				$message = "<b>$hostName</b> is available for use";
			break;
			
			
			case $response->getTransmitted() > $response->getReceived():
			
				$state = "yellow";
				$message = "<b>$hostName</b> is available, yet busy";
			break;
		}
		
		$DOMfriendlyName = $this->DOMfriendlyName($hostName);
		
		echo '<div id="'. $DOMfriendlyName . '" class="'. $state .'">';
		echo $message;
		echo "<span>(Last checked: ". date("H:i:s") .")</span>";
		echo "</div>";
	}
	
	function getHostName($value) {
		
		//$hostName = ucfirst(strtolower(gethostbyaddr($response->getTargetIp())));
		
		if (count(explode(".", $value)) == 4) {
			
			$this->pingedHostName = ucfirst(strtolower(gethostbyaddr($value)));
		} else {
			
			$this->pingedHostName = ucfirst(strtolower($value));
		}
	}
	
	function DOMfriendlyName($string) {
		
		return str_replace(".", "-", $string);
	}
}
?>