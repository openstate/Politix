<?php

require_once('Image.class.php');

class LinesPage {
	public function show($smarty) {
		$style = Dispatcher::inst()->style;
		$img = new Image();
		$img->load($_SERVER['DOCUMENT_ROOT'].'/images/watstemtmijnraad/bg_streepjes.gif');
		
		header('Content-Type: image/gif');
		echo imagegif($img);
		die;
		
	}
}