<?php

require_once('FormHandler.class.php');
require_once('LocalParty.class.php');
require_once('RegionAddHelper.class.php');
require_once('RegionUpdateHelper.class.php');
require_once('RegionDeleteHelper.class.php');
require_once('GettextPOModule.class.php');

class RegionLinkPage extends FormHandler {
	protected $helper;
	protected $pofile;

	public function __construct() {
		$this->data = array(
			'date' => null,
			'date_array' => null
		);

		$this->errors = array(
			'date_invalid' => false
		);
	}

	public function processGet($get) {
		try {
			$this->party = new Party(@$get['id']);
			if (!isset($_SESSION['role'])) throw new Exception();
			$this->loadData($this->party);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
	}

	protected function assign($post) {
		$this->data['date_array'] = array(
			'day' => @$post['Date_Day'],
			'month' => @$post['Date_Month'],
			'year' => @$post['Date_Year']
		);
		$this->data['date'] = @$post['Date_Year'].'-'.@$post['Date_Month'].'-'.@$post['Date_Day'];
	}

	protected function validate() {
		if (!checkdate($this->data['date_array']['month'],
									 $this->data['date_array']['day'],
									 $this->data['date_array']['year']))
			$this->errors['date_invalid'] = true;
		return parent::validate();
	}

	private function loadData($record) {
		$lp = new LocalParty();
		$lp = $lp->loadLocalParty($record->id, $_SESSION['role']->getRecord()->id);

		if ($lp === false) {
			$this->helper = new RegionAddHelper();
		} else {
			if (date('Y-m-d H:i:s') < $lp->time_start) {
				$this->data['date'] = $lp->time_start;
				$this->helper = new RegionUpdateHelper();
			} else {
				$this->data['date'] = $lp->time_end;
				$this->helper = new RegionDeleteHelper();
			}
		}
	}

	protected function save(Record $r) {
		$this->helper->save($r, $this->data['date']);
	}

	private function getPOFile() {
		if (!$this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		$this->addMessage(Message::SUCCESS, 'success');
		Dispatcher::header('../../');
	}

	protected function error($e) {
		$this->addMessage(Message::ERROR, 'error');
	}

	private function addMessage($mtype, $type) {
		MessageQueue::addMessage(new Message($mtype, sprintf($this->getPOFile()->getMsgStr('index.region.'.$type),
																												 $this->getPOFile()->getMsgStr('index.action.'.$this->helper->getAction()))));
	}

	protected function getRecord() {
		return $this->party;
	}

	protected function getFormParameters() {
		return $this->helper->getFormParameters($this->party->name);
	}

	public function show($smarty) {
		parent::show($smarty);
		$smarty->display('regionLinkPage.html');
	}
}

?>