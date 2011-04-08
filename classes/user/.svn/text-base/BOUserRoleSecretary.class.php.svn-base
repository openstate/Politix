<?php

require_once('BOUserRole.class.php');
require_once('LocalParty.class.php');

class BOUserRoleSecretary extends BOUserRole {
	private $localparty;

	public function __construct($id) {
		parent::__construct($id);
		$this->localparty = new LocalParty($id);
	}

	public function getName() {
		return 'Partijsecretaris';
	}

	public function toString() {
		return $this->getName() .' - '. $this->localparty->party_name .', '. $this->localparty->region_name;
	}

	public function getRecord() {
		return $this->localparty;
	}
}

?>