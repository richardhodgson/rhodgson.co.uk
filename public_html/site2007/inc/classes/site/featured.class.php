<?php

class Featured extends Portfolio {
	
	function makeHeader() {
		
		require_once($this->TemplatePath('featured.header'));
	}
	
	function MakeView () {
		
		$this->sp_RetrieveFeaturedPortfolioItem();
		
		extract($this->fetchRow());
		
		require($this->TemplatePath('featured.viewitem'));
	}
	
	
	function makeFrontPage() {
		
		//$this->selectAll('portfolio', null, 'RAND()', null, 1);
		$this->sp_randomFeaturePortfolioItem();
		
		if ($this->returnedRows()) {
			
			while ($row = $this->fetchRow()) {
				
				extract($row);
				
				require($this->TemplatePath('portfolio.featured.frontpage'));
			}
		}
	}
	
	function sp_randomFeaturePortfolioItem() {
		
		$sql  = 'SELECT portfolio.*, featured.* FROM featured ';
		$sql .= 'INNER JOIN portfolio ON portfolio.id = featured.portfolioId ';
		$sql .= 'ORDER BY RAND() LIMIT 1';
		
		$this->q($sql);
	}
	
	function sp_RetrieveFeaturedPortfolioItem() {
		
		$label = $this->prepare($_GET['label']);
		
		$sql  = 'SELECT portfolio.*, featured.* FROM featured ';
		$sql .= 'INNER JOIN portfolio ON portfolio.id = featured.portfolioId ';
		$sql .= "WHERE portfolio.label = $label";
		
		$this->q($sql);
	}
}

?>