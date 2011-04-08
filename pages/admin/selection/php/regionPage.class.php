<?php

require_once('DBs.class.php');
require_once('Region.class.php');
require_once('BOUserRoleClerk.class.php');

class RegionPage {
	public function processGet($get) {
		$db = DBs::inst(DBs::SYSTEM);
		$p = new Region();
		if ($db->query('SELECT 1 FROM '.$p->getTableName().' r JOIN sys_region_users ru ON r.id = ru.region WHERE ru.bo_user = % AND id = %', Dispatcher::inst()->user->id, $get['id'])->fetchCell()) {
			$_SESSION['role'] = new BOUserRoleClerk($get['id']);
			Dispatcher::inst()->header('/raadsstukken/');
		} else {
			Dispatcher::forbidden();
		}
	}
}

?>
