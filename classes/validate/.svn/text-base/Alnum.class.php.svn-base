<?php

require_once('validate/Interface.class.php');

class Validate_Alnum implements Validate_Interface {
	public function isValid($value) {
		return preg_match('/^[\pL\pN]+$/', $value) == 1;
	}
}

?>