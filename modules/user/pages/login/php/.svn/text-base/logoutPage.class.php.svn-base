<?php

class logoutPage {
	public function processGet($get) {
		$user = Dispatcher::inst()->user;
		if ($user->loggedIn) {
			$user->logout();
			unset($GLOBALS['_SESSION']['role']);
		}
		Dispatcher::header('/');
	}
}

?>
