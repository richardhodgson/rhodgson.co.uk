<?php

class MasterClass extends Database {
	
	//doesn't work....
	function ReturnValue($VariableName) {
		
		$VariableName = '$this->' . $VariableName;
		
		if (isset($$VariableName)) {
			
			return $$VariableName;
		} else {
			
			return false;
		}
	}
	
	function ConvertToUrlLabel($string) {
		
		$string = str_replace(' ', '-', $string);
		
		return $string;
	}
	
	function ConvertFromUrlLabel($string) {
		
		$string = str_replace('-', ' ', $string);
		
		return $string;
	}
	
	function TemplatePath($name) {
		
		require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/conf/configuration.class.php');
		
		$Configuration = new Configuration();
		
		$prepend = $Configuration->TemplateDirectory();
		
		$file = $prepend . '/' . $name . '.template.php';
		
		if (is_file($file)) {
			
			return $file;
			
		} else {
			
			return false;
		}
	}
	
	/*================================================================== reminants of Digital Display ==*/
	
	function informalTime ($value, $justLoggedMessage = 'Just logged') {
		
		$unixstamp = strtotime($value);
		$now = strtotime("now");
		
		$difference = $now - $unixstamp;
		
		$this->informalDate($value);
		
		switch ($difference) {
			
			case $difference < 60:
			
				return $justLoggedMessage;
			break;
			
			//until one hour...
			case $difference < 3600:
				return ceil(($difference / 60)) . " minutes ago";
			break;
			
			// 8 hours...
			case $difference < 28800:
				return ceil((($difference / 60) / 60)) . " hours ago";
			break;
			
			default:
				return date("g:i a", $unixstamp) . " " . $this->informalDate($value);
			break;
			
		}
		
	}
	
	function informalDate($value) {
		
		$unixstamp = strtotime($value);
		
		$then = date("Ymd", $unixstamp);
		$today = date("Ymd");
		
		$difference = $today - $then;
		
		$this->trace($then, $today, $difference);
		
		
		switch ($difference) {
			
			case 0:
			
				return "today";
			break;
			
			case 1:
				return "yesterday";
			break;
			
			case $difference >= 2:
			
				return $difference . " days ago";
			break;
			
			default:
				
				return date("l jS \o\f F");
			break;
		}
	}
	
	function firstnameCrop($firstname, $lastname, $cropAmount = false) {
		
		//I don't actually understand how this works, but it does - we get paid for what we provide, not how we provide it.
		
		//Check if this has never been run before
		if (!$this->prevfirstnameCrop) {
			
			$firstRun = true;
			$this->prevfirstnameCrop = $firstname;
			$this->prevlastnameCrop = $lastname;
		}
		
		
		//if first time or last names don't match then no need to check 
		if ($firstRun || $this->prevlastnameCrop !== $lastname) {
			
			$this->prevfirstnameCrop = $firstname;
			$this->prevlastnameCrop = $lastname;
			
			return ucfirst($lastname) . ", " . ucfirst(substr($firstname, 0 , 1));
		} else {
			
			//$this->trace($this->prevfirstnameCrop);
			
			
			if (!$cropAmount) {
				
				$cropAmount = 1;
			}
			
			$firstnameCropped = substr($firstname, 0 , $cropAmount);
			$prevfirstnameCropped = substr($this->prevfirstnameCrop, 0 , $cropAmount);
			
			//$this->trace($firstnameCropped, $prevfirstnameCropped);
			
			if ($firstnameCropped !== $prevfirstnameCropped) {
				
				$this->prevfirstnameCrop = $firstname;
				$this->prevlastnameCrop = $lastname;
				
				return ucfirst($lastname) . ", " . ucfirst($firstnameCropped);
				
			} else {
				
				$this->prevfirstnameCrop = $firstname;
				$this->prevlastnameCrop = $lastname;
				
				return ucfirst($lastname) . ", " . ucfirst(substr($firstname, 0 , 2));
			}
			
		}
	}
	
	function usernameListDropDownBox($name) {
		
		$this->retrieveUsernames();
		
		if ($this->returnedRows()) {
			
			?>
			
			<select name="<?= $name?>" id="<?= $name?>">
			<?
			
			while ($row = $this->fetchRow()) {
				
				?>
				
				<option value="<?= $row['username']?>"><?= $this->firstnameCrop($row['firstname'], $row['lastname'])?></option>
				<?
			}
			
			?>
			
			</select>
			<?
			
		}
	}
	
	//========================================================================== Encryption ====

	/*
	Generates a unique hash from plain text. If second argument is passed, generates identical
	hash with matching plain text.
	*/
	function Encrypt($plainText, $salt = null) {
		
	    if ($salt === null) {
	    	
	        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
	    } else {
	    	
	        $salt = substr($salt, 2, SALT_LENGTH);
	    }
	
	    return rand(10,99) . $salt . sha1($salt . $plainText . HASH_SALT);
	}
	
	/*
	Usage: encyrptCompare($_SESSION['project'], $_GET['project'])
	Returns TRUE on match
	*/
	function EncryptCompare($stored, $compareWith) {
		
		$reEncrypt = substr($this->Encrypt($compareWith, $stored), 2);
		$stored = substr($stored, 2);
		
		if ($stored == $reEncrypt) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	function EncryptedCompare($compareThis, $withThat) {
		

		$compareThis = substr($compareThis, 2);
		
		$withThat = substr($withThat, 2);
		
		if ($compareThis == $withThat) {
			
			return true;
			
		} else {
		
			return false;
		}
	}
	
	function GenerateKey() {
		
		foreach (func_get_args() as $argument) {
			
			$values .= $argument;
		}
		
		
		
	}

	
	
	
	
}

?>