<?php

require_once('regionPageBase.class.php');
require_once('SecurityException.class.php');

class RegionPage extends RegionPageBase {
	const HELPER_CLASS_SUFFIX = 'AppointmentRegionHelper';

	protected $sortDefault = 'party_name';
	protected $region;

	public function processGet($get) {
		$role = $_SESSION['role'];
		if (!isset($role)) {
			Dispatcher::header('/');
		} else {
			$className = get_class($role) . self::HELPER_CLASS_SUFFIX;
			require_once($className.'.class.php');
			$helper = new $className($role);
			$this->region = $helper->getID($get);
			try {
				$helper->isAllowed($this->region);
			} catch (SecurityException $e) {
				$helper->forbidden();
			}

			if (isset($get['all']))
				$_SESSION['includeExpired'] = true;
			elseif (isset($get['curr'])) {
				unset($_SESSION['includeExpired']);
			}
			$this->includeExpired = isset($_SESSION['includeExpired']);
		}
	}

	public function show($smarty) {
		$this->loadFromObject($this->region);
		$smarty->assign('region', $_SESSION['role']->getRecord());
		$smarty->assign('includeExpired', $this->includeExpired);
		parent::show($smarty);
	}
}

?>