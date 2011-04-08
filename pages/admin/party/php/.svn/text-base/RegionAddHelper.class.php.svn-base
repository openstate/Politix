<?php

require_once('Party.class.php');
require_once('LocalParty.class.php');

class RegionAddHelper {
	public function getFormParameters($name) {
		return array(
			'header' => "Wilt u de partij '".$name."' koppelen aan '". $_SESSION['role']->getRecord()->formatName() ."'?",
			'submitText' => 'Toevoegen',
			'date_field' => 'Aanvangsdatum'
		);
	}

	public function save(Party $r, $date) {
		$lp = new LocalParty();
		$lp->party = $r->id;
		$lp->region = $_SESSION['role']->getRecord()->id;
		$lp->time_start = $date;
		$lp->time_end = 'infinity';
		$lp->save();
	}

	public function getAction() {
		return 'create';
	}
}

?>