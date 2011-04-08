<?php

class MailPage {
	public function processGet($get) {
		if (!isset($_SESSION['roleCache']['localparty'])) Dispatcher::header('/appointments/');
	}

	public function show($smarty) {
		$smarty->assign('politician', $_SESSION['politician']);
		unset($GLOBALS['_SESSION']['politician']);
		$smarty->assign('localparty', $_SESSION['roleCache']['localparty']);
		$smarty->display('mail.html');
	}
}

?>