<?php

class searchHandler {
	private $params;

	public $urlMap = array(
		'!^/search(/.+)*?/?$!' => 'handler',
		'!^((?:/(?:partij|politicus)/.+)+)/?$!' => 'magic_handler'

	);

	public function magic_handler($match, array $pageSets) {
		$db = DBs::inst(DBs::SYSTEM);

		$parts = explode('/', $match[0]);
		$parts = array_slice($parts, 1);
		$get = array();
		for ($i = 0; $i < count($parts); $i += 2) {
			if ($parts[$i] == 'partij') {
				$extra = $db->query('SELECT pr.party, pr.region FROM pol_parties p JOIN pol_party_regions pr ON pr.party = p.id WHERE slug(name) = %'.(Dispatcher::inst()->region ? ' AND pr.region = %' : ''), strtolower($parts[$i+1]), (Dispatcher::inst()->region ? Dispatcher::inst()->region->id : 0))->fetchRow();
				if (!$extra)
					$extra = $db->query('SELECT pr.party, pr.region FROM pol_parties p JOIN pol_party_regions pr ON pr.party = p.id WHERE slug(short_form) = %'.(Dispatcher::inst()->region ? ' AND pr.region = %' : ''), strtolower($parts[$i+1]), (Dispatcher::inst()->region ? Dispatcher::inst()->region->id : 0))->fetchRow();

				if (!$extra)
					return false;

				$_GET = array_merge($_GET, $extra, array('submit' => true, 'magic' => true));
			}
		}

		$fileName = $_SERVER['DOCUMENT_ROOT'].'/../pages/watstemtmijnraad/search/php/indexPage.class.php';
		$className = 'IndexPage';

		return array(
			'file'  => $fileName,
			'class' => $className,
			'get'   => array()
		);
	}

	public function handler($match, array $pageSets) {			
		$parts = explode('/', $match[0]);
		$parts = array_slice($parts, 2);
		$get = array();
		for ($i = 0; $i < count($parts); $i += 2) {
			$_GET[$parts[$i]] = @$parts[$i+1];
		}

		$fileName = $_SERVER['DOCUMENT_ROOT'].'/../pages/watstemtmijnraad/search/php/indexPage.class.php';
		$className = 'IndexPage';

		return array(
			'file'  => $fileName,
			'class' => $className,
			'get'   => array()
		);
	}
}

?>