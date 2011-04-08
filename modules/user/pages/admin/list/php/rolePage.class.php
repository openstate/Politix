<?php

require_once('BackofficeUser.class.php');
require_once('UserRole.class.php');
require_once('Role.class.php');

class rolePage {
	private $id = null;

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
			
		$this->id = $get['id'];
	}
	
	public function processPost($post) {
		
		if(!isset($post['userid']) || !ctype_digit($post['userid']) || !is_array($post['roles']))
			Dispatcher::header('../');
		
		$user = new BackofficeUser();
		$user->load($post['userid']);
							
		$user->rights->clearRoles(); //delete
		foreach($post['roles'] as $roleID) {
			$user->rights->addRole($roleID);
		}
		$user->rights->saveRoles();
	}

	public function show($smarty) {
		
		$user = new BackofficeUser();
		$user->load($this->id);
		
		$smarty->assign('user', $user);
		
		$userRole = new UserRole();
		$allRoles = $userRole->getAllRoles();
		
		$smarty->assign('userid', $this->id);
		
		$roles = array();
		foreach($allRoles as $key => $role) {
			if($role->id != 1)
				$roles[$key] = $role->title;
		}		
		$smarty->assign('roles', $roles);
		
		$userRoles = $userRole->getList($where = 'WHERE userid = ' . $this->id);
				
		$smarty->assign('selectedRoles', array_keys($userRoles));
		
		
		$smarty->display('rolePage.html');
	}
}

?>