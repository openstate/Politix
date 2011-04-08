<?php

abstract class indexPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		
		$this->errors = array(
			'username_0' => false,
			'password_0' => false,
			'password_1' => false,

		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'username' => '',
			'password' => '',
			'destination' => '',
			'cookie' => false,

		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'username' => null,
			'password' => null,
			'cookie' => null,

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
		$this->data['cookie'] = $post['cookie'] = isset($post['cookie']);

		// Assignments from post data
		if (isset($post['username'])) $this->data['username'] = $post['username'];
		if (isset($post['password'])) $this->data['password'] = $post['password'];
		if (isset($post['destination'])) $this->data['destination'] = $post['destination'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['username']) && $this->data['username']!='')) $this->errors['username_0'] = true;
		if (!(isset($this->data['password']) && $this->data['password']!='')) $this->errors['password_0'] = true;
		else if (!$this->loginCheck()) $this->errors['password_1'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	






	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['username'])) $obj->username = $this->data['username'];
		if (isset($this->data['password'])) $obj->password = $this->data['password'];
		if (isset($this->data['cookie'])) $obj->cookie = $this->data['cookie'];

	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('indexPage.html');
	}
}

?>