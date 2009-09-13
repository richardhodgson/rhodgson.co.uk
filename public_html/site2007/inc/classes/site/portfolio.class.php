<?php

class Portfolio extends MasterClass {
	
	var $RowClass = 'odd';
	
	function ListRow($row) {
		
		extract($row);
		
		$RowClass = $this->RowClass;
		
		require($this->TemplatePath('portfolio.listrow'));
	}
	
	function makeList() {
		
		$this->sp_PortfolioItemList();
		
		if ($this->returnedRows()) {
			
			inc('site/skills.class.php');
			
			$SkillsClass = new Skills();
			
			?>
			
			<h3 id="ProjectsTitle">Projects</h3>
			<ul id="PortfolioItems">
			<?
			
			$CurrentLabel = false;
			$SkillsArray = array();
			$PreviousRow = null;
			$IterationsNeeded = $this->NumberOfRowsInResultSet() + 1;
			
			//while ($row = $this->fetchRow()) {
			for ($i = 0; $i < $IterationsNeeded; $i++) {
				
				$row = $this->fetchRow();
				
				if (!$CurrentLabel || $CurrentLabel == $row['label']) {
					
					
					//Please don't even ask.
				} else {
					
					
					?>
				
				<li>
					<?
						
					$PreviousRow['skills'] = $SkillsClass->returnSkillsList($SkillsArray);
					
					$SkillsArray = array();
					
					$this->ListRow($PreviousRow);
					
					?>
				
				</li>
					<?
					
					if ($this->RowClass == 'odd') {
						
						$this->RowClass = 'even';
					} else {
						
						$this->RowClass = 'odd';
					}
				}
				
				$PreviousRow = $row;
				$SkillsArray []= $row['skill'];
				
				$CurrentLabel = $row['label'];
			}
				
			?>
			
			</ul>
			<?
		} else {
			
			//develop some kind of error page & template
			echo 'no items';
		}
	}
	
	function makeFeatured() {
		
		inc('site/featured.class.php');
		
		$Featured = new Featured();
		
		$Featured->makeFrontPage();
	}
	
	function MakeView() {
		
		$this->sp_PortfolioItemView();
		
		if ($this->returnedRows()) {
			
			inc('site/skills.class.php');
			
			$SkillsClass = new Skills();
			
			
			$SkillsArray = array();
			$RowCount = $this->NumberOfRowsInResultSet();
			
			for ($i = 1; $i <= $RowCount;$i++) {
				
				$row = $this->fetchRow();
				
				$SkillsArray []= $row['skill'];
				
				if ($i == $RowCount) {
					
					extract($row);
					
					$Skills = $SkillsClass->returnSkillsList($SkillsArray);
					
					require($this->TemplatePath('portfolio.viewitem'));
				}
			}
		} else {
			
			?>
			
			<h4>Page Not Found</h4>
			<p>The item you requested could not be found. Please check your spelling or <a href="mailto: contact@rhodgson.co.uk">contact me</a> if you think something is missing.</p>
			<p>You requested <a href="/Portfolio/<?= htmlentities($_GET['label'])?>">rhodgson.co.uk/Portfolio/<?= htmlentities($_GET['label'])?></a></p>
			
			<?
		}
	}
	
	function makeHeader() {
		
		require_once($this->TemplatePath('portfolio.header'));
	}
	
	function makeFooter() {
		
		require_once($this->TemplatePath('portfolio.footer'));
	}
		
	
	
	function sp_PortfolioItemList() {
		
		$sql  = 'SELECT portfolio.*, skills.label AS skill FROM portfolio ';
		$sql .= 'INNER JOIN portfolioskills ON portfolioskills.portfolioId = portfolio.id ';
		$sql .= 'INNER JOIN skills ON portfolioskills.skillId = skills.id ';
		$sql .= 'WHERE portfolio.visible = 1 ';
		$sql .= 'ORDER BY portfolio.stamp DESC, skills.label';
		
		$this->q($sql);
	}
	
	function sp_PortfolioItemView () {
		
		$label = $this->prepare($_GET['label']);
		
		//$sql  = 'SELECT portfolio.*, skills.label AS skill FROM portfolio ';
		$sql  = "SELECT (SELECT label FROM portfolio WHERE ID = (SELECT (id - 1) FROM portfolio WHERE label = $label)) AS next,  ";
		$sql .= 'portfolio.*, skills.label AS skill, featured.id AS featured FROM portfolio ';
		$sql .= 'INNER JOIN portfolioskills ON portfolioskills.portfolioId = portfolio.id ';
		$sql .= 'INNER JOIN skills ON portfolioskills.skillId = skills.id ';
		$sql .= 'LEFT JOIN featured ON featured.portfolioId = portfolio.id ';
		$sql .= "WHERE portfolio.label = $label";
		$sql .= 'ORDER BY portfolio.stamp DESC, skills.label';
		
		$this->q($sql);
	}
}

?>