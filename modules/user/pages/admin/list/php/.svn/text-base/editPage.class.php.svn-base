<?php

require_once('editPageBase.class.php');

class editPage extends editPageBase {
	protected $id;

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../../');
		
		$this->id = $get['id'];
	}

	public function loadFromObject($id) {
		require_once('BackofficeUser.class.php');
		$obj = new BackofficeUser();
		$obj->load($id);
		$this->loadData($obj);
	}



	public function saveToObject() {
		require_once('BackofficeUser.class.php');
		$obj = new BackofficeUser();
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