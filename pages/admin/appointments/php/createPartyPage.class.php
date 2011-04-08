<?php

require_once('FormPage.class.php');
require_once('Appointment.class.php');

class CreatePartyPage extends FormPage {
	public function processGet($get) {
	  $this->app = new Appointment();
		if (@ctype_digit($get['politician']))
			$this->app->politician = $get['politician'];
		$this->app->time_end = date('Y-m-d', strtotime('+1 year'));
		parent::processGet($get);
	}

	protected function getFormParameters() {
		return array('name' => 'AppointmentCreate',
								 'header' => 'Nieuwe aanstelling',
								 'submitText' => 'Toevoegen',
								 'showPolitician' => true);
	}

	protected function getAction() {
		return 'create';
	}

	protected function validate() {
		try {
			$p = new Politician();
			if (!$p->exists($this->data['politician'])) $this->errors['politician_required'] = true;
		} catch (Exception $e) {
			$this->errors['politician_required'] = true;
		}
		return parent::validate();
	}

	protected function save(Record $r) {
		$r->politician = $this->data['politician'];
		$r->party = $this->localparty->party;
		$r->region = $this->localparty->region;
		parent::save($r);
	}

	public function show($smarty) {
		$smarty->assign('politicians', Politician::getDropDownPoliticiansAll());
		$smarty->assign('politician', $this->politician);
		parent::show($smarty);
	}
}

?>