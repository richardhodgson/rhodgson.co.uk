<?php

class Page extends MasterClass {
	
	function Page() {
		
		if ($_GET['page']) {
			
			$this->RetrievePage($_GET['page']);
		} else {
			
			Redirect('/pages/Welcome');
		}
		
	}
	
	function Output() {
		
		require_once($this->TemplatePath('pages.header'));
		
		if ($this->returnedRows()) {
			
			$result = $this->fetchRow();
			
			
			
			echo $result['content'];
			
		} else {
			
			?>
			
			<div>

				<span>Page Not Found</span>
				The page you requested could not be found. Please check your spelling
				or <a href="mailto: contact@rhodgson.co.uk">email me</a> if you think this isn't right.
				<br />
				<br />
				You were looking for <a href="/pages/<?= $_GET['page']?>">rhodgson.co.uk/pages/<?= htmlentities($_GET['page'])?></a>
				
				
			</div>
		
			
			
			<?
		}
		
		
			require_once($this->TemplatePath('pages.footer'));
			
	}
	
	function RetrievePage($page) {
		
		$where = array('label' => $page);
		
		$this->selectAll('pages', $where);
	}
}

?>
