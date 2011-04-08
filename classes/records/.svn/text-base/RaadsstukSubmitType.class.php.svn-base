<?php

class RaadsstukSubmitType extends Record {
	protected $data = array(
		'name' => null,
	);

	protected $tableName = 'rs_raadsstukken_submit_type';

	public function getRaadsstukTypes() {
		$result = array();
		foreach($this->getList($where='WHERE id IN (1, 2)') as $row) {
			$result[$row->id] = $row->name;
		}
		return $result;
	}

	public function getSubmitType($type, $submitters) {
		//24-11-2008 -- Trying to reconstruct bechavior and meanings of each option
		//FO is lost... nothing is documented... this world is fucked up... =/

		//[FIXME: direct ID mapping!!!!]
		switch ($type) {
		case 1: //Raadsvoorstel, Wetstvoorstel
			return 19; //Partij
			//return $submitters; //either College or Presidium

		case 2: //Initiatief voorstel
		case 3: //Amendement
		case 4: //Motie -- removed in politix
			return 3; //Raadslid

		case 5: //Burger initiatief
			return 4; //Burger

		case 19: //Onbekend
			return 18; //Onbekend
		}
	}
}