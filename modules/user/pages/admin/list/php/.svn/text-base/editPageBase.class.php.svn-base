<?php

abstract class editPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		
		$this->errors = array(
			'username_0' => false,
			'password2_0' => false,

		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'username' => '',
			'password' => '',
			'password2' => '',

		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'username' => null,
			'password' => null,

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
		$this->data['id'] = $post['id'];
		if (isset($post['username'])) $this->data['username'] = $post['username'];
		if (isset($post['password'])) $this->data['password'] = $post['password'];
		if (isset($post['password2'])) $this->data['password2'] = $post['password2'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['username']) && $this->data['username']!='')) $this->errors['username_0'] = true;
		if (((isset($this->data['password2']) && $this->data['password2']!='') && !($this->data['password2'] == $this->data['password']))) $this->errors['password2_0'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	


	public function loadData($obj) {
		$this->data['id'] = $obj->id;
		$this->data['username'] = $obj->username;
		$this->data['password'] = $obj->password;

	}





	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['username'])) $obj->username = $this->data['username'];
		if (isset($this->data['password'])) $obj->password = $this->data['password'];

	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('editPage.html');
	}
}

?>