<?php

class AccessPointStatus extends ServiceStatus {
	
	function output() {
		?>
		
		<div id="siteMap"></div>
		
		<?php
	}
	
	function makeLabel($response) {
		
		//echo "(" . $response->getTargetIp() . ")";
		
		$hostName = $this->pingedHostName;
		
		//echo $response->getReceived() . " : " . $response->getTransmitted();
		
		switch (true) {
			
			case $response->getReceived() == 0:
			
				$state = "red";
				$message = "<b>$hostName is not responding</b>";
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
		
		echo '<div id="" class="'. $state .'">'.  $message .'</div>';
	}
}

?>