<?php

require_once('passwordPageBase.class.php');

class passwordPage extends passwordPageBase {
	protected $mailUser = null;
	protected $nameUser = null;
	protected $noLoginGiven = false;

	protected $sentMail = false;
	protected $targetEmail;


	protected function checkUsername() {
		$this->nameUser = new BackofficeUser();
		return $this->nameUser->loadFromUsername($this->data['username']);
	}

	protected function checkEmail() {
		$this->mailUser = new BackofficeUser();
		return $this->mailUser->loadFromEmail($this->data['email']);
	}

	protected function matchUsernameAndEmail() {
		if ($this->nameUser && $this->mailUser)
			return $this->nameUser->id == $this->mailUser->id;
	}

	public function show($smarty) {
		if ($this->sentMail) {
			$smarty->assign('email', $this->targetEmail);
			$smarty->display('passwordReqSent.html');
		} else {
			$smarty->assign('noLoginGiven', $this->noLoginGiven);
			parent::show($smarty);
		}
	}

	public function action() {
		// NOTE - This is extra validation!
		// Make sure that either username or email is given
		if ((!isset($this->data['username'])  || $this->data['username']=='') &&
		    (!isset($this->data['email'])     || $this->data['email']=='')) {
			// Neither are given.
			$this->noLoginGiven = true;
			return;
		}

		if ($this->nameUser)
			$user = $this->nameUser;
		else
			$user = $this->emailUser;

		$hash = $user->requestNewPassword();

		require_once('Emails.class.php');
		$emails = new Emails(Dispatcher::inst()->activeSite, Dispatcher::inst()->locale);
		$mail = $emails->get('passwordrequest');
		$mail->addAddress($user->username);
		$mail->assign('hash', $hash);
		$mail->send();

		$this->targetEmail = $user->username;
		$this->sentMail = true;
	}
}

?>