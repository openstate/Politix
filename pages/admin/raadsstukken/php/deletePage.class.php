<?php

require_once('LoadFormById.class.php');

class DeletePage extends LoadFormById {
	public function processPost($post) {
		try {
			$this->getRecord()->delete();
		} catch (Exception $e) {
			$this->error($e);
			return;
		}
		$this->action();
	}

	protected function getFormParameters() {
		return array('name' => 'RaadsstukDelete',
					 			 'header' => 'Voorstel verwijderen',
								 'note' => 'Weet u zeker dat u het onderstaande voorstel wilt verwijderen?',
								 'submitText' => 'Verwijderen',
								 'freeze' => true);
	}

	protected function getAction() {
		return 'delete';
	}
}

?>
