<?php

require_once('indexPageBase.class.php');
require_once('SecurityException.class.php');
require_once('Politician.class.php');

class indexPage extends indexPageBase {
	const HELPER_CLASS_SUFFIX = 'AppointmentHelper';

	protected $sortDefault = 'id';
	protected $politician;

	public function processGet($get) {
		if (!isset($_SESSION['role'])) {
			if (Dispatcher::inst()->user->isSuperAdmin()) {
				if (!isset($get['id']) || !ctype_digit($get['id'])) 
					Dispatcher::header('/');
				else {
					$this->politician = new Politician($get['id']);
				}
			} else {
				Dispatcher::header('/');
			}
		} else {
			$role = $_SESSION['role'];
			// Create a helper class for the role object
			$className = get_class($role) . self::HELPER_CLASS_SUFFIX;
			require_once($className.'.class.php');
			$helper = new $className($role);
			$politicianId = $helper->getID($get);
			try {
				$helper->isAllowed($politicianId);
			} catch (SecurityException $e) {
				$helper->forbidden();
			}

			$this->politician = new Politician($politicianId);
		}

		if (isset($get['all']))
			$_SESSION['includeExpired'] = true;
		elseif (isset($get['curr']))
			unset($_SESSION['includeExpired']);
		$this->includeExpired = isset($_SESSION['includeExpired']);
	}

	public function show($smarty) {
		$this->loadFromObject($this->politician->id);
		$smarty->assign('politician', $this->politician);
		$smarty->assign('includeExpired', $this->includeExpired);
		parent::show($smarty);
	}
}

?>