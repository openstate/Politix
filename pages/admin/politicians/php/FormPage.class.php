<?php

require_once('FormHandler.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');
require_once('Validate.class.php');

abstract class FormPage extends FormHandler {
	protected $pofile;

	public function __construct() {
		$this->data = array(
			'title' => null,
			'first_name' => null,
			'last_name' => null,
			'gender' => null,
			'email' => null,
			'extern_id' => null,
		);

		$this->errors = array(
			'last_name' => false,
		);
	}

	protected function assign($post) {
		$this->data['title'] = @trim($post['title']);
		$this->data['first_name'] = @trim($post['first_name']);
		$this->data['last_name'] = @trim($post['last_name']);
		$this->data['gender'] = @$post['gender'];
		$this->data['email'] = @trim($post['email']);
		$this->data['extern_id'] = @trim($post['extern_id']);
		if($this->data['extern_id'] == '') $this->data['extern_id'] = null;
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
		$r->extern_id = $this->data['extern_id'];
		$r->save();
	}

	private function getPOFile() {
		if (null == $this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		$this->addMessage(Message::SUCCESS, 'success');
		Dispatcher::header('/politicians/');
	}

	protected function error($e) {
		$this->addMessage(Message::ERROR, 'error');
	}

	private function addMessage($mtype, $type) {
		MessageQueue::addMessage(new Message($mtype, sprintf($this->getPOFile()->getMsgStr('index.'.$type),
																												 $this->getPOFile()->getMsgStr('index.action.'.$this->getAction()))));
	}

	abstract protected function getAction();

	public function show($smarty) {
		parent::show($smarty);
		$smarty->display('formPage.html');
	}
}

?>