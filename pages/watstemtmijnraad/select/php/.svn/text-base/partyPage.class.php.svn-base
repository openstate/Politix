<?php

require_once('Party.class.php');

class PartyPage {
	protected $region = null;
	protected $expired = null;

	public function processGet($get) {
		$this->region = (int) @$get['region'];
		$this->expired = isset($get['expired']);
	}

	public function show($smarty) {
		$parties = array('' => 'Alle') + Party::getDropDownParties($this->region, $this->expired);
		echo(implode("\n", array_map(create_function('$a,$b', 'return $a."||".trim($b);'), array_keys($parties), $parties)));
		die;
	}
}

?>