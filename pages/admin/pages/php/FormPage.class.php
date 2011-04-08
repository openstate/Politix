<?php

require_once('FormHandlerLoad.class.php');
require_once('Page.class.php');
require_once('Validate.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');

abstract class FormPage extends FormHandlerLoad {
	protected $pofile;
	protected $page;

	public function __construct() {
		$this->data = array(
			'id'      => null,
			'url'     => null,
			'region'  => null,
			'title'   => null,
			'content' => null,
			'linkText'=> null,
			'showInMenu' => null,
		);

		$this->errors = array(
			'url_required' => false,
			'url_invalid' => false,
			'url_exists' => false,
			'title_required' => false,
			'content_required' => false,
			'linkText_required' => false,
		);
	}

	protected function getRecord() {
		return $this->page;
	}

	protected function loadData($record) {
		$this->data['id'] = $record->id;
		$this->data['url'] = $record->url;
		$this->data['title'] = $record->title;
		$this->data['content'] = $record->content;
		$this->data['linkText'] = $record->linkText;
	}

	protected function assign($post) {
		$this->data['url'] = @trim($post['url']);
		$this->data['title'] = @trim($post['title']);
		$this->data['content'] = @trim($post['content']);
		$this->data['showInMenu'] = $post['showInMenu'];
		$this->data['linkText'] = @trim($post['linkText']);
	}

	protected function validate() {
		if (!strlen($this->data['url'])) $this->errors['url_required'] = true;
		if (!Validate::is($this->data['url'], 'Alnum')) $this->errors['url_invalid'] = true;
		if (!strlen($this->data['title'])) $this->errors['title_required'] = true;
		if (!strlen($this->data['content'])) $this->errors['content_required'] = true;
		if ($this->data['showInMenu'])
			if (!strlen($this->data['linkText'])) $this->errors['linkText_required'] = true;
		return parent::validate();
	}

	protected function save(Record $r) {
		$r->url = $this->data['url'];
		$r->region = $_SESSION['role']->getRecord()->id == 2 ? null : $_SESSION['role']->getRecord()->id;
		$r->title = $this->data['title'];
		$r->content = $this->data['content'];
		$r->showInMenu = $this->data['showInMenu'];
		if ($r->showInMenu)	$r->linkText = $this->data['linkText'];
		$r->save();
	}

	private function getPOFile() {
		if (null == $this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		$this->addMessage(Message::SUCCESS, 'success');
		Dispatcher::header('/pages/');
	}

	protected function error($e) {
		$this->addMessage(Message::ERROR, 'error');
	}

	protected function addMessage($mtype, $type) {
		MessageQueue::addMessage(new Message($mtype, sprintf($this->getPOFile()->getMsgStr('index.'.$type),
																												 $this->getPOFile()->getMsgStr('index.action.'.$this->getAction()))));
	}

	abstract protected function getAction();

	public function show($smarty) {
		parent::show($smarty);
		$smarty->assign('special', $this->getRecord()->isSpecial());
		$smarty->display('formPage.html');
	}
}

?>
