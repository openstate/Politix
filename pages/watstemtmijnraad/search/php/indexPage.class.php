<?php

require_once('SearchPage.class.php');
require_once('SearchEngine.class.php');
require_once('SearchPager.class.php');
require_once('SearchQuery.class.php');
require_once('Politician.class.php');
require_once('Party.class.php');
require_once('Region.class.php');
require_once('Appointment.class.php');

class IndexPage extends SearchPage {
	private $searchData = false;
	private $searchFilter;
	private $searchTotals;
	private $searchFields;
	private $searchHeader;
	private $limit = 10;
	private $start;
	private $fts;

	private $skipList = array('start');

	public function processGet($get) {
		if (count($_POST)) return;
		parent::processGet($get);
		if (isset($get['submit']) || strlen(@$get['q'])) {
			$this->start = isset($get['start']) ? $get['start'] : 0;
			$this->searchFields = $this->assign($get);
			$this->search($this->searchFields);
		} else {
			Dispatcher::header('/');
		}
	}

	public function processPost($post) {
		$s = '';
		foreach ($post as $key => $value) {
			if ('' == $value) continue;
			$s .= '/'.$key.'/'.urlencode($value);
		}
		Dispatcher::header('/search'.$s);
	}

	protected function assign($get) {
		$data = array();
		if (isset($get['q'])) {
			$data['q'] = $get['q'];
			if (null != $r = Dispatcher::inst()->region) {
				$data['q'] .= ' '.$r->name;
			}
		}	else {
			$data['region'] = (int)@$get['region'];
			$data['code'] = @$get['code'];
			$data['title'] = @$get['title'];
			$data['summary'] = @$get['summary'];
			$data['category'] = (int)@$get['category'];
			$data['type'] = (int)@$get['type'];
			$data['vote_date'] = @$get['Date_Year'].(@$get['Date_Month']?'-'.$get['Date_Month'].(@$get['Date_Day']?'-'.$get['Date_Day']:''):'');
			$data['party'] = @$get['party'];
			$data['submitter_id'] = @$get['submitter_id'];
			$data['politician_id'] = @$get['politician_id'];
			$data['tags'] = @$get['tags'];
		}
		return $data;
	}

	protected function search($params) {
		$se = &$_SESSION['search'];
		try {
		if (null == $se || $se['id'] != serialize($this->searchFields)) {
			$engine = new SearchEngine($params);
			$se = array('id' => serialize($this->searchFields), 'time' => time(), 'results' => $engine->getResults(), 'fts' => $engine->isFts(), 'filter' => $engine->getFilterInformation(), 'vco' => $engine->getVoteCacheOption());
			switch ($se['vco']) {
				case SearchEngine::VOTE_CACHE_POLITICIAN:
					$total = array(0, 0, 0, 0);
					foreach($se['results'] as $result) {
						$total[0] += $result->vote_0;
						$total[1] += $result->vote_1;
						$total[2] += $result->vote_2;
						$total[3] += $result->vote_3;
					}
					$se['totals'] = $total;
					break;
				case SearchEngine::VOTE_CACHE_PARTY:
					$total = array(0, 0, 0);
					foreach($se['results'] as $result) {
						$total[0] +=  $result->vote_0 && !$result->vote_1 ? 1 : 0;
						$total[1] += !$result->vote_0 &&  $result->vote_1 ? 1 : 0;
						$total[2] +=  $result->vote_0 &&  $result->vote_1 ? 1 : 0;
					}
					$se['totals'] = $total;
					break;
			}
		}

		if (isset($_GET['submitter_id'])) {
			$politician = new Politician((int)$_GET['submitter_id']);
			$app = new Appointment();
			$app = reset($app->loadByPolitician($politician->id, 'ORDER BY time_start DESC', 'LIMIT 1'));
			$party = new Party($app->party);
			$region = new Region($app->region);
			$this->searchHeader = array('Moties / Amendementen ingediend door: ', $politician->formatName(), $party->name, $region->formatName());
		}

		$this->fts = $se['fts'];
		$this->searchData = $se['results'];
		$this->searchFilter = $se['filter'];
		$this->searchTotals = @$se['totals'];

		$this->pager = new SearchPager(count($this->searchData), $this->start, $this->limit);
		} catch (Exception $e) {
			//politician, party, region or something else is not found
			//this cost too much time to fix SearchEngine, better to just ignore
			//such exceptions
			Dispatcher::header('/');
		}
	}

	private function joinFields() {
		$result = array();
		foreach($_GET as $key => $field) {
			if (!in_array($key, $this->skipList))
				$result[] = $key.'='.$field;
		}
		return implode('&amp;', $result);
	}

	public function show($smarty) {
		parent::show($smarty);
		$cnt = count($this->searchData);
		if ($this->start >= $cnt) $this->start = (($cnt - $this->limit) >= 0) ? $cnt - $this->limit : 0;

		$scriptUrl = $_SERVER['SCRIPT_URL'] ? $_SERVER['SCRIPT_URL'] : $_SERVER['REQUEST_URI'];
		$q = SearchQuery::fromString($scriptUrl);
		$smarty->assign('formdata', array_slice($this->searchData, $this->start, $this->limit));
		$smarty->assign('header', $this->searchHeader);
		$smarty->assign('filter', $this->searchFilter);
		$smarty->assign('totals', $this->searchTotals);
		$smarty->assign('time', $q->Date_Year.'-'.$q->Date_Month.'-'.$q->Date_Day);
		$smarty->assign('fts', $this->fts);
		$smarty->assign('stats', array('count' => $cnt,
		                               'start' => $this->start,
		                               'end' => (($end = $this->start + $this->limit) <= $cnt) ? $end : $cnt));

		$q->remove('start');
		$smarty->assign('pager', $this->pager->getHTML('/search'.$q->toString(), 'start', ''));
		$smarty->assign('warning', $cnt == SearchEngine::MAX_RESULTS);
		$smarty->display('indexPage.html');
	}
}

?>