<?php

require_once('DBs.class.php');
require_once('Politician.class.php');
require_once('BOUserRolePolitician.class.php');

class PoliticianPage {
	public function processGet($get) {
		$db = DBs::inst(DBs::SYSTEM);
		$p = new Politician();
		if ($db->query('SELECT 1 FROM '.$p->getTableName().' p JOIN pol_politician_users pu ON p.id = pu.politician WHERE pu.bo_user = % AND pu.politician = %', Dispatcher::inst()->user->id, $get['id'])->fetchCell()) {
			$_SESSION['role'] = new BOUserRolePolitician($get['id']);
			Dispatcher::inst()->header('/raadsstukken');
		} else {
			Dispatcher::forbidden();
		}
	}
}

?>
