<?php

require_once('FormHandler.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');
require_once('Category.class.php');
require_once('Politician.class.php');
require_once('LocalParty.class.php');

abstract class FormPage extends FormHandler {
	protected $pofile;
	protected $record;
	protected $localparty;
	protected $politician;
	protected $app;

	public function __construct() {
		$this->data = array(
			'politician' => null,
			'category' => null,
			'category_name' => null,
			'time_start_array' => null,
			'time_start' => null,
			'time_end_array' => null,
			'time_end' => null,
			'description' => null,
		);

		$this->errors = array(
			'politician_required' => false,
			'category_invalid' => false,
			'time_start_invalid' => false,
			'time_end_invalid' => false,
			'time_negative' => false,
		);
	}

	public function processGet($get) {
		try {
			$this->politician = new Politician(@$get['politician']);
		} catch (Exception $e) {}

		if (!Dispatcher::inst()->user->isSuperAdmin()) {
			$this->localparty = @$_SESSION['roleCache']['localparty'];
		}

		$this->loadData($this->getRecord());
	}

	protected function getRecord() {
		return $this->app;
	}

	protected function loadData($record) {
		$this->data['politician'] = $record->politician;
		$this->data['category'] = $record->category;
		$this->data['category_name'] = $record->cat_name;
		$this->data['time_start'] = $record->time_start == NEG_INFINITY ? '--' : $record->time_start;
		$this->data['time_end'] = $record->time_end == POS_INFINITY ? '--' : $record->time_end;
		$this->data['description'] = $record->description;
	}

	protected function assign($post) {
		$this->data['politician'] = @$post['politician'];
		$this->data['category'] = @$post['category'];
		$this->data['time_start_array'] = $this->dateArray(@$post['TS_Day'], @$post['TS_Month'], @$post['TS_Year']);
		$this->data['time_start'] = @$post['TS_Year'].'-'.@$post['TS_Month'].'-'.@$post['TS_Day'];
		$this->data['time_end_array'] = $this->dateArray(@$post['TE_Day'], @$post['TE_Month'], @$post['TE_Year']);
		$this->data['time_end'] = @$post['TE_Year'].'-'.@$post['TE_Month'].'-'.@$post['TE_Day'];		
		$this->data['description'] = @trim($post['description']);
	}

	private function dateArray($day, $month, $year) {
		return array('day' => $day, 'month' => $month, 'year' => $year);
	}

	protected function validate() {
		if (!ctype_digit($this->data['category']) && $this->data['category'] != '-1')	$this->errors['category_invalid'] = true;
		if ($this->data['time_start'] != '--' && !checkdateArray($this->data['time_start_array'])) $this->errors['time_start_invalid'] = true;
		if ($this->data['time_end'] != '--' && !checkdateArray($this->data['time_end_array'])) $this->errors['time_end_invalid'] = true;
		if ($this->data['time_end'] != '--' && compareDateArray($this->data['time_start_array'], $this->data['time_end_array']) != -1) $this->errors['time_negative'] = true;
		return parent::validate();
	}

	protected function save(Record $r) {
		$r->category = $this->data['category'];
		$r->time_start = $this->data['time_start'] == '--' ? NEG_INFINITY : $this->data['time_start'];
		$r->time_end = $this->data['time_end'] == '--' ? POS_INFINITY : $this->data['time_end'];
		$r->description = $this->data['description'];
		$r->save();
	}

	private function getPOFile() {
		if (null == $this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		$this->addMessage(Message::SUCCESS, 'success');
		if (null != $this->politician) {
			Dispatcher::header('/appointments/'.$this->politician->id);
		} else {
			Dispatcher::header('/appointments/party/'.$this->localparty->id);
		}
	}

	protected function error($e) {
		$this->addMessage(Message::ERROR, 'error');
	}

	private function addMessage($mtype, $type) {
		MessageQueue::addMessage(new Message($mtype, sprintf($this->getPOFile()->getMsgStr('index.'.$type),
																												 $this->getPOFile()->getMsgStr('index.action.'.$this->getAction()))));
	}

	abstract protected function getAction();

	public function show($smarty) {
		$c = new Category();
		
		parent::show($smarty);
		$smarty->assign('categories', $c->getDropdownCategoriesAll());
		$smarty->display('formPage.html');
	}
}

?>
