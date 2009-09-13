<?php
/**
 * RewriteRules all hit this file.
 * It bodges the urls and updates the include paths when site isn't placed in root
 */

define('SITE_ROOT', '/site2007');








$_SERVER['DOCUMENT_ROOT'] .= SITE_ROOT;

ob_start();
require_once($_GET['_target'] . '.php');


$tlds = array('/pages', '/Portfolio', '/img', '/documents');

$migratedUrls = array();
foreach ($tlds as $tld) {
    $migratedUrls []= SITE_ROOT . $tld;
}


echo str_replace($tlds, $migratedUrls, ob_get_clean());