<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRoleClerkAppointmentHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		if (isset($get['id'])) {
			return $get['id'];
		} else {
			return 0;
		}
	}

	public function isAllowed($id) {
		if ($id <= 0) throw new SecurityException();
		$ret = (bool)DBs::inst(DBs::SYSTEM)->query('SELECT 1 FROM pol_politicians t JOIN pol_politician_functions pf ON t.id = pf.politician JOIN pol_party_regions pr ON pf.party = pr.party AND pf.region = pr.region JOIN pol_parties p ON pr.party = p.id JOIN sys_regions r ON r.id = pr.region WHERE r.id = % AND t.id = %', $this->role->getRecord()->id, $id)->fetchCell();
	}

	public function forbidden() {
		Dispatcher::header('/appointments/region/' . $this->role->getRecord()->id);
	}
}

?>