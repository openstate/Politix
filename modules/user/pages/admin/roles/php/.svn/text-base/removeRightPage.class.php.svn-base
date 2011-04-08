<?php

require_once('EditableRole.class.php');

class removeRightPage {
	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('/users/roles/');
		$this->role = new EditableRole();
		$this->role->load($get['id']);

		if (isset($get['module']) && preg_match('/^[a-zA-Z0-9.]+$/', $get['module']) &&
		    isset($get['right'])  && preg_match('/^[a-zA-Z0-9.]+$/', $get['right'])) {
			$this->role->removeRight($get['module'], $get['right']);
			$this->role->save();
		}
		Dispatcher::header('/users/roles/assignRights/'.$this->role->id.'/');
	}
}

?>