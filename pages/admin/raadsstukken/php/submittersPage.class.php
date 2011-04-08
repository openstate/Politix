<?php

require_once('Council.class.php');
require_once('dist/plugins/function.html_options.php');

class SubmittersPage {
	protected $council;
	protected $date = null;
	protected $submitters = array();

	public function processGet($get) {
		if (isset($get['date'])) {
			$date = explode('-', $get['date']);
			$date = array_filter($date, 'ctype_digit');
			if (count($date) == 3)
				$this->date = strtotime(implode($date, '-'));
		}

		$this->council = Council::getCouncilByDate($_SESSION['role']->getRecord()->id, $this->date);

		if (isset($get['s']))
			$this->submitters = explode(',', $get['s']);
		$this->submitters = array_filter($this->submitters, 'ctype_digit');
	}

	public function show($smarty) {
		echo(smarty_function_html_options(array(
			'id' => 'submitters',
			'name' => 'submitters[]',
			'class' => 'vld_required_select idErrorHandler',
			'multiple' => 'multiple',
			'size' => 16,
			'options' => $this->council->getView()->getMembersByParty(),
			'selected' => $this->submitters,
			'onclick' => 'revalidate(this.form)'
		), $smarty));
	}

}

?>