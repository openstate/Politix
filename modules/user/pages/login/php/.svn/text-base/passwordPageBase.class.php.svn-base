<?php

abstract class passwordPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		$this->errors = array(
			'username_0' => false,
			'email_0' => false,
			'email_1' => false,
			'email_2' => false,
		);
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'username' => '',
			'email' => '',
		);
	}
	
	public function null() {
		$this->data = array(
			'id' => false,
			'username' => null,
			'email' => null,
		);
	}

	public function processPost($post) {
		$this->setPost($post);
		if ($this->validate()) { // Success
			$this->dataLoaded = false;
			$this->action();
			return true;
		}
		return false;
	}

	public function setPost($post) {
		$this->null();
		// Conversions from post data to actual values
		// For example, checkboxes use $data[] = isset($post[]);

		// Assignments from post data
		if (isset($post['username'])) $this->data['username'] = $post['username'];
		if (isset($post['email'])) $this->data['email'] = $post['email'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (((isset($this->data['username']) && $this->data['username']!='') && !$this->checkUsername())) $this->errors['username_0'] = true;
		if ((isset($this->data['email']) && $this->data['email']!='')) if (!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{}|~-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/', $this->data['email'])) $this->errors['email_0'] = true;
		else if (!$this->checkEmail()) $this->errors['email_1'] = true;
		else if (!$this->matchUsernameAndEmail()) $this->errors['email_2'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}

	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['username'])) $obj->username = $this->data['username'];
		if (isset($this->data['email'])) $obj->email = $this->data['email'];
	}

	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		$smarty->display('passwordPage.html');
	}
}
