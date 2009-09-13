<?php

class Skills extends MasterClass {
	
	function returnSkillsList ($SkillsArray) {
		
		foreach ($SkillsArray as $key => $skill) {
			
			$SkillsArray[$key] = '<a href="/Portfolio/Skills/' . $this->ConvertToUrlLabel($skill) . '">' . $skill . '</a>';
		}
		
		$SkillsArray = implode(', ', $SkillsArray);
		
		return $SkillsArray;
	}
	
	function makeHeader() {
		
		require_once($this->TemplatePath('skills.header'));
	}
	
	function makeFooter() {
		
		require_once($this->TemplatePath('skills.footer'));
	}
	
	function makeList() {
		
		$this->selectAll('skills', null, 'label');
		
		if ($this->returnedRows()) {
			
			?>
			
			<dl>
			
			<?
			
			while ($row = $this->fetchRow()) {
				
				require($this->TemplatePath('skills.listrow'));
			}
			
			
			?>
			
			</dl>
			
			<?
		}
	}
}

?>