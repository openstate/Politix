<?php

require_once('Party.class.php');
require_once('Category.class.php');

class CategoryListPage {
	protected $ajax = false;
	protected $region;

	protected function output($text) {
		header('Content-Type: text/plain');
		echo $text;
		die();
	}

	protected function badRequest() {
		if ($this->ajax) {
			$this->output('#failed#');
		} else
			Dispatcher::badRequest();
	}

	public function processGet($get) {
		$this->ajax = isset($get['ajax']);
		if (!$this->ajax)
			Dispatcher::header('/appointments/create/');

		if (!isset($get['id']) || !ctype_digit($get['id']) ||
		    !Dispatcher::inst()->user->loggedIn)
			$this->badRequest();

		$this->region = $get['id'];
	}

	public function show($smarty) {
		$smarty->setBaseTemplate($_SERVER['DOCUMENT_ROOT'].'/../templates/ajax.html');
		$category = new Category();
		$categories = $category->loadByRegion($this->region);
		$smarty->assign('categories', $categories);
		$smarty->display('categorylist.html');
	}
}

?>
