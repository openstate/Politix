<?php

require_once('LoadFormById.class.php');

class DeletePage extends LoadFormById {
	public function processPost($post) {
		try {
			if ($this->getRecord()->region != $_SESSION['role']->getRecord()->id)
				Dispatcher::forbidden();
			$this->getRecord()->delete();
		} catch (Exception $e) {
			$this->error($e);
			return;
		}
		$this->action();
	}

	protected function getFormParameters() {
		return array('name' => 'PageDelete',
		             'header' => 'Pagina verwijderen',
								 'note' => 'Weet u zeker dat u de onderstaande pagina wilt verwijderen?',
								 'submitText' => 'Verwijderen',
								 'freeze' => true);
	}

	protected function getAction() {
		return 'delete';
	}
}

?>
