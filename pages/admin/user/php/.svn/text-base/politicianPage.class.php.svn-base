<?php
require_once('Politician.class.php');
require_once('BackofficeUser.class.php');

class politicianPage {
	protected $id;
	private $message = '';

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::badRequest();
		
		$this->id = $get['id'];
	}
	
	public function processPost($post) {
		if(!isset($post['userid']) || !ctype_digit($post['userid']))
			Dispatcher::header('../');
		
		$db = DBs::inst(DBs::SYSTEM);
		
		if(isset($post['delete'])) {
			if(!isset($post['ps']))
				return;
			$politicians = implode(',', $post['ps']);
			try {
				$db->query('DELETE FROM pol_politician_users WHERE bo_user = % AND politician IN ('.$politicians.')', $post['userid']);
				$this->message = 'De geselecteerde rollen zijn verwijderd.';
			} catch (DatabaseQueryException $e) {
				$this->message = 'Er is een fout opgetreden.';
			}
		} elseif(isset($post['add'])) {
			if(!isset($post['politician']))
				return;
			try {
				$db->query('INSERT INTO pol_politician_users VALUES (%, %)', $post['userid'], $post['politician']);
				$this->message = 'De rol is toegevoegd.';
			} catch (DatabaseQueryException $e) {
				$this->message = 'Deze rol bestaat al.';
			}
		}
	}
	
	public function show($smarty) {
		$obj = new Politician();
		$ps = $obj->loadByBoUser($this->id);

		$smarty->assign('politicians', Politician::getDropDownPoliticiansAll());
		$smarty->assign('ps', $ps);

		$user = new BackofficeUser();
		$user->load($this->id);
		$smarty->assign('user', $user);
		$smarty->assign('userid', $this->id);
		if($this->message != '') $smarty->assign('message', $this->message);
		$smarty->display('politicianPage.html');
	}
}

?>