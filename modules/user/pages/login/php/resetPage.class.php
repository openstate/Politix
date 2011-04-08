<?php

require_once('Emails.class.php');

class resetPage {
	private $email;

	public function processGet($get) {
		if (!isset($get['hash']) || !preg_match('/^[a-zA-Z0-9]+$/', $get['hash']))
			Dispatcher::header('/');

		$user = new BackofficeUser();
		$password = $user->confirmNewPassword($get['hash']);
		if ($password === false)
			Dispatcher::header('/');


		require_once('Emails.class.php');
		$emails = new Emails(Dispatcher::inst()->activeSite, Dispatcher::inst()->locale);
		$mail = $emails->get('passwordreset');
		$mail->addAddress($user->username);
		$mail->assign('password', $password);
		$mail->assign('username', $user->username);
		$mail->send();

		$this->email = $user->username;
	}

	public function show($smarty) {
		$smarty->assign('email', $this->email);
		$smarty->display('passwordSent.html');
	}
}

?>