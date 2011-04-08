<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRoleSecretaryAppointmentRegionHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		return 0;
	}

	public function isAllowed($id) {
		throw new SecurityException();
	}

	public function forbidden() {
		Dispatcher::header('/appointments/party/' . $this->role->getRecord()->id);
	}
}

?>