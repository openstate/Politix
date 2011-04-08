<?php

abstract class editPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
		
		
		$this->errors = array(
			'title_0' => false,
			'content_0' => false,

		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'id' => '',
			'title' => '',
			'content' => '',

		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'id' => null,
			'title' => null,
			'content' => null,

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
		$this->data['content'] = $post['form_content'] = (isset($post['form_content']) ? safeHtml($post['form_content']) : null);

		// Assignments from post data
		$this->data['id'] = $post['id'];
		if (isset($post['id'])) $this->data['id'] = $post['id'];
		if (isset($post['title'])) $this->data['title'] = $post['title'];

		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['title']) && $this->data['title']!='')) $this->errors['title_0'] = true;
		if (!(isset($this->data['content']) && $this->data['content']!='')) $this->errors['content_0'] = true;

		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	


	public function loadData($obj) {
		$this->data['id'] = $obj->id;
		$this->data['id'] = $obj->id;
		$this->data['title'] = $obj->title;
		$this->data['content'] = $obj->content;

	}





	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['title'])) $obj->title = $this->data['title'];
		if (isset($this->data['content'])) $obj->content = $this->data['content'];

	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('editPage.html');
	}
}

?>