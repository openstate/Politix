<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRolePoliticianAppointmentPartyHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		return 0;
	}

	public function isAllowed($id) {
		throw new SecurityException();
	}

	public function forbidden() {
		Dispatcher::header('/appointments/' . $this->role->getRecord()->id);
	}
}

?>