<?php

require_once('EditableRole.class.php');

class rightListPage {
	public function show($smarty) {
		$role = new EditableRole();
		$smarty->assign('rights', $role->getAllRights());
		$smarty->display('rightListPage.html');
	}
}