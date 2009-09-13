<?php

class ItemLoans extends MasterClass {

	var $states = array("Free for use", "Out on loan", "Unavailable for use");
	
	function listItems() {
		
		$this->selectAll('item-loans', null, 'name');
		
		if ($this->returnedRows()) {
			?>
			<table>
				<tr>
					<th>Item Name</th>
					<th>Status</th>
					<th>Information</th>
				</tr>
			
			<?
			
			while ($row = $this->fetchRow()) {
				
				?>
				
				<tr>
					<td><?= ucfirst($row['name'])?></td>
					<td><?= $this->status($row['status'])?></td>
					<td><?= $this->textualDateTime($row['updatedAt'], $row['status'])?></td>
				</tr>
				
				<?
			}
			
			?>
			
			</table>
			<?
			
		} else {
			
			?>
			No items to loan where found.
			<?
		}
	}
	
	function listInterface() {
		
		?>
		
		<p>Current items that can be loaned</p>
		
		<div id="listInterface">&nbsp;</div>
		
		<?
	}
	
	function manageLoans() {
		
		
	}
	
	function status($number) {
		
		return $this->states[$number];
	}
	
	function textualDateTime($datetimestamp, $statusNumber) {
		
		$prettyDate = $this->informalTime($datetimestamp, 'just this minute');
		
		switch ($statusNumber) {
			case 0:
				
				return "Last used " . $prettyDate;
				break;
				
			case 1:
				return 'Loaned out ' . $prettyDate;
				break;
				
			case 2:
				return 'Taken out of use ' . $prettyDate;
				break;
			
		}
	}
	
	function add() {
		
		
	}
	
	function remove() {
		
		
	}
	
	function update() {
		
		
	}
}

?>