<?php

require_once('FormPage.class.php');
require_once('Appointment.class.php');

abstract class LoadFormById extends FormPage {
	public function processGet($get) {
		try {
			$this->app = new Appointment($get['id']);
			if (!(Dispatcher::inst()->user->isSuperAdmin() || $this->app->region == $_SESSION['role']->getRecord()->id))
				Dispatcher::forbidden();
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}

		if (Dispatcher::inst()->user->isSuperAdmin()) {
			try {
				$this->politician = new Politician($get['politician']);
			} catch (Exception $e) {
				Dispatcher::header('/appointments/');
			}
		}
		parent::processGet($get);
	}
}