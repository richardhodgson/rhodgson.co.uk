<?php

class HasJavascript extends MasterClass {
	
	var $LastCheck;
	var $HasJavascript = false;
	var $Unchecked = false;
	
	function HasJavascript() {
		
		if (!isset($_SESSION['HasJavascript'])) {
			
			$this->Unchecked = true;
		} else {
			
			$this->HasJavascript = $_SESSION['HasJavascript'];
		}
		
	}
	
	
	function Check() {
		
		if ($this->CheckExpired()) {
			
			$_SESSION['HasJavascript'] = true;
		}
		
		
		if ($_GET['go']) {
			
			Redirect($_GET['go']);
		} else {
			
			Redirect('/pages/Welcome');
		}
		
	}
	
	function JavascriptTest() {
		
		
		if (!$this->HasJavascript || $this->Unchecked || $this->CheckExpired()) {
			
			?>
			
			<script type="text/javascript" src="/scripts/site/hasjavascript.js"></script>
			<?
		}
	}
	
	function CheckExpired() {
		
		if ($this->Unchecked) {
			
			return true;
			
		} else {
			
			$this->LastCheck = $_SESSION['LastJavascriptCheck'];
			
			$now = strtotime('now');
			
			if ($now > ($this->LastCheck + 1200)) {
				
				return true;
			} else {
				
				return false;
			}
		
		}
	}
}

?>