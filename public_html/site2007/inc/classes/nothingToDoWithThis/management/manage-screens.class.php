<?php

class ManageScreens extends MasterClass {
	
	var $MachineNames = array(	"dd01",
								"dd02",
								"dd03",
								"dd04",
								"dd05",
								"dd06",
								"dd07",
								"dd08"
								);
								
	var $AvailableScreens = array(	"date-time" 			=>	"Date-Time Display",
									"service-status"		=>	"Network Service Status",
									"access-points"			=>	"Access Point Availability",
									"support-jobs/new" 		=> 	"New Support Requests",
									"support-jobs/list" 	=> 	"List Current Jobs"
									);
	
	function managementInterface() {
		
		$this->selectAll('screen-content');
		
		if ($this->returnedRows()) {
			
			$row = $this->fetchRow();
		} else {
			
			echo '<p>Cannot load current choices - continuing to load interface...</p>';
		}
		
		?>
		<div id="info">&nbsp;</div>
		<form id="managescreens">
			<div>
				<fieldset>
					<legend>Specify Screen Content</legend>
					<ul>
		<?
		
		foreach ($this->MachineNames as $name) {
			
			?>
			
			<li>
				<label for="<?= $name ?>">Item to display on <?= $name?></label>
				<?= $this->screensListDropDown($name, $row[$name]);?>
			
			</li>
			
			<?
		}
		
		?>
					</ul>
				</fieldset>
				<fieldset>
					<legend>Save Changes</legend>
					<p>Clicking the update button confirms the choice above, changes take immediate effect.</p>
					<p>
						<input type="button" value="Update Screens" name="submitChoice" id="submitChoice" />
					</p>
				</fieldset>
			</div>
		</form>
		<?

	}
	
	function screensListDropDown($name, $selectIfMatch) {
		
		?>
		
		<select name="<?= $name?>" id="<?= $name?>">
		
		<?
		
		foreach ($this->AvailableScreens as $url => $option) {
			
			if ($url == $selectIfMatch) {
				
				$selected = ' selected="selected"';
			} else {
				
				$selected = null;
			}
			
			?>
			
			<option value="<?= $url ?>"<?= $selected?>><?= $option?></option>
			<?
		}
		
		?>
		
		</select>
		
		<?
	}
	
	function updateDatabase() {
		
		$updates = array(	"dd01"	=>	$_POST['dd01'],
							"dd02"	=>	$_POST['dd02'],
							"dd03"	=>	$_POST['dd03'],
							"dd04"	=>	$_POST['dd04'],
							"dd05"	=>	$_POST['dd05'],
							"dd06"	=>	$_POST['dd06'],
							"dd07"	=>	$_POST['dd07'],
							"dd08"	=>	$_POST['dd08'],
							);
							
		$this->update($updates, "screen-content");
		
		if ($this->affectedRows()) {
			
			echo "Changes saved.";
		} else {
			
			echo "Could not save changes.";
		}
	}
	
	function getHostName() {
		
		$str = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$parts = explode('.', $str);
		
		return $parts[0];
	}
	
	function checkScreen() {
		
		$requestingComputer = $this->getHostName();
		
		//$this->trace($requestingComputer);
		
		$this->selectAll('screen-content');
		
		if ($this->returnedRows()) {
			
			print_r($row);
			
			$row = $this->fetchRow();
			
			$savedScreen = $row[$requestingComputer];
			
			return $savedScreen;
		} else {
			
			echo 'Failed to retrieve information.';
		}
	}
}

?>