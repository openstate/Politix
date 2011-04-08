<?php

require_once('createPageBase.class.php');

class createPage extends createPageBase {
	public function saveToObject() {
		require_once('EditableRole.class.php');
		$obj = new EditableRole();
		$this->doSaveToObject($obj);
		$obj->save();
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