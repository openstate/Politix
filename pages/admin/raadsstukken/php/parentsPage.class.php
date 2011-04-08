<?php

require_once('Raadsstuk.class.php');
require_once('dist/plugins/function.html_options.php');
require_once('dist/plugins/modifier.truncate.php');

class ParentsPage {
	protected $council;
	protected $date = null;
	protected $selected = 0;

	protected function formatParent($rs) {
		return htmlspecialchars(smarty_modifier_truncate(($rs->code ? $rs->code.': ' : '').$rs->title), 80);
	}

	public function processGet($get) {
		if (isset($get['date'])) {
			$date = explode('-', $get['date']);
			$date = array_filter($date, 'ctype_digit');
			if (count($date) == 3)
				$this->date = strtotime(implode($date, '-'));
		}

		$rs = new Raadsstuk();
		$this->parents = $rs->getList('', 'WHERE region = '.$_SESSION['role']->getRecord()->id.' AND t.parent IS NULL'.($this->date ? ' AND '.strftime('\'%Y-%m-%d\'', $this->date).' BETWEEN vote_date - \'2 weeks\'::interval AND vote_date + \'2 weeks\'::interval' : ''));

		if (isset($get['s']) && ctype_digit($get['s']))
			$this->selected = $get['s'];

		if (isset($get['ex']) && ctype_digit($get['ex']))
			unset($this->parents[$get['ex']]);
	}

	public function show($smarty) {
		echo(smarty_function_html_options(array(
			'id' => 'parent',
			'name' => 'parent',
			'options' => array(0 => "\xC2\xA0") + array_map(array($this, 'formatParent'), $this->parents),
			'selected' => $this->selected
		), $smarty));
	}

}

?>