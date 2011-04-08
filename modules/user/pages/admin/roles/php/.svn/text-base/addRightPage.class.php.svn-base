<?php

require_once('EditableRole.class.php');

class addRightPage {
	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('/users/roles/');
		$this->role = new EditableRole();
		$this->role->load($get['id']);
	}

	public function processPost($post) {
		if (isset($post['module']) && preg_match('/^[a-zA-Z0-9.]+$/', $post['module']) &&
		    isset($post['right'])  && preg_match('/^[a-zA-Z0-9.]+$/', $post['right'])) {
			$this->role->addRight($post['module'], $post['right']);
			$this->role->save();
		}
		Dispatcher::header('/users/roles/assignRights/'.$this->role->id.'/');
	}
}

?>