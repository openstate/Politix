<?php

require_once('Party.class.php');
require_once('LocalParty.class.php');

class RegionDeleteHelper {
	public function getFormParameters($name) {
		return array(
			'header' => "Wilt u de partij '".$name."' verwijderen uit '". $_SESSION['role']->getRecord()->formatName() ."'? De partij zelf zal niet worden verwijderd.",
			'submitText' => 'Verwijderen',
			'date_field' => 'Einddatum'
		);
	}

	public function save(Party $r, $date) {
		$lp = new LocalParty();
		$lp = $lp->loadLocalParty($r->id, $_SESSION['role']->getRecord()->id);
		$lp->time_end = $date;
		$lp->save();
	}

	public function getAction() {
		return 'delete';
	}
}

?>