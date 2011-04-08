<?php

require_once('FormHandler.class.php');
require_once('Raadsstuk.class.php');
require_once('GettextPOModule.class.php');
require_once('Message.class.php');
require_once('Category.class.php');
require_once('RaadsstukCategory.class.php');
require_once('RaadsstukType.class.php');
require_once('RaadsstukTag.class.php');
require_once('RaadsstukSubmitType.class.php');
require_once('Council.class.php');
require_once('Submitter.class.php');
require_once('SubmitterParty.class.php');
require_once('Tag.class.php');
require_once('InputFilterFactory.class.php');
require_once('Site.class.php');

abstract class FormPage extends FormHandler {
	protected $pofile;
	protected $council;
	protected $parents;
	protected $toVotes;

	const MAX_SUMMARY = 20480; //20k

	public function __construct() {
		$this->data = array(
			'id' => null,
			'title' => null,
			'vote_date_array' => null,
			'vote_date' => null,
			'summary' => null,
			'code' => null,
			'type' => null,
			'type_name' => null,
			'tags' => null,
			'submitters' => null,
			'parent' => null,
			'show' => true,
			'unrestrict_parent' => false,
		);

		$this->errors = array(
			'title_required' => false,
			'date_invalid' => false,
			'summary_too_large' => false,
			'code_required' => false,
			'type_invalid' => false,
			'submitters_required' => false,
		);
	}

	public function processGet() {
		$this->loadLists();
	}

	protected function formatParent($rs) {
		return ($rs->code ? $rs->code.': ' : '').$rs->title;
	}

	protected function loadLists() {
		$date = strtotime($this->data['vote_date']);
		$this->council = Council::getCouncilByDate($_SESSION['role']->getRecord()->id, $date);
		$rs = new Raadsstuk();
		$this->parents = array(0 =>  "\xC2\xA0") + array_map(array($this, 'formatParent'), $rs->getList('', 'WHERE region = '.$_SESSION['role']->getRecord()->id.($this->data['id'] ? ' AND t.id != '.$this->data['id'] : '').' AND t.parent IS NULL'.(!$this->data['unrestrict_parent'] ? ' AND \''.($date ? strftime('%Y-%m-%d', $date) : 'now').'\' BETWEEN vote_date - \'2 weeks\'::interval AND vote_date + \'2 weeks\'::interval' : '')));
	}

	protected function assign($post) {
		$this->data['title'] = @trim($post['title']);
		$this->data['vote_date_array'] = array(
			'day' => @$post['Date_Day'],
			'month' => @$post['Date_Month'],
			'year' => @$post['Date_Year']
		);
		$this->data['vote_date'] = @$post['Date_Year'].'-'.@$post['Date_Month'].'-'.@$post['Date_Day'];
		$this->data['summary'] = @trim($post['summary']);
		$this->data['code'] = @trim($post['code']);
		$this->data['type'] = @$post['type'];
		$this->data['site'] = @$post['site'];
		$this->data['tags'] = @$post['tags'];
		$this->data['submitters'] = @$post['submitters'];
		$this->data['categories'] = @$post['cats'];
		$this->data['parent'] = in_array(@$post['type'], array(3, 4)) ? @$post['parent'] : 0;
		$this->data['show'] = @$post['show'] == '1';
		$this->data['unrestrict_parent'] = isset($post['unrestrict_parent']);
		$this->toVotes = isset($post['submit_vote']);
		$this->loadLists();
	}

	protected function validate() {
		if (!strlen($this->data['title'])) $this->errors['title_required'] = true;
		if (!checkdate($this->data['vote_date_array']['month'],
									 $this->data['vote_date_array']['day'],
									 $this->data['vote_date_array']['year']))
			$this->errors['date_invalid'] = true;
		if (strlen($this->data['summary']) > self::MAX_SUMMARY) $this->errors['summary_too_large'] = true;
		if (!strlen($this->data['code'])) $this->errors['code_required'] = true;
		if (!ctype_digit($this->data['type'])) $this->errors['type_invalid'] = true;
		if (!ctype_digit($this->data['site'])) $this->errors['site_invalid'] = true;
		if (!@count($this->data['submitters'])) $this->errors['submitters_required'] = true;
		return parent::validate();
	}

	protected function save(Record $r) {
		$rst = new RaadsstukSubmitType();

		$r->region = $_SESSION['role']->getRecord()->id;
		$r->title = $this->data['title'];
		$r->vote_date = $this->data['vote_date'];
		$filter = InputFilterFactory::filterHtmlStrict();
		$r->summary = $filter->process($this->data['summary']);
		$r->code = $this->data['code'];
		$r->type = $this->data['type'];
		$r->submitter = $rst->getSubmitType($this->data['type'], $this->data['submitters']);
		$r->parent = $this->data['parent'] ? $this->data['parent'] : null;
		$r->show = $this->data['show'] ? 1 : 0;
		$r->site_id = $this->data['site'];
		$r->save();

		$rc = new RaadsstukCategory();
		$rc->deleteByRaadsstuk($r->id);

		foreach (@$this->data['categories'] as $c) {
			$rc = new RaadsstukCategory();
			$rc->raadsstuk = $r->id;
			$rc->category = $c;
			$rc->save();
		}

		$obj = new Submitter();
		$obj->deleteByRaadsstuk($r->id);

		if (3 == $r->submitter) { //Initiatief voorstel, Amendement, Motie
			foreach ($this->data['submitters'] as $s) {
				$obj = new Submitter();
				$obj->raadsstuk = $r->id;
				$obj->politician = $s;
				$obj->save();
			}
		}

		$par = new SubmitterParty();
		$par->deleteByRaadsstuk($r->id);

		if(19 == $r->submitter) { //Partij
			if($this->data['submitters'] != '%') {
				$obj = new SubmitterParty();
				$obj->raadsstuk = $r->id;
				$obj->party = intval($this->data['submitters']);
				$obj->save();
			}
		}

		$rt = new RaadsstukTag();
		$currTags = $rt->getTagsByRaadsstukOnName($r->id);
		$allTags = Tag::getAssociativeOnName();

		foreach (@$this->data['tags'] as $t) {
			//$t = ucfirst($t);
			if (!($id = @$allTags[$t])) {
				$tag = new Tag();
				$tag->name = $t;
				$tag->save();
				$id = $tag->id;
			}
			if (!isset($currTags[$t])) {
				$rt = new RaadsstukTag();
				$rt->raadsstuk = $r->id;
				$rt->tag = $id;
				$rt->save();
			} else {
				unset($currTags[$t]);
			}
		}
		foreach ($currTags as $t) {
			$t->delete();
		}

		DBs::inst(DBs::SYSTEM)->query('select add_tags_to_vector('.$r->id.')');
	}

	private function getPOFile() {
		if (null == $this->pofile)
			$this->pofile = new GettextPOModule('index.po');
		return $this->pofile;
	}

	protected function action() {
		if ($this->toVotes) {
			$this->addMessage(Message::SUCCESS, 'success');
			Dispatcher::header('/raadsstukken/vote/'.$this->getRecord()->id);
		} else
			Dispatcher::header('/raadsstukken/');
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
		$rt = new RaadsstukType();
		$rst = new RaadsstukSubmitType();

		$sites = array();
		foreach ($_SESSION['user']->listSites() as $site) $sites[$site->id] = $site->title;

		$par = new Party();
		$parties = array('%' => $this->getPOFile()->getMsgStr('index.regering'));

		foreach ($par->loadByRegion(Dispatcher::inst()->region->id, 'ORDER BY name') as $id => $pt) {//why this is not a static method
			$parties[$pt->id] = $pt->name;
		}

		parent::show($smarty);
		$smarty->assign('sites', $sites);
		$smarty->assign('categories', Category::getDropdownCategoriesAll());
		$smarty->assign('types', $rt->getAssociativeOnId());
		$smarty->assign('allTags', json_encode(Tag::getNames()));
		$smarty->assign('councilMembers', $this->council->getMembers());
		$smarty->assign('councilView', $this->council->getView()->getMembersByParty());
		$smarty->assign('all_parties', $parties);
		$smarty->assign('rs_submitters', $rst->getRaadsstukTypes());
		$smarty->assign('rs_parents', $this->parents);
		$smarty->display('formPage.html');
	}
}

?>
