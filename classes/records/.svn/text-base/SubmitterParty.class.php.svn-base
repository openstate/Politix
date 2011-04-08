<?php

class SubmitterParty extends Record {
	protected $data = array(
		'raadsstuk' => null,
		'party' => null,
		'party_name' => null,
	);

	protected $extraCols = array(
		'party_name' => "p.name",
	);

	protected $tableName = 'rs_raadsstukken_submitters_party ';
	protected $multiTables = 'rs_raadsstukken_submitters_party t JOIN pol_parties p ON t.party = p.id';


	/** Returns submitting party */
	public function getSubmitterPartyByRaadsstuk($raadsstuk) {
		//there is no find method
		foreach ($this->getList($where = 'WHERE raadsstuk = '.intval($raadsstuk)) as $s) {
			return $s->party;
		}

		return  null;
	}

	public function getSubmitterPartyNameByRaadsstuk($raadsstuk) {
		foreach ($this->getList($where = 'WHERE raadsstuk = '.intval($raadsstuk)) as $s) {
			return $s->party_name;
		}

		return null;
	}

	public function deleteByRaadsstuk($raadsstuk) {
		$this->db->query('DELETE FROM '.$this->tableName.' WHERE raadsstuk = %', $raadsstuk);
	}
}

?>
