<?php

abstract class createPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	

	public function __construct() {
		$this->clear();
				
		$this->errors = array(
			'title_0' => false,
			'site_0' => false,
		);
		
	}

	
	public function clear() {
		$this->data = array(
			'id' => false,
			'title' => '',
			'site' => '',
		);
	}
	

	
	public function null() {
		$this->data = array(
			'id' => false,
			'title' => null,
			'site' => null,
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
		if (isset($post['title'])) $this->data['title'] = $post['title'];
		if (isset($post['site'])) $this->data['site'] = $post['site'];
		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		if (!(isset($this->data['title']) && $this->data['title']!='')) $this->errors['title_0'] = true;
		if (!(isset($this->data['site']) && $this->data['site']!='')) $this->errors['site_0'] = true;
		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}
	
	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		if (isset($this->data['title'])) $obj->title = $this->data['title'];
		if (isset($this->data['site'])) $obj->site_id = $this->data['site'];
	}


	public function show($smarty) {
		require_once 'Site.class.php';
		$site = new Site();
		$objs = $site->getList('');
		foreach($objs as $obj){
			$this->data['sites'][$obj->id] = $obj->title;
		}
	
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('createPage.html');
	}
}

?>