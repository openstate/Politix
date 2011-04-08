<?php

require_once('SecurityManager.class.php');
require_once('SecurityException.class.php');

class PartyEditHelper implements SecurityManager {
	public function getID($get) {
		if (isset($get['id'])) {
			return $get['id'];
		} else {
			return 0;
		}
	}

	public function isAllowed($id) {
		if ($id <= 0) throw new SecurityException();
	}

	public function forbidden() {
		Dispatcher::header('/party/');
	}
}

?>