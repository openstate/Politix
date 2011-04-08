<?php

abstract class BOUserRole {
	protected $id;
	
	public function __construct($id) {
		$this->id = $id;
		$_SESSION['roleCache'] = array();
	}

	public function getID() {
		return $this->id;
	}

	abstract public function getName();

	abstract public function toString();

	abstract public function getRecord();
}

?>