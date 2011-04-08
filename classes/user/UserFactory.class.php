<?php

require_once('BaseUserFactory.class.php');
require_once('FrontofficeUser.class.php');
require_once('BackofficeUser.class.php');

class UserFactory extends BaseUserFactory {
	public static function create() {
		if (Dispatcher::inst()->activeSite['publicdir'] == 'backoffice')
			return new BackofficeUser();
		else
			return new FrontofficeUser();
	}
}

?>