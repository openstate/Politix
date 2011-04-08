<?php

require_once('LocalParty.class.php');
require_once('Region.class.php');
require_once('Party.class.php');
require_once('BackofficeUser.class.php');
require_once('Message.class.php');

class regionsPage {
	protected $id = null;
	protected $edit = null;
	private $message = '';
	private $formdata = null;
	
	public function processGet($get) {
		if (!Dispatcher::inst()->user->isSuperAdmin())
			Dispatcher::forbidden();
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
		$this->id = $get['id'];
		
		if(isset($get['edit']) && ctype_digit($get['edit']))
			$this->edit = $get['edit'];		
	}
	
	public function processPost($post) {
		if(isset($post['delete'])) {
			if(!isset($post['prs']))
				return;
			foreach($post['prs'] as $id) {
				$pr = new LocalParty();
				$pr->load($id);
				$pr->delete();
			}		
			$this->addMessage(Message::SUCCESS, 'Regio verwijderd.');
			return;
		} elseif(isset($post['add']) || isset($post['edit'])) {
			$time_start = @$post['TS_Year'].'-'.@$post['TS_Month'].'-'.@$post['TS_Day'];
			$time_end = @$post['TE_Year'].'-'.@$post['TE_Month'].'-'.@$post['TE_Day'];
			if(!isset($post['region']) || 
			   $post['region'] == '') {
				$this->formdata = $post;
				return;
			}
			$pr = new LocalParty();
			if (isset($post['add']))
				$pr->party = $this->id;
			else
				$pr->load($post['id']);
			$pr->region = $post['region'];
			$pr->time_start = $time_start == '--' ? '-infinity' : $time_start;
			$pr->time_end = $time_end == '--' ? 'infinity' : $time_end;
			//$pr->bo_user = $post['secretary'];		
			$pr->save();
			$this->addMessage(Message::SUCCESS, 'Regio toegevoegd.');
			if (isset($post['edit']))
				dispatcher::header('/party/regions/' . $this->id);
		}
	}
	
	protected function addMessage($mtype, $message) {
		MessageQueue::addMessage(new Message($mtype, $message));
	}

	public function show($smarty) {	
		if($this->formdata != null)
			$smarty->assign('formdata', $this->formdata);
			
		$bo = new BackofficeUser();
		$bous = $bo->getList();
		$bo_users = array();	
		$bo_users_show = array();	
		foreach($bous as $value) {
			$bo_users[$value->id] = $value->formatUserSortName();
			$bo_users_show[$value->id] = $value->formatName();
		}
		natcasesort($bo_users);

		$smarty->assign('regions', Region::getDropDownRegionsAll());
		$smarty->assign('bo_users', $bo_users);
		$smarty->assign('bo_users_show', $bo_users_show);

		if($this->edit !== null) {
			$pr = new LocalParty();
			$pr->load($this->edit);
			$smarty->assign('id', $this->id);
			$smarty->assign('formdata', array('id' => $this->edit, 'region' => $pr->region, 'secretary' => $pr->bo_user, 'time_start' => $pr->time_start == '-infinity' ? '--' : $pr->time_start , 'time_end' => $pr->time_end == 'infinity' ? '--' : $pr->time_end));
			if($this->message != '') $smarty->assign('message', $this->message);
			$smarty->display('regionsEditPage.html');
			die;
		}

		$pr = new LocalParty();
		$prs = $pr->getList($where = 'WHERE party = ' . $this->id, $order = 'ORDER BY p.name');
		
		$party = new Party();
		$party->load($this->id);
		$smarty->assign('party', $party);
		
		$smarty->assign('prs', $prs);
		if($this->message != '') $smarty->assign('message', $this->message);
		$smarty->display('regionsPage.html');
	}
}

?>