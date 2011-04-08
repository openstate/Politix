<?php

class Tag extends Record {

	protected $data = array(
		'name' => null,
	);

	protected $tableName = 'sys_tags';

	public static function getAssociativeOnId() {
		$r = new self();
		
		$result = array();		
		foreach($r->getList() as $t) {
			$result[$t->id] = $t->name;
		}
		return $result;
	}

	public static function getAssociativeOnName() {
		$r = new self();
		
		$result = array();		
		foreach($r->getList() as $t) {
			$result[$t->name] = $t->id;
		}
		return $result;
	}

	public static function getNames() {
		$names = self::getAssociativeOnId();
		asort($names);
		return array_values($names);
	}	
}

?>