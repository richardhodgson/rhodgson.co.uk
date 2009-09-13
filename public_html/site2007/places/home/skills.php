<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/general.include.php');

inc('site/skills.class.php');
$Skills = new Skills();

$Template->AddStyleSheet('largebox');
$Template->AddStyleSheet('skills');

$Template->makeHeader();

$Skills->makeHeader();;

$Skills->makeList();

$Skills->makeFooter();

//$Page->traceWindow();

$Template->makeFooter();
?>