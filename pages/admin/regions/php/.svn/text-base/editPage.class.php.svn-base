<?php

require_once('editPageBase.class.php');
require_once('Region.class.php');
require_once('Level.class.php');

class editPage extends editPageBase {
	private $id;

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
			
		$this->id = $get['id'];
	}

	public function loadFromObject($id) {
		require_once('Region.class.php');
		$obj = new Region();
		$obj->load($id);
		$this->loadData($obj);
	}



	public function saveToObject() {
		require_once('Region.class.php');
		$obj = new Region();
		$this->doSaveToObject($obj);
		$obj->save();
	}


	public function show($smarty) {
		$hasSubs = false;
		$level = new Level();
		$levels = $level->getList();
		$region = new Region();
		$regions = $region->getList();
		$result = array();
		$result[] = array(
							'id' => 'null',
							'level' => 1,
							'name' => $levels[1]->name,
						);
		foreach($regions as $region) {
			$result[] = array(
								'id' => $region->id,
								'level' => $region->level + 1,
								'name' => (isset($levels[($region->level + 1)]) ? $levels[($region->level + 1)]->name : ''),
							);			
			if(!$hasSubs && $region->parent == $this->id) $hasSubs = true;
		}
				
		
		$smarty->assign('hasSubs', $hasSubs);
		$smarty->assign('regions', $result);
		$smarty->assign('parents', Region::getDropDownRegionsAll());
	
	
		$this->loadFromObject($this->id);
		parent::show($smarty);
	}


	public function action() {
		if($this->data['parent'] == 'null' || $this->data['parent'] == '') $this->data['parent'] = NULL;
		$this->saveToObject();
		Dispatcher::header('../');
	}



}

?>