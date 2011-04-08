<?php

require_once('Raadsstuk.class.php');
require_once('Page.class.php');

define("RECENT_ITEMS", 3);

class IndexPage {
	public function show($smarty) {
		$p = new Page();
		$smarty->assign('recent', $this->getRecent());
		$smarty->assign('page', $p->loadByUrl('home', Dispatcher::inst()->region));
		$smarty->display('indexPage.html');
	}

	private function getRecent() {
		$limit = RECENT_ITEMS;
		$oldCount = $count = 0;
		while (true) {
			$items = $this->getRecentHelper($limit);
			$count = count($items);
			if ($count == $oldCount) return array_slice($items, 0, RECENT_ITEMS);
			$regions = array();
			foreach ($items as $item) {
				if (!isset($regions[$item->region]))
					$regions[$item->region] = $item;
			}
			if (count($regions) >= RECENT_ITEMS) return array_slice($regions, 0, RECENT_ITEMS);
			$limit *= 2;
			$oldCount = $count;
		}
	}

	private function getRecentHelper($limit) {
		$r = new Raadsstuk();
		$ids = array_keys(isset($_SESSION['user'])? $_SESSION['user']->listSiteIds(): User::listDefaultSiteIds());
		return $r->getList('where site_id IN('.implode(', ', $ids).') AND show = 1'.(null != $e = &Dispatcher::inst()->region ? ' and region = '.$e->id : ''), 'order by vote_date desc', 'limit '.$limit);
	}
}

?>