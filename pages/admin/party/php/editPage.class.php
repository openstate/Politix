<?php

require_once('LoadFormById.class.php');

class EditPage extends LoadFormById {
	protected function getFormParameters() {
		return array('name' => 'PartyEdit',
								 'header' => 'Partij wijzigen',
								 'submitText' => 'Wijzigen');
	}

	protected function getAction() {
		return 'edit';
	}
}

?>
