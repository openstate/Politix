<?php

require_once('Appointment.class.php');
require_once('SecurityException.class.php');

class PendingAppointment extends Appointment {
	protected $tableName = 'pol_pending_functions';
	protected $multiTables = 'pol_pending_functions t JOIN pol_parties p ON p.id = t.party JOIN sys_regions r ON r.id = t.region JOIN sys_categories c ON c.id = t.category JOIN sys_levels l on r.level = l.id';


	public function __construct() {
		parent::__construct();
		$this->data['hash'] = null;
		$this->data['created'] = 'now()';
	}

	public function generateHash() {
		do
			$this->hash = randomString(40);
		while ($this->db->query('SELECT 1 FROM '.$this->tableName.' WHERE hash=%', $this->hash)->fetchCell());
	}

	public function loadByHash($hash) {
		$parts = $this->getParts();
		$row = $this->db->query('SELECT t.*'.$parts['extra'].' FROM '.$parts['tables'].' WHERE t.hash=%', $hash)->fetchRow();
		if ($row)
			$this->loadFromArray($row);
		else
			throw new NoSuchRecordException('Attempted to load a non-existant '.get_class($this).' (hash '.$hash.')');
	}
}

?>