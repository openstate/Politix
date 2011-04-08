<?php

require_once('BOUserRole.class.php');
require_once('Region.class.php');

class BOUserRoleClerk extends BOUserRole {
	private $region;

	public function __construct($id) {
		parent::__construct($id);
		$this->region = new Region($id);
	}

	public function getName() {
		return 'Griffier';
	}

	public function toString() {
		return $this->getName() .' - '. $this->region->formatName();
	}

	public function getRecord() {
		return $this->region;
	}
}

?>