<?php

require_once('validate/Interface.class.php');

class Validate_NotEmpty implements Validate_Interface {
	public function isValid($value) {
		return preg_match('/^\s+$/', $value) == 0;
	}
}

?>