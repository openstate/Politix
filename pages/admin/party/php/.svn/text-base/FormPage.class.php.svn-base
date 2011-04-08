<?php

require_once('FormHandler.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');
require_once('Party.class.php');
require_once('PartyParent.class.php');
require_once('RegionAddHelper.class.php');

abstract class FormPage extends FormHandler {
	protected $pofile;

	public function __construct() {
		$this->data = array(
			'title' => null,
			'combination' => null,
			'parents' => null,
		);

		$this->errors = array(
			'title_required' => false,
			'parents_required' => false,
		);
	}

	protected function assign($post) {
		$this->data['title'] = @trim($post['title']);
		$this->data['combination'] = @$post['combination'];
		$this->data['parents'] = @$post['parents'];
		$this->data['owner'] = @$post['owner'];
	}

	protected function validate() {
		if (!strlen($this->data['title'])) $this->errors['title_required'] = true;
		if ($this->data['combination'] && @count($this->data['parents']) < 2) $this->errors['parents_required'] = true;
		return parent::validate();
	}

	protected function save(Record $r) {
		$r->name = $this->data['title'];
		$r->combination = $this->data['combination'] ? 1 : 0;
		$r->owner = Dispatcher::inst()->user->isSuperAdmin() ? $this->data['owner'] : $_SESSION['role']->getRecord()->id;
		$r->save();

		$obj = new PartyParent();
		$obj->deleteByParty($r->id);

		if ($this->data['combination']) {
			foreach ($this->data['parents'] as $p) {
				$obj = new PartyParent();
				$obj->party = $r->id;
				$obj->parent = $p;
				$obj->save();
			}
		}

		if (!Dispatcher::inst()->user->isSuperAdmin()) {
			try {
				$rh = new RegionAddHelper();
				$rh->save($r);
			} catch (Exception $e) {}
		}
	}

	private function getPOFile() {
		if (!$this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		$this->addMessage(Message::SUCCESS, 'success');
		Dispatcher::header('/party/');
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
		parent::show($smarty);
		$r = new Region();
		$smarty->assign('regions', $r->getDropDownRegionsAll());
		$smarty->assign('showOwner', Dispatcher::inst()->user->isSuperAdmin());
		$smarty->display('formPage.html');
	}
}

?>
