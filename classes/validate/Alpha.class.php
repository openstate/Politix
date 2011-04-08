<?php

require_once('validate/Interface.class.php');

class Validate_Alpha implements Validate_Interface {
	public function isValid($value) {
		return preg_match('/^[\pL]+$/', $value) == 1;
	}
}

?>