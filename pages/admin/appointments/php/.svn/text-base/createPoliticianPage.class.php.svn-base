<?php

require_once('FormHandler.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');
require_once('Validate.class.php');
require_once('Politician.class.php');

class CreatePoliticianPage extends FormHandler {
	protected $politician;

	public function __construct() {
		$this->data = array(
			'title' => null,
			'first_name' => null,
			'last_name' => null,
			'gender' => null,
			'email' => null,
		);

		$this->errors = array(
			'last_name' => false,
		);

		$this->politician = new Politician();
	}

	protected function assign($post) {
		$this->data['title'] = @trim($post['title']);
		$this->data['first_name'] = @trim($post['first_name']);
		$this->data['last_name'] = @trim($post['last_name']);
		$this->data['gender'] = @$post['gender'];
		$this->data['email'] = @trim($post['email']);
	}

	protected function validate() {
		if (!strlen($this->data['last_name'])) $this->errors['last_name_required'] = true;
		if (strlen($this->data['email']) && !Validate::is($this->data['email'], 'EmailAddress')) $this->errors['email_invalid'] = true;
		return parent::validate();
	}

	protected function save(Record $r) {
		$r->title = $this->data['title'];
		$r->first_name = $this->data['first_name'];
		$r->last_name = $this->data['last_name'];
		$r->gender_is_male = $this->data['gender'] ? 1 : 0;
		$r->email = $this->data['email'];
		$r->save();
	}

	protected function action() {
		Dispatcher::header('/appointments/createParty/?politician='.$this->politician->id);
	}

	protected function getRecord() {
		return $this->politician;
	}

	protected function getFormParameters() {
		return array('name' => 'PoliticianCreate',
								 'header' => 'Nieuwe aanstelling',
								 'submitText' => 'Toevoegen',
		);
	}

	public function show($smarty) {
		parent::show($smarty);
		$smarty->display('createPoliticianPage.html');
	}
}

?>