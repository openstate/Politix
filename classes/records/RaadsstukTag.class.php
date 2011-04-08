<?php

class RaadsstukTag extends Record {

	protected $data = array(
		'raadsstuk' => null,
		'tag' => null,
		'tag_name' => null,
	);

	protected $extraCols = array(
		'tag_name' => 'st.name',
	);

	protected $tableName = 'rs_raadsstukken_tags';
	protected $multiTables = 'rs_raadsstukken_tags t join sys_tags st on t.tag = st.id';

	public function getTagsByRaadsstuk($raadsstuk) {
		if($raadsstuk === null) return array(); //[FIXME: crappy code, prevent malformed SQL exception]
		return $this->buildList('WHERE raadsstuk = '.$raadsstuk, 'buildTagsByRaadsstuk');
	}

	public function getTagsByRaadsstukOnName($raadsstuk) {
		return $this->buildList('WHERE raadsstuk = '.$raadsstuk, 'buildTagsByRaadsstukOnName');
	}

	private function buildList($where, $callback) {
		$result = array();
		foreach($this->getList($where) as $t) {
			$this->$callback($t, $result);
		}
		return $result;
	}

	private function buildTagsByRaadsstuk($record, &$list) {
		$list[$record->tag] = $record->tag_name;
	}

	private function buildTagsByRaadsstukOnName($record, &$list) {
		$list[$record->tag_name] = $record;
	}

	public function deleteByRaadsstuk($raadsstuk) {
		$this->db->query('DELETE FROM '.$this->tableName.' WHERE raadsstuk = %', $raadsstuk);
	}
}

?>