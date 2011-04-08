<?php

require_once('editPageBase.class.php');

class editPage extends editPageBase {
	private $id;
	
	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
			
		$this->id = $get['id'];
	}


	public function loadFromObject($id) {
		require_once('Category.class.php');
		$obj = new Category();
		$obj->load($id);
		$this->loadData($obj);
	}



	public function saveToObject() {
		require_once('Category.class.php');
		$obj = new Category();
		$this->doSaveToObject($obj);
		$obj->save();
	}


	public function show($smarty) {
		$this->loadFromObject($this->id);
		parent::show($smarty);
	}


	public function action() {
		$this->saveToObject();
		Dispatcher::header('../');
	}



}

?>