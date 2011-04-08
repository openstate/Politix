<?php

require_once('Dispatcher.class.php');

class LoginBlock {
	public function display($smarty) {
		/*		if (isset($_REQUEST['destination'])) {
			$destination = $_REQUEST['destination'];
		} else if (isset($_SERVER['HTTP_REFERER'])) {
			$destination = $_SERVER['HTTP_REFERER'];
			} else {
			$destination = '/';
			}*/
		$smarty->assign('destination', '/'); //$destination);
		$smarty->assign('name', Dispatcher::inst()->user->formatName());
		$smarty->assign('role', $_SESSION['role']);
		$smarty->displayBlock('login.html');
	}
}

?>