<?php

require_once('editPageBase.class.php');

class editPage extends editPageBase {
	
	public function processGet($get) {
		if (!isset($get['id']))
			Dispatcher::header('./');

		$this->loadFromObject($get['id']);
	}

	public function loadFromObject($id) {
		require_once('Page.class.php');
		$obj = new Page();
		$obj->load($id);
		$this->loadData($obj);
	}



	public function saveToObject() {
		require_once('Page.class.php');
		$obj = new Page();
		$this->doSaveToObject($obj);
		$obj->save();
	}


	public function show($smarty) {		
		parent::show($smarty);
	}


	public function action() {
		$this->saveToObject();
		Dispatcher::header('../../');
	}



}

?>