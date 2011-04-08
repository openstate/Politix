<?php
class Region extends Record {

	protected $data = array(
		'name'        => null,
		'level'       => null,
		'parent'      => null,
		'level_name'  => null,
		'parent_name' => null
	);
	protected $extraCols = array(
		'level_name'  => 'l.name',
		'parent_name' => 'p.name');
	protected $multiTables = '
		sys_regions t
		JOIN sys_levels l ON t.level = l.id
		LEFT JOIN sys_regions p ON t.parent = p.id';
	protected $tableName = 'sys_regions';
	//protected $postalCodeTableName = 'sys_postalcodes';

/*	public function loadByPostalCode($postalCode) {
		$id = $this->db->query('SELECT region FROM '.$this->postalCodeTableName.' WHERE % BETWEEN postalcode_min AND postalcode_max', $postalCode)->fetchCell();
		if ($id === false) return false;
		$this->load($id);
		return true;
	}*/

	public function loadByName($name, $level = null) {
		$result = $this->getList('', 'WHERE '.$this->db->formatQuery("t.name ILIKE %", $name).(null != $level ? ' and t.level = '.$level : ''));
		if (count($result)) return reset($result);
		return null;
	}

	public function loadBySecretary($boUser, $order='', $limit='') {
		return $this->getList('WHERE t.id IN (SELECT region FROM sys_region_users WHERE bo_user = '.$boUser.')', $order, $limit);
	}
		
	/* function for creating dropdownbox with regions */
	public static function getDropDownRegions() {
		return DBs::inst(DBs::SYSTEM)->query('SELECT DISTINCT t.name, t.id, \'Provincie \'||p.name AS parent_name FROM sys_regions t JOIN sys_regions p ON t.parent = p.id JOIN rs_raadsstukken r ON t.id = r.region WHERE t.level >= 4 GROUP BY t.name, t.id, parent_name ORDER BY t.name ASC')->fetchAllCells('id', 'parent_name');
	}
	public static function getDropDownRegionsAll() {
		$region = new Region();
		$regions = $region->getList($order = 'ORDER BY t.level ASC, p.name ASC, t.name ASC');
    
		$result = array();              
		foreach($regions as $key => $region) {
			if ($region->level < 3)
				$result[$key] = $region->name;
			else
				$result[$regions[$region->parent]->formatName()][$key] = $region->name;
		}
		return $result;
	}


	// formats name: adds level name to provincial and municipal regions
	public function formatName() {
		return Region::formatRegionName($this->name, $this->level, $this->level_name);
	}

	public static function formatRegionName($regionName, $level, $levelName) {
		return ($level > 2 ? $levelName.' ' : '').$regionName;
	}

	public function toXml($xml) {
		return $xml->getTag('region').
			$xml->fieldToXml('id', $this->id, false).
			$xml->fieldToXml('name', $this->name, true).
			((null !== $this->parent) ? $xml->fieldToXml('parent', $this->parent, false) : '').
			$xml->getTag('region', true);
	}
}

?>
