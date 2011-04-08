<?php

require_once('DBs.class.php');
require_once('LocalParty.class.php');
require_once('BOUserRoleSecretary.class.php');

class LocalPartyPage {
	public function processGet($get) {
		$db = DBs::inst(DBs::SYSTEM);
		$p = new LocalParty();
		if ($db->query('SELECT 1 FROM '.$p->getTableName().' WHERE bo_user = % AND id = %', Dispatcher::inst()->user->id, $get['id'])->fetchCell()) {
			$_SESSION['role'] = new BOUserRoleSecretary($get['id']);
			Dispatcher::inst()->header('/appointments');
		} else {
			Dispatcher::forbidden();
		}
	}
}

?>