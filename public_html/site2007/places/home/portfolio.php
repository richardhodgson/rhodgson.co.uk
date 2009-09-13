<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/general.include.php');

inc('/site/portfolio.class.php');
$Portfolio = new Portfolio();

$Template->AddStyleSheet('largebox');
$Template->AddStyleSheet('portfolio');
$Template->AddStyleSheet('featured');

$Template->makeHeader();

$Portfolio->makeHeader();

switch ($_GET['do']) {
	
	case 'list':
		$Portfolio->makeFeatured();
		$Portfolio->makeList();
	break;
	
	case 'view':
	
		$Portfolio->MakeView();
	break;
	
	case '':
	
	break;
	
	default:
	
	break;
}



$Portfolio->makeFooter();

//$Portfolio->traceWindow();

$Template->makeFooter();
?>