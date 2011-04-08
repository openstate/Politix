<?php

require_once('BOUserRoleAppointmentHelper.class.php');

class BOUserRoleAppointmentIdentityHelper extends BOUserRoleAppointmentHelper {
	public function getID($get) {
		return $this->role->getID();
	}

	public function isAllowed($id) {
		return;
	}

	public function forbidden() {
		Dispatcher::forbidden();
	}
}

?>