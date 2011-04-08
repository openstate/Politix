<?php

require_once('validate/Interface.class.php');

class Validate_EmailAddress implements Validate_Interface {
	public function isValid($email) {
		return preg_match('/^([a-zA-Z0-9.!#$%&\'*+\/=?^_`{}|~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})?$/', $email) == 1;
	}
}

?>