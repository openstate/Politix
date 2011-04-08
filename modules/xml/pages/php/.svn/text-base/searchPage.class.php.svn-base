<?php

require_once('SearchEngine.class.php');

class SearchPage {
	public function processGet($get) {
		$engine = new SearchEngine($this->assign($get));
		echo $engine->getResultsXml();
	}

	protected function assign($get) {
		$data = array();
		$data['q'] = @$get['q'];
		$data['region'] = (int)@$get['region'];
		$data['code'] = @$get['code'];
		$data['title'] = @$get['title'];
		$data['summary'] = @$get['summary'];
		$data['category'] = (int)@$get['category'];
		$data['type'] = (int)@$get['type'];
		$data['vote_date'] = @$get['date'];
		$data['tags'] = @$get['tags'];
		return $data;
	}
}

?>