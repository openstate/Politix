<?php

require_once('Image.class.php');

class LogoPage {
	public function show($smarty) {
		$style = Dispatcher::inst()->style;
		$file = '/files/'.$style->logo;
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].$file)) $file = '/files/wsmr.gif';
		$info = apache_lookup_uri($file);
		
		header('Content-Type: '.$info->content_type);
		readfile($info->filename);
		die;
		
	}
}