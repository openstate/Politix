<?php

require_once('partyPageBase.class.php');
require_once('SecurityException.class.php');

class PartyPage extends PartyPageBase {
	const HELPER_CLASS_SUFFIX = 'AppointmentPartyHelper';

	protected $localparty;

	public function processGet($get) {
		$role = $_SESSION['role'];
		if (!isset($role)) {
			Dispatcher::header('/');
		} else {
			$className = get_class($role) . self::HELPER_CLASS_SUFFIX;
			require_once($className.'.class.php');
			$helper = new $className($role);
			$partyId = $helper->getID($get);
			try {
				$helper->isAllowed($partyId);
			} catch (SecurityException $e) {
				$helper->forbidden();
			}
		}

		if (isset($get['all']))
			$_SESSION['includeExpired'] = true;
		elseif (isset($get['curr']))
			unset($_SESSION['includeExpired']);
		$this->includeExpired = isset($_SESSION['includeExpired']);

		$this->localparty = new LocalParty($partyId);
		$_SESSION['roleCache']['localparty'] = $this->localparty; // Removes complexity in create page
	}

	public function show($smarty) {
		$this->loadFromObject($this->localparty->id);
		$smarty->assign('localparty', $this->localparty);
		$smarty->assign('includeExpired', $this->includeExpired);
		parent::show($smarty);
	}
}

?>