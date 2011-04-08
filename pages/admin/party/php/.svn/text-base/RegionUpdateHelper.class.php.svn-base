<?php

require_once('Party.class.php');
require_once('LocalParty.class.php');

class RegionUpdateHelper {
	public function getFormParameters($name) {
		return array(
			'header' => "Wilt u de datum waarop '".$name."' wordt gekoppeld aan '". $_SESSION['role']->getRecord()->formatName() ."' wijzigen?",
			'submitText' => 'Wijzigen',
			'date_field' => 'Aanvangsdatum'
		);
	}

	public function save(Party $r, $date) {
		$lp = new LocalParty();
		$lp = $lp->loadLocalParty($r->id, $_SESSION['role']->getRecord()->id);
		$lp->time_start = $date;
		$lp->save();
	}

	public function getAction() {
		return 'edit';
	}
}

?>