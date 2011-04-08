<?php

require_once('Pager.class.php');
require_once('Politician.class.php');
require_once('LocalParty.class.php');

class indexPage {
	protected $pager;
	protected $politicians;
	protected $localparties;
	protected $regions;

	/*	protected $sortDefault = 'id';
	protected $sortDirDefault = 'asc';
	protected $sorting = array('col' => '', 'dir' => 'asc');
	protected $sortKeys = array(
			'id' => null
			);*/

	public function processGet($get) {
		$user = Dispatcher::inst()->user;

		$p = new Politician();
		$lp = new LocalParty();
		$r = new Region();

		$this->politicians = $p->loadByBoUser($user->id, "ORDER BY id" /*$this->getOrder()*/);
		$this->localparties = $lp->loadBySecretary($user->id, "ORDER BY id" /*$this->getOrder()*/);
		$this->regions = $r->loadBySecretary($user->id, "ORDER BY id" /*$this->getOrder()*/);
	}

	/*	protected function getOrder($order = '') {
		if ($order == '') { // Use ordering based on sort columns
			if (isset($_GET['sort']) && in_array($_GET['sort'], array('asc','desc')))
				$dir = $_GET['sort'];
			else
				$dir = $this->sortDirDefault;
			if (isset($_GET['sortcol']) && array_key_exists($_GET['sortcol'], $this->sortKeys))
				$sortCol = $_GET['sortcol'];
			else
				$sortCol = $this->sortDefault;

			$order = 'ORDER BY "'.$sortCol.'" '.$dir;
			$this->sorting['col'] = $sortCol;
			$this->sorting['dir'] = $dir;
		}
		return $order;
		}*/

	public function show($smarty) {
		$smarty->assign('politicians', $this->politicians);
		$smarty->assign('localparties', $this->localparties);
		$smarty->assign('regions', $this->regions);
		$smarty->assign('count', count($this->politicians) + count($this->localparties) + count($this->regions));
		$smarty->display('indexPage.html');
	}
}

?>