<?php

require_once('SecurityManager.class.php');

abstract class BOUserRoleAppointmentHelper implements SecurityManager {
	protected $role;

	public function __construct($role) {
		$this->role = $role;
	}

	abstract public function getID($get);

	/* From SecurityManager:

	abstract public function isAllowed($id);

	abstract public function forbidden();
  */
}

?>