<?php

require_once('validate/Interface.class.php');

class Validate_Color implements Validate_Interface {
	public function isValid($color) {
		return preg_match('/^[0-9a-fA-F]{6}$/', $color) == 1;
	}
}

?>