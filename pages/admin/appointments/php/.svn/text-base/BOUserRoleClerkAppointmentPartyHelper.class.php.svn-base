<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRoleClerkAppointmentPartyHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		if (isset($get['id'])) {
			return $get['id'];
		} else {
			return 0;
		}
	}

	public function isAllowed($id) {
		if ($id <= 0) throw new SecurityException();
		$ret = (bool)DBs::inst(DBs::SYSTEM)->query('SELECT 1 FROM pol_party_regions t JOIN pol_parties p ON t.party = p.id JOIN sys_regions r ON r.id = t.region WHERE r.id = % AND t.id = %', $this->role->getRecord()->id, $id)->fetchCell();
		if (!$ret) throw new SecurityException();
	}

	public function forbidden() {
		Dispatcher::header('/appointments/region/' . $this->role->getRecord()->id);
	}
}

?>