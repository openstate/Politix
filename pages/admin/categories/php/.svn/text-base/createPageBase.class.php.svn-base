<?php

abstract class createPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		
		$this->errors = array(
			'category_name_0' => false,

		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'category_name' => '',
			'description' => '',

		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'category_name' => null,
			'description' => null,

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
		$this->data['description'] = $post['description'] = (isset($post['description']) ? safeHtml($post['description']) : null);

		// Assignments from post data
		if (isset($post['category_name'])) $this->data['category_name'] = $post['category_name'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['category_name']) && $this->data['category_name']!='')) $this->errors['category_name_0'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	






	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['category_name'])) $obj->name = $this->data['category_name'];
		if (isset($this->data['description'])) $obj->description = $this->data['description'];

	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('createPage.html');
	}
}

?>