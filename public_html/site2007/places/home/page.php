<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/general.include.php');

inc('/site/page.class.php');
$Page = new Page();

$Template->AddStyleSheet('smallbox');

$Template->makeHeader();

$Page->Output();

$Page->traceWindow();

$Template->makeFooter();
?>