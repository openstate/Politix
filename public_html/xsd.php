<?php

define('XSD_DIR', '../modules/xml/xsd');

$scriptUrl = $_SERVER['SCRIPT_URL'] ? $_SERVER['SCRIPT_URL'] : $_SERVER['REQUEST_URI'];
preg_match('!^/xml/([\w]+)\.xsd$!', $scriptUrl, $match);

$filename = XSD_DIR.'/'.$match[1].'.xsd';
if (file_exists($filename)) {
	header('Content-Type: text/xml');
	readfile($filename);
} else {
	header('HTTP/1.1 404 Not Found');
	echo '<h1>404 Not Found</h1>';
}

?>