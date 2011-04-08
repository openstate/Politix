<?php

require_once('BOUserRole.class.php');
require_once('Politician.class.php');

class BOUserRolePolitician extends BOUserRole{
	private $politician;

	public function __construct($id) {
		parent::__construct($id);
		$this->politician = new Politician($id);
	}

	public function getName() {
		return 'Politicus';
	}

	public function toString() {
		return $this->getName() .' - '. $this->politician->formatName();
	}

	public function getRecord() {
		return $this->politician;
	}
}

?>