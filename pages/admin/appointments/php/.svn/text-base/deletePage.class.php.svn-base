<?php

require_once('LoadFormById.class.php');
require_once('Politician.class.php');

class DeletePage extends LoadFormById {
	public function processPost($post) {
		try {
			$app = $this->getRecord();
			if ($app->isExpired())
				$app->delete();
			else {
				// do not really delete, but end appointment immediately
				$app->time_end = 'now()';
				$app->save();
			}
		} catch (Exception $e) {
			$this->error($e);
			return;
		}
		$this->action();
	}

	protected function loadData($record) {
		$p = new Politician($record->politician);
		$this->data['politician_name'] = $p->formatName();
		parent::loadData($record);
	}

	protected function getFormParameters() {
		return array('name' => 'AppointmentDelete',
								 'header' => 'Aanstelling verwijderen',
								 'note' => ($this->getRecord()->isExpired() ? 
															'Weet u zeker dat u de onderstaande verlopen aanstelling wilt verwijderen?' :
															'Weet u zeker dat u de onderstaande aanstelling wilt laten verlopen?'),
								 'submitText' => 'Verwijderen',
								 'freeze' => true,
								 'showPolitician' => true);
	}

	protected function getAction() {
		return 'delete';
	}
}

?>
