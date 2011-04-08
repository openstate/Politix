<?php
require_once('ObjectList.class.php');

class Party extends Record {

	protected $data = array(
		'name' => null,
		'combination' => null,
		'owner' => null,
		'level' => null,
	);

	protected $extraCols = array(
		'level' => 'r.level'
	);

	protected $tableName = 'pol_parties';
	protected $multiTables = 'pol_parties t JOIN sys_regions r ON r.id = t.owner';
	protected $partyRegionsTableName = 'pol_party_regions';

	public function loadByRegion($region, $order = '') {
		$parties = $this->db->query('SELECT t.* FROM '.$this->tableName.' t JOIN '.$this->partyRegionsTableName.' r ON t.id = r.party WHERE r.region=% '.$order, $region)->fetchAllRows();
		$partyList = new ObjectList(get_class());
		foreach ($parties as $party) {
			$obj = new Party();
			$obj->loadFromArray($party);
			$partyList->add($obj);
		}
		return $partyList;
	}

	public static function getDropDownPartiesAll($where = '', $order = '') {
		$p = new Party();
		$ps = $p->getList($where = $where, $order = $order);

		$result = array();
		foreach($ps as $p) {
			$result[$p->id] = $p->name;
		}
		return $result;
	}

	public static function getDropDownParties($region, $includeExpired = false) {
		if (!$region) return array();
		if(!ctype_digit((string)$region)) return array(); //[XXX: sometimes people pass request parameters as-is]
		return DBs::inst(DBs::SYSTEM)->query('SELECT DISTINCT t.name, t.id FROM pol_parties t JOIN pol_party_regions r ON t.id = r.party WHERE r.region=%'.(!$includeExpired ? ' AND r.time_end > now() ' : '').' ORDER BY t.name ASC', $region)->fetchAllCells('id');
	}

}

?>
