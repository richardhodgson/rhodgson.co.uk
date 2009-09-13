<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/classes/debug.class.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/classes/database.class.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/classes/masterclass.class.php");

inc('shared/debug.class.php');
inc('shared/database.class.php');
inc('shared/masterclass.class.php');
inc('visual/template.class.php');

$Template = new Template();



//Shortcut to the /inc/ directory
function inc($path) {
	
	$prepend = $_SERVER['DOCUMENT_ROOT'] . '/inc/classes/';
	
	$file = $prepend . $path;
	
	if (is_file($file)) {
		
		require_once($file);
		
		return true;
		
	} else {
		
		return false;
	}
}


//HTTP redirect
function Redirect($to) {
	
    $root = SITE_ROOT;
	header("Location: $root$to");
	
	exit;
}

//Shortcut to var_dump()
function vd($mixed) {
	
	var_dump($mixed);
}

//Shortcut to print_r()
function pr($mixed, $ReturnResult = false) {
	
	if ($ReturnResult) {
		
		return print_r($mixed, true);
	} else {
		
		print_r($mixed);
	}
}

?>