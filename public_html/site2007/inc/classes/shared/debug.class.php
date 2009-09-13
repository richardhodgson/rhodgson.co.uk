<?php

class Debug {
	
	var $traced = array();
	var $allowedList = array(
								'steve',
								'10.0.1.213',
								'localhost',
	                            'fe80::1',
								//'87-194-188-178.bethere.co.uk',
							);
	
	function Debug() {
		
		
	}
	
	function trace($value) {
		
		if(func_num_args() > 1) {
			
			foreach (func_get_args() as $arg) {
				
				$this->trace($arg);
			}
		} else {
			
			if (is_array($value)) {
				
				$this->traced[]= print_r($value, true);
			} else {
				
				$this->traced[]= $value;
			}
		}
	}
	
	function traceWindow() {
		//var_dump(gethostbyaddr($_SERVER['REMOTE_ADDR']));
		if (in_array(gethostbyaddr($_SERVER['REMOTE_ADDR']), $this->allowedList)) {
		
			if (count($this->traced) > 0) {
				
				$values = implode("</p><p>", $this->traced);
			} else {
				
				$values ='No traces detected.';
			}
			
			$randId = rand(1000, 9999);
			
			?>
			
			<style>
			
			div#traceWindow<?= $randId?> {
				position:absolute;
				left: 5px;
				top: 5px;
				width: 40%;
				max-width: 40%;
				z-index:9999;
				overflow: auto;
				
				border: 1px solid #ccc;
				background: #fff;
				padding:2px;
							
			}
			
			</style>
			
			<div id="traceWindow<?= $randId?>">
			
				<p><?= $values ?></p>
			
			</div>
			
			<?
	
		}
	}
}

?>