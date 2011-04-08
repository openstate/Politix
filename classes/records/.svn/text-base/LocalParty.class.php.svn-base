<?php
class LocalParty extends Record {
	protected $data = array(
		'party'       => null,
		'party_name'  => null,
		'region'      => null,
		'region_name' => null,
		'level'       => null,
		'parent'      => null,
		'level_name'  => null,
		'bo_user'     => null,
		'user'        => null,
		'time_start'  => null,
		'time_end'    => null,
	);
	protected $extraCols = array(
		'party_name'  => 'p.name',
		'region_name' => 'r.name',
		'level'       => 'r.level',
		'parent'      => 'r.parent',
		'level_name'  => 'l.name',
		'user'        => 'u.username',
	);
	protected $multiTables = '
		pol_party_regions t
		JOIN pol_parties p ON t.party = p.id
		JOIN sys_regions r ON r.id = t.region
		JOIN sys_levels l ON r.level = l.id
		LEFT JOIN usr_bo_users u ON t.bo_user = u.id';
	protected $tableName = 'pol_party_regions';

	public function loadBySecretary($boUser, $order='', $limit='') {
		return $this->getList('', 'WHERE bo_user = '.$boUser, $order, $limit);
	}

	public function loadLocalParty($party, $region) {
		$list = $this->getList('', 'WHERE now() < time_end AND party = '.$party.' AND region = '.$region);
		if (count($list) == 0) return false;
		else return array_pop($list);
	}

	public function loadByRegion($region) {
		$list = array();
		foreach ($this->getList('', 'WHERE now() < time_end AND region = '.$region) as $lp) {
			$list[$lp->party] = $lp;
		}
		return $list;
	}

	// formats name: adds level name to provincial and municipal regions
	public function formatRegionName() {
		return ($this->level > 2 ? $this->level_name.' ' : '').$this->region_name;
	}
}

?>