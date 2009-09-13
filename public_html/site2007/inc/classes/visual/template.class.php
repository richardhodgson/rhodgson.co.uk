<?php

class Template extends MasterClass {
	
	var $JavascriptEnabled = false;
	var $Javascript;
	
	var $AdditionalStyleSheets = array();
	
	function Template() {
		
		inc('visual/hasjavascript.class.php');
		
		$this->Javascript = new HasJavascript();
		
		$this->JavascriptEnabled = $this->Javascript->HasJavascript;
	}
	
	function makeHeader () {
		
		require_once($this->TemplatePath('site.header'));
		
	}
	
	function makeCoreJavascriptIncludes() {
		
		if ($this->JavascriptEnabled) {
			
			?>
			
			<script type="text/javascript" src="scripts/prototype/prototype.js"></script>
			<script type="text/javascript" src="scripts/scriptaculous/scriptaculous.js"></script>
			<script type="text/javascript" src="scripts/scriptaculous/effects.js"></script>
			
			<?
		}
	}
	
	function makeFooter () {
		
		require_once($this->TemplatePath('site.footer'));
	}
	
	function AddStyleSheet($filename) {
		
		if ($filename) {
			
			$this->AdditionalStyleSheets []= $filename;
		}
	}
	
	function styles() {
		
		?>
		
		<style type="text/css" media="screen">
			
			@import "<?= SITE_ROOT ?>/styles/reset.css";
			@import "<?= SITE_ROOT ?>/styles/global.css";
		<?
		
		if (count($this->AdditionalStyleSheets) > 0) {
			
			foreach ($this->AdditionalStyleSheets as $filename) {
				?>
				
			@import "<?= SITE_ROOT ?>/styles/<?= $filename?>.css";
				<?
			}
		}
		
		?>
			
		</style>
		
		<?
	}
	
}

?>