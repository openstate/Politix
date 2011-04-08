<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRoleSecretaryAppointmentHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		if (isset($get['id'])) {
			return $get['id'];
		} else {
			return 0;
		}
	}

	public function isAllowed($id) {
		if ($id <= 0) throw new SecurityException();
		$ret = (bool)DBs::inst(DBs::SYSTEM)->query('SELECT 1 FROM pol_politicians t JOIN pol_politician_functions pf ON t.id = pf.politician JOIN pol_party_regions pr ON pf.party = pr.party AND pf.region = pr.region WHERE pr.id = % AND t.id = %', $this->role->getRecord()->id, $id)->fetchCell();
		if (!$ret) throw new SecurityException();
	}

	public function forbidden() {
		Dispatcher::header('/appointments/party/' . $this->role->getRecord()->id);
	}
}

?>