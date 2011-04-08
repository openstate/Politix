<?php

class Submitter extends Record {
	protected $data = array(
		'raadsstuk' => null,
		'politician' => null,
		'politician_name' => null,
	);

	protected $extraCols = array(
		'politician_name' => "p.first_name || ' ' || p.last_name",
	);

	protected $tableName = 'rs_raadsstukken_submitters';
	protected $multiTables = 'rs_raadsstukken_submitters t JOIN pol_politicians p ON t.politician = p.id';

	public function getSubmittersByRaadsstuk($raadsstuk) {
		$list = array();
		foreach ($this->getList($where = 'WHERE raadsstuk = '.$raadsstuk) as $s) {
			$list[] = $s->politician;
		}
		return $list;
	}

	public function getSubmittersNameByRaadsstuk($raadsstuk) {
		$list = array();
		foreach ($this->getList($where = 'WHERE raadsstuk = '.$raadsstuk) as $s) {
			$list[$s->politician] = $s->politician_name;
		}
		return $list;
	}

	public function deleteByRaadsstuk($raadsstuk) {
		$this->db->query('DELETE FROM '.$this->tableName.' WHERE raadsstuk = %', $raadsstuk);
	}
}

?>
