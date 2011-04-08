<?php

abstract class createPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		
		$this->errors = array(
			'region_name_0' => false,
			'level_0' => false,
			'level_0' => false,

		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'region_name' => '',
			'parent' => '',
			'level' => '',

		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'region_name' => null,
			'parent' => null,
			'level' => null,

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
		if (isset($post['region_name'])) $this->data['region_name'] = $post['region_name'];
		if (isset($post['parent'])) $this->data['parent'] = $post['parent'];
		if (isset($post['level'])) $this->data['level'] = $post['level'];
		if (isset($post['parent'])) $this->data['parent'] = $post['parent'];
		if (isset($post['level'])) $this->data['level'] = $post['level'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['region_name']) && $this->data['region_name']!='')) $this->errors['region_name_0'] = true;
		if (!(isset($this->data['level']) && $this->data['level']!='')) $this->errors['level_0'] = true;
		if (!(isset($this->data['level']) && $this->data['level']!='')) $this->errors['level_0'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	






	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['region_name'])) $obj->name = $this->data['region_name'];
		if (isset($this->data['parent'])) $obj->parent = $this->data['parent'];
		if (isset($this->data['level'])) $obj->level = $this->data['level'];

	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('createPage.html');
	}
}

?>