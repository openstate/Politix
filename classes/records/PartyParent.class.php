<?php
require_once('ObjectList.class.php');

class PartyParent extends Record {

	protected $data = array(
		'party' => null,
		'parent' => null
	);
	protected $tableName = 'pol_party_parents';

	public function getParentsByParty($party) {
		$list = array();
		foreach ($this->getList($where = 'WHERE party = '.$party) as $p) {
			$list[] = $p->parent;
		}
		return $list;
	}

	public function deleteByParty($party) {
		$this->db->query('DELETE FROM '.$this->tableName.' WHERE party = %', $party);
	}
}

?>
