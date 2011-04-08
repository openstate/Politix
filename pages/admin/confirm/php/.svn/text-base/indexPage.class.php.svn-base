<?php

require_once('PendingAppointment.class.php');
require_once('SecurityException.class.php');

class IndexPage {
	protected $hash;

	public function processGet($get) {
		if (!isset($get['hash']))
			Dispatcher::badRequest();

		$this->hash = $get['hash'];
		
	}

	public function show($smarty) {
		$pendingApp = new PendingAppointment();
		try {
			$pendingApp->loadByHash($this->hash);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}

		$app = new Appointment();
		$this->copyProperties($app, $pendingApp);
		$app->save();
		$pendingApp->delete();
		$smarty->display('indexPage.html');
	}

	private function copyProperties(Appointment $dst, PendingAppointment $src) {
		$dst->politician = $src->politician;
		$dst->party = $src->party;
		$dst->region = $src->region;
		$dst->category = $src->category;
		$dst->time_start = $src->time_start;
		$dst->time_end = $src->time_end;
		$dst->description = $src->description;
	}
}

?>