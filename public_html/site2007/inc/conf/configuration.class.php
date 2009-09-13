<?php

class Configuration {
	
	var $SettingsSet = 1;
	
	var $TemplateDirectory = '/inc/visual/templates';
	var $databaseConnectionSettings = array(1 => array(
												"host" => "localhost",
												"database" => "rhodgso_portfolio",
												"username" => "root",
												"password" => ""
											),
											2 => array(
												"host" => "localhost",
												"database" => "rhodgso_portfolio",
												"username" => "rhodgso_access",
												"password" => "1119602f2a4489bce2c640da0a076bda2033c948a955317de1b876f2a89468"
											)
									);
											
	function getDatabaseConnectionSettings($settingsSet = null) {
		/*
		print_r($this->databaseConnectionSettings);
		
		foreach ($this->databaseConnectionSettings as $setting) {
			
			//echo "asdasd" . $setting;
			
			return $setting;
		}
		*/
		
		//Default to basic settings
		/*
		if (!$settingsSet) {
			
			$settingsSet = 1;
		}
		*/
		//echo gethostbyaddr($_SERVER['SERVER_ADDR']);
		
		switch ($_SERVER['SERVER_NAME']) {
			
			case 'www.rhodgson.co.uk':
			case 'rhodgson.co.uk':
				$set = 2;
			break;
			
			default:
				$set = 1;
			break;
		}
		
		return $this->databaseConnectionSettings[$set];
	}
	
	function TemplateDirectory() {
		
		return $_SERVER['DOCUMENT_ROOT'] . $this->TemplateDirectory;
	}
}

?>