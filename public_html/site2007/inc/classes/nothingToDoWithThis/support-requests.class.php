<?php

class SupportRequests extends  MasterClass  {
	
	var $numberOfRooms = 20;
	var $skipRooms = array(1, 7);
	var $additionalRooms = array("Reception", "Sports Hall");
	
	function listRequests() {
		
		?>
		
		<div style="font-size:18pt;" id="support-jobs-list">
		
		<?= $this->getRequests(); ?>
		
		</div>
		
		<?
	}

	function getRequests() {
		
		$this->selectAll('support-requests', null, array("insertedAt"), "DESC", 10);
		
		if ($this->returnedRows()) {
			
			?>
			
			<table>
			
				<tr>
					<th>Room</th>
					<th>Requested By</th>
					<th>Logged At</th>
				</tr>
				
			<?	while ($row = $this->fetchRow()) { ?>
				
				<tr>
					<td><?= $row['room']?></td>
					<td><?= $row['requestBy']?></td>
					<td><?= $this->informalTime($row['insertedAt'])?></td>
				</tr>
			
			<? } ?>
			
			</table>
			
			<?
			
			
		} else {
			
			echo "<p>No support requests found.</p>";
		}	
	}
	
	function requestForm () {
		
		?>
		<p>To log a support request, simply provide your name and the room where you'd like the support.</p>
			<form>
				<div>
					<fieldset>
						<legend>New Support Request</legend>
						
						<p>
						<label for="room">Support is need in </label>
<?= $this->roomListDropDownBox("room");?></p>

						<p>
						<label for="username">Support is required by </label>
<?= $this->usernameListDropDownBox("username");?></p>
						<p><input type="checkbox" name="highpriority" id="highpriority" /><label for="highpriority">Support is needed as soon as possible</label></p>
						<p><input type="submit" name="requestsubmit" value="Add this Request"/></p>
					</fieldset>
				</div>
			</form>
		
		<?
	}
	
	function roomListDropDownBox($name) {
		
		$roomsArray = array();
		
		for ($i = 1; $i < $this->numberOfRooms; $i++) {
			
			if (!in_array($i, $this->skipRooms, true)) {
				
				$roomsArray []= "Room " . $i;
			}
		}
		
		$optionsArray = array_merge($roomsArray, $this->additionalRooms);
		
		?>
		
		<select name="<?= $name?>" id="<?= $name?>">
			<option><?= implode("</option>\n\t\t\t<option>", $optionsArray)?></option>
		</select>
		
		<?
		
	}
	
	
	function retrieveUsernames() {
		
		$this->changeSettingsSet(2);
		
		$this->select(array("username", "firstname", "lastname"), "usertb", null, "lastname", "ASC", null, " `username` != 'god' AND `username` != 'admin' ");
	}
	
	function addRequest() {
		
		
	}
}

?>
