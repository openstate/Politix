<?php

class dbpagesHandler {
	private $page;

	public $urlMap = array(
		'!^/([a-zA-Z0-9]*)/?$!' => 'handler',
		'!^/pages(/[a-zA-Z0-9]+){0,2}/?$!' => 'adminHandler'
	);

	public function handler($match, array $pageSets) {
		require_once('Page.class.php');
		$p = new Page();

		if ($match[1] == '') $match[1] = 'home';
		if (null != $this->page = $p->loadByUrl($match[1], @Dispatcher::inst()->region)) {
			return array(
				'file'  => dirname(__FILE__).'/pages/view/php/indexPage.class.php',
				'class' => 'indexPage',
				'get'   => array('id' => $match[1])
			);
		} else
			return false;
	}

	public function adminHandler($match, array $pageSets) {
		if (!in_array('admin', $pageSets))
			return;
			
		if(!Dispatcher::inst()->user->rights['pages']->access) {
			return false;
		}

		$parts = explode('/', $match[0]);
		$parts = array_slice($parts, 2);
		if ($parts[count($parts)-1] == '')
			$parts = array_slice($parts, 0, -1);

		if (count($parts)==0)
			$fileName = 'indexPage';
		else {
			$fileName = $parts[0].'Page';
			if (count($parts)>1)
				$id = $parts[1];
		}

		return array(
			'file'  => dirname(__FILE__).'/pages/edit/php/'.$fileName.'.class.php',
			'class' => $fileName,
			'get'   => isset($id) ? array('id' => $id) : array()
		);
	}

	public function getCrumbs() {
		if ($this->page)
			return array(array('url' => '/'.$this->page->id.'/', 'title' => $this->page->title));
		else
			return array();
	}
}

?>