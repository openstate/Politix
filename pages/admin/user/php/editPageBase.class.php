<?php

abstract class editPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;

	public function __construct() {
		$this->clear();
		
		$this->errors = array(
			'username_0' => false,
			'username_1' => false,
			'username_2' => false,
			'password_0' => false,
			'password_1' => false,
			'gender_0' => false,
		);
	}
	
	public function clear() {
		$this->data = array(
			'id' => false,
			'username' => '',
			'password' => '',
			'password2' => '',
			'firstname' => '',
			'lastname' => '',
			'gender_is_male' => ''
		);
	}
	
	public function null() {
		$this->data = array(
			'id' => false,
			'username' => null,
			'password' => null,
			'password2' => null,
			'firstname' => null,
			'lastname' => null,
			'gender_is_male' => null
		);
	}

	public function processPost($post) {
		$this->setPost($post);
		if ($this->validate()) { // Success
			$this->dataLoaded = false;
			return $this->action();
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
		if (isset($post['firstname'])) $this->data['firstname'] = $post['firstname'];
		if (isset($post['lastname'])) $this->data['lastname'] = $post['lastname'];
		if (isset($post['gender'])) $this->data['gender_is_male'] = $post['gender'] == 'm';
		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['username']) && $this->data['username']!=''))
			$this->errors['username_0'] = true;
		else {
			if (!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{}|~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $this->data['username'])) $this->errors['username_2'] = true;
		}
		if (!(isset($this->data['password']) && isset($this->data['password2']) && $this->data['password'] == $this->data['password2'])) $this->errors['password_0'] = true;
		if (!(isset($this->data['gender_is_male']))) $this->errors['gender_0'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}

	public function loadData($obj) {
		$this->data['id'] = $obj->id;
		$this->data['username'] = $obj->username;
		$this->data['firstname'] = $obj->firstname;
		$this->data['lastname'] = $obj->lastname;
		$this->data['gender'] = ($obj->gender_is_male ? 'm' : 'f');
	}

	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['username'])) $obj->username = $this->data['username'];
		if (isset($this->data['password']) && $this->data['password'] != '') $obj->password = $this->data['password'];
		if (isset($this->data['firstname'])) $obj->firstname = $this->data['firstname'];
		if (isset($this->data['lastname'])) $obj->lastname = $this->data['lastname'];
		if (isset($this->data['gender_is_male'])) $obj->gender_is_male = $this->data['gender_is_male'];
	}

	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		$smarty->assign('genders', array('m' => 'Man', 'f' => 'Vrouw'));

		$smarty->display('editPage.html');
	}
}

?>