<?php

require_once('EditableRole.class.php');

class deletePage {
	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('/users/roles/');
		$role = new EditableRole();
		$role->delete($get['id']);
		Dispatcher::header('/users/roles/');
	}
}

?>