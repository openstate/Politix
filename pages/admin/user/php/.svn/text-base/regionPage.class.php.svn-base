<?php
require_once('Region.class.php');
require_once('Level.class.php');
require_once('BackofficeUser.class.php');

class regionPage {
	protected $id;
	private $regions = null;	

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::badRequest();
		
		$this->id = $get['id'];
	}
	
	public function processPost($post) {
		var_dump($post);
		if(!isset($post['userid']) || !ctype_digit($post['userid']) || !is_array($post['regions'])) {
			Dispatcher::header('../');
		}

		$db = DBs::inst(DBs::SYSTEM);
		
		$db->query('BEGIN');
		try {
			$db->query('DELETE FROM sys_region_users WHERE bo_user = ' . $post['userid']);
			foreach($post['regions'] as $id) {
				$db->query('INSERT INTO sys_region_users (%l) VALUES (%l)', '"bo_user","region"', $post['userid'] . ',' . $id);
			}
		} catch(Exception $e) {
			$db->query('ROLLBACK');
			throw($e);
		}
		$db->query('COMMIT');
		Dispatcher::header('/user/region/'.$post['userid']);
	}
	
	private function getSubRegions($parentId = 0, $list = array()) {
		$db = DBs::inst(DBs::SYSTEM);
		if($this->regions === null)
			$this->regions = $db->query('SELECT id, name, level, (CASE WHEN parent IS NULL THEN \'0\' ELSE parent END) AS parent_id FROM sys_regions ORDER BY level')->fetchAllRows(false, 'parent_id');
			
		if(isset($this->regions[$parentId])) {
			foreach($this->regions[$parentId] as $region) {
				$list[] = array(
					'id' => $region['id'],
					'name' => $region['name'],
					'level' => $region['level'],
					'parent' => $region['parent_id']
				);
				$list = $this->getSubRegions($region['id'], $list);
			}
		}
		return $list;
	}
	
	public function show($smarty) {
		$r = new Region();
		/*$regions = $obj->getList($order = 'ORDER BY parent');
		$regionsArray = array();		
		foreach($regions as $reg) {			
			$regionsArray[] = $reg;				
		}*/		

		$level = new Level();
		$smarty->assign('levels', $level->getList($order = 'ORDER BY id'));
		$smarty->assign('regions', $this->getSubRegions());
		$smarty->assign('selectedRegions', $r->loadBySecretary($this->id));
				
		$user = new BackofficeUser();
		$user->load($this->id);
		$smarty->assign('user', $user);
		$smarty->assign('userid', $this->id);
		$smarty->display('regionPage.html');
	}
}

?>