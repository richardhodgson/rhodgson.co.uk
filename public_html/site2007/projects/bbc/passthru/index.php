<?php

if ($_GET['excludebasepath']) {
	$basepath = "";
} else {
	$basepath = "http://www.bbc.co.uk/dnaimages/components/pt.sssi?box=";
}


$contents = '';

if ($_GET['p']) {
	$url = '/home/beta/ssi/' . $_GET['p'];
}

if ($_GET['full']) {
	$url = $_GET['full'];
}

//echo urlencode("&");

$contents = file_get_contents($basepath . $url);

$find = array("\n", "\n\r", "\r\n", "\r", "\t");
$cleaned = str_replace($find, '', $contents);

$find = array('src="/', 'href="/');
$replace = array('src="http://www.bbc.co.uk/', 'href="http://www.bbc.co.uk/');
$urlpatch = str_replace($find, $replace, $cleaned);


$escape = '<div class="bbc-tearoff">' . str_replace("'", "\'", $urlpatch) . '</div>';


if ($_GET['callback']) {
	echo $_GET['callback'] . "('$escape');";
	
} else {
	echo $escape;
}

//print_r($_GET);

?>