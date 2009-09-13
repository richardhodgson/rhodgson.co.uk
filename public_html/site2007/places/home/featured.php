<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/general.include.php');

inc('/site/portfolio.class.php');
inc('/site/featured.class.php');
$Featured = new Featured();

$Template->AddStyleSheet('largebox');
$Template->AddStyleSheet('featured');

$Template->makeHeader();

$Featured->makeHeader();

$Featured->MakeView();

$Featured->makeFooter();

//$Portfolio->traceWindow();

$Template->makeFooter();
?>