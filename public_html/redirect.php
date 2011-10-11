<?php

/*
	This script allows directories in the public_html directory to be split by site.
*/

// Find the sites config for the current host
$sitesConf = require_once($_SERVER['DOCUMENT_ROOT'].'/../includes/sites.include.php');
$config = false;
foreach ($sitesConf as $hostPreg => $site) {
	if (preg_match($hostPreg, $_SERVER['HTTP_HOST'])) {
		$config = $site;
		break;
	}
}

if (!$config) die;

$scriptUrl = ($_SERVER['SCRIPT_URL']) ? $_SERVER['SCRIPT_URL'] : $_SERVER['REQUEST_URI'];

preg_match('|^(/[^/]+/)(.*)$|', $scriptUrl, $match);
$actualFile = $match[1].$config['publicdir'].'/'.$match[2];
$fileInfo = apache_lookup_uri($actualFile);

if (!file_exists($fileInfo->filename)) {
	header('HTTP/1.1 404 Not Found');
	echo '<h1>404 Not Found</h1>';
} else {
	header('Content-Type: '.$fileInfo->content_type);
	readfile($fileInfo->filename);
}

?>