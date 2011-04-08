<?php

require_once('editPageBase.class.php');

class editPage extends editPageBase {
	public function loadFromObject($id) {
		require_once('EditableRole.class.php');
		$obj = new EditableRole();
		$obj->load($id);
		$this->loadData($obj);
	}

	public function saveToObject() {
		require_once('EditableRole.class.php');
		$obj = new EditableRole();
		$this->doSaveToObject($obj);
		$obj->save();
	}

	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('/users/roles/');
		$this->loadFromObject($get['id']);
	}

	public function show($smarty) {
		parent::show($smarty);
	}

	public function action() {
		$this->saveToObject();
		Dispatcher::header('/users/roles/');
	}
}

?>