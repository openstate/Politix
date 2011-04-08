<?php

require_once('Style.class.php');
require_once('Image.class.php');

class MainPage {
	public function show($smarty) {
		$s = Dispatcher::inst()->style;
		$smarty->left_delimiter = '{{';
		$smarty->right_delimiter = '}}';
		$s->assign($smarty);

		$img = new Image();
		try {
			@$img->load($_SERVER['DOCUMENT_ROOT'].'/files/'.$s->logo);
		} catch (Exception $e) {
			$img->load($_SERVER['DOCUMENT_ROOT'].'/files/wsmr.gif');
		}

		$smarty->assign('logo', $img);
		$smarty->assign('noimg', isset($_GET['noimg']));
		
		header('Content-type: text/css');
		echo $smarty->fetch($_SERVER['DOCUMENT_ROOT'].'/stylesheets/watstemtmijnraad/main.css');
	}
}