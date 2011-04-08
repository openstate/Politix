<?php

class EditPwdPage {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	protected $obj;

	public function __construct() {
		$this->clear();
		$this->errors = array(
			'password_0' => false,
			'password_1' => false,
			'password_2' => false,
			'password_3' => false,
		);
	}
	
	public function clear() {
		$this->data = array(
			'id' => false,
			'oldpassword' => '',
			'newpassword' => '',
			'newpassword2' => '',
		);
	}
	
	public function null() {
		$this->data = array(
			'id' => false,
			'oldpassword' => null,
			'newpassword' => null,
			'newpassword2' => null,
		);
	}

	public function processPost($post) {
		if (!(isset($post['id']) && ctype_digit($post['id'])))
			Dispatcher::badRequest();

		$this->obj = new BackofficeUser();
		$this->obj->load($post['id']);
		$this->setPost($post);
		if ($this->validate()) { // Success
			$this->dataLoaded = false;
			return $this->action();
		}
	}

	public function setPost($post) {
		$this->null();
		// Conversions from post data to actual values
		// For example, checkboxes use $data[] = isset($post[]);

		// Assignments from post data
		if (isset($post['oldpassword'])) $this->data['oldpassword'] = $post['oldpassword'];
		if (isset($post['newpassword'])) $this->data['newpassword'] = $post['newpassword'];
		if (isset($post['newpassword2'])) $this->data['newpassword2'] = $post['newpassword2'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['newpassword']) && isset($this->data['newpassword2']) && $this->data['newpassword'] == $this->data['newpassword2'])) $this->errors['password_0'] = true;
		if (!(isset($this->data['newpassword']) && $this->data['newpassword']!='')) $this->errors['password_1'] = true;
		if (!(isset($this->data['oldpassword']) && $this->data['oldpassword']!='')) {
			$this->errors['password_2'] = true;
		} else {
			if (sha1($this->data['oldpassword']) != $this->obj->password) $this->errors['password_3'] = true;
		}

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}

	public function loadData($obj) {
		$this->data['id'] = $obj->id;
		$this->data['username'] = $obj->username;
		$this->data['firstname'] = $obj->firstname;
		$this->data['lastname'] = $obj->lastname;
		$this->data['email'] = $obj->email;
		$this->data['gender'] = ($obj->gender_is_male ? 'm' : 'f');
	}

	public function doSaveToObject($obj) {
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['newpassword'])) $obj->password = $this->data['newpassword'];
	}

	public function show($smarty) {
		$this->loadData($this->obj);
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		$smarty->assign('genders', array('m' => 'Man', 'f' => 'Vrouw'));

		$smarty->display('editPage.html');
	}
}

?>