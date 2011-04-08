<?php

require_once('createPageBase.class.php');
require_once('Region.class.php');
require_once('Level.class.php');

class createPage extends createPageBase {
	


	public function processPost($post) {
		if(isset($post['parent']) && $post['parent'] == 'null')
			$post['parent'] = NULL;
		parent::processPost($post);
	}

	public function saveToObject() {
		require_once('Region.class.php');
		$obj = new Region();
		$this->doSaveToObject($obj);
		$obj->save();
	}


	public function show($smarty) {
				
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
		}
		
		$smarty->assign('regions', $result);
		$smarty->assign('parents', Region::getDropDownRegionsAll());		
		parent::show($smarty);
	}


	public function action() {		
		$this->saveToObject();		
		Dispatcher::header('../');
	}



}

?>