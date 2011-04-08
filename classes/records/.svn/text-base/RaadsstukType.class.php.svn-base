<?php

class RaadsstukType extends Record {
	const RAADSVOORSTEL = 1;
	const INITIATIEFVOORSTEL = 2;
	const AMENDEMENT = 3;
	const MOTIE = 4;
	const BURGERINITIATIEF = 5;

	protected $data = array(
		'name'        => null,
	);

	protected $tableName = 'rs_raadsstukken_type';

	public static function getAssociativeOnId() {
		$r = new self();
		
		$result = array();		
		foreach($r->getList() as $t) {
			$result[$t->id] = $t->name;
		}
		return $result;
	}

	public static function getSearchTypes() {
		return array('' => 'Alle') + self::getAssociativeOnId();
	}

	public function toXml($xml) {
		return $xml->getTag('type').
			$xml->fieldToXml('id', $this->id, false).
			$xml->fieldToXml('name', $this->name, true).
			$xml->getTag('type', true);
	}
}

?>
