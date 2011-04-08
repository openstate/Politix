<?php

require_once('EditableRole.class.php');

class assignRightsPage {
	protected $role;

	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('/users/roles/');
		$this->role = new EditableRole();
		$this->role->load($get['id']);
	}

	public function show($smarty) {
		$smarty->assign('role', $this->role);
		$smarty->display('assignRightsPage.html');
	}
}