<?php

require_once('SecurityException.class.php');

class ModifyHelper {
	private $id;
	private $politician;

	public function __construct($id, $politician) {
		$this->id = $id;
		$this->politician = $politician;
	}

	public function isAllowed($region = null) {
		if (!(bool)DBs::inst(DBs::SYSTEM)->query('SELECT 1 FROM pol_politicians p JOIN pol_politician_functions pf ON p.id = pf.politician WHERE p.id = % AND pf.id = % AND pf.region = %', is_object($this->politician) ? $this->politician->id : $this->politician, $this->id, $region)->fetchCell()) throw new SecurityException();
	}
}

?>