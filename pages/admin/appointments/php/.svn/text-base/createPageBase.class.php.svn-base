<?php

abstract class createPageBase {
	protected $data;
	protected $errors = array();
	protected $dataLoaded = false;
	protected $politician;

	public function __construct() {
		$this->clear();
		$this->errors = array(
			'region_0' => false,
			'party_0' => false,
			'category_0' => false,
			'time_start_0' => false,
			'time_end_0' => false,
			'time_start_1' => false
		);
	}
	
	public function clear() {
		$t = getdate();
		$et = mktime(0,0,0, $t['mon'], $t['mday'], $t['year']+1);
		$this->data = array(
			'id' => false,
			'region' => '',
			'party' => '',
			'category' => '',
			'time_start' => array('unix' => $t[0], 'format' => date("Y-m-d", $t[0])) ,
			'time_end' => array('unix' => $et, 'format' => date("Y-m-d", $et)),
			'description' => ''
		);
	}
	
	public function null() {
		$this->data = array(
			'id' => false,
			'region' => null,
			'party' => null,
			'category' => null,
			'time_start' => null,
			'time_end' => null,
			'description' => null
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

	private function setDate($date) {
		if (preg_match('/^[0-9]{1,2}$/', $date['Date_Day']) &&
				preg_match('/^[0-9]{1,2}$/', $date['Date_Month']) &&
				preg_match('/^20[0-9]{2}$/', $date['Date_Year'])) {
			$unixtime = mktime(0, 0, 0, $date['Date_Month'], $date['Date_Day'], $date['Date_Year']);
			return array('unix' => $unixtime, 'format' => date("Y-m-d", $unixtime));
		}
	}

	public function setPost($post) {
		$this->null();
		// Conversions from post data to actual values
		// For example, checkboxes use $data[] = isset($post[]);

		// Assignments from post data
		if (isset($post['region'])) $this->data['region'] = $post['region'];
		if (isset($post['party'])) $this->data['party'] = $post['party'];
		if (isset($post['category'])) $this->data['category'] = $post['category'];
		if (isset($post['date_start'])) $this->data['time_start'] = $this->setDate($post['date_start']);
		if (isset($post['date_end'])) $this->data['time_end'] = $this->setDate($post['date_end']);
		if (isset($post['description'])) $this->data['description'] = $post['description'];
		$this->dataLoaded = true;
	}

	public function validateReduce($prev, $curr) {
		return $prev || $curr;
	}

	public function validate() {
		$r = new Region();
		if (!(isset($this->data['region']) && ctype_digit($this->data['region']) && $this->data['region'] > 0 && $r->exists($this->data['region']))) $this->errors['region_0'] = true;
		$p = new Party();
		$lp = new LocalParty();
		if (!(isset($this->data['party']) && ctype_digit($this->data['party']) && $this->data['party'] > 0 && $p->exists($this->data['party']))) {
			$this->errors['party_0'] = true;
		} else {
			if (!$this->errors['region_0']) {
				if ($lp->loadLocalParty($this->data['party'], $this->data['region']) === false) $this->errors['party_0'] = true;
			}
		}
		$c = new Category();
		if (!(isset($this->data['category']) && ctype_digit($this->data['category']) && $this->data['category'] > 0 && $c->exists($this->data['category']))) $this->errors['category_0'] = true;
		if (!isset($this->data['time_start'])) $this->errors['time_start_0'] = true;
		if (!isset($this->data['time_end'])) $this->errors['time_end_0'] = true;
		if (isset($this->data['time_start']) && isset($this->data['time_end'])) {
			if ($this->data['time_start']['unix'] >= $this->data['time_end']['unix']) $this->errors['time_start_1'] = true;
		}
	
		return !array_reduce($this->errors, array($this, 'validateReduce'), false);
	}

	public function doSaveToObject($obj) {
		if ($this->data['id'])
			$obj->load($this->data['id']);
		$this->saveProperties($obj);
	}

	public function saveProperties($obj) {
		$obj->politician = $this->politician->id;
		if (isset($this->data['region'])) $obj->region = $this->data['region'];
		if (isset($this->data['party'])) $obj->party = $this->data['party'];
		if (isset($this->data['category'])) $obj->category = $this->data['category'];
		if (isset($this->data['time_start'])) $obj->time_start = $this->data['time_start']['format'];
		if (isset($this->data['time_end'])) $obj->time_end = $this->data['time_end']['format'];
		if (isset($this->data['description'])) $obj->description = $this->data['description'];
	}


	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('createPage.html');
	}
}

?>