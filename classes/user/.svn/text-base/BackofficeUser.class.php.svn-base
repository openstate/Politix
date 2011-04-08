<?php

require_once('User.class.php');

class BackofficeUser extends User {
	protected $tableName = 'usr_bo_users';
	protected $cookieName = 'bo_user';

	protected static $gettext = null;
	protected $superAdmin = null;
	protected $sites = null;
	protected $sites_obj = null;

	public $defaultRoles = array('1');
	protected $data = array(
		'firstname' => '',
		'lastname'  => '',
		'gender_is_male' => ''
	);

	public function formatName() {
		return FrontofficeUser::formatUserName($this->firstname, $this->lastname, $this->gender_is_male);
	}

	public static function formatUserName($firstName, $lastName, $gender) {
		if (!BackofficeUser::$gettext) {
			BackofficeUser::$gettext = new GettextPO($_SERVER['DOCUMENT_ROOT'].'/../locale/'.
			(Dispatcher::inst()->locale ? Dispatcher::inst()->locale : 'nl').'/title.po');
		}
		if ($firstName != null)
			return $firstName.' '.$lastName;
		else
			return BackofficeUser::$gettext->getMsgstr('title.'.($gender ? 'male' : 'female')).' '.ucfirst($lastName);
	}

	public function formatUserSortName() {
		$namePrefix = '';
		if (preg_match('/^([^A-Z]+)([A-Z].*)$/', $this->lastname, $matches)) {
			$namePrefix = trim($matches[1]);
			$lastName = trim($matches[2]);
		} else {
			$lastName = $this->lastname;
		}

		$genderTitle = ''; //Politician::gettext()->getMsgstr('title.'.($gender ? 'male' : 'female'));
		if ($this->firstname != null)
			return $lastName.', '.$this->firstname. ($namePrefix ? ' '.$namePrefix : '');
		else
			return $lastName.' '. ($namePrefix ? ' '.ucfirst($namePrefix) : '');
	}

	public function isSuperAdmin() {
		if (null === $this->superAdmin) {
			$roles = $this->db->query('SELECT r.* FROM '.$this->tableName.'_roles ur JOIN usr_bo_roles r ON ur.roleid = r.id WHERE ur.userid='.(int) $this->id)->fetchAllRows();
			foreach ($roles as $role) {
				if ($role['title'] == 'superadmin') {
					$this->superAdmin = true;
					return true;
				}
			}
			$this->superAdmin = false;
		}
		return $this->superAdmin;
	}

	public function canEditParty(Party $p) {
		if ($this->isSuperAdmin()) return true;
		$region = $_SESSION['role']->getRecord();
		return $region->id == $p->owner;
	}


	/**
	 * List all sites where this user has role in.
	 * @return array list of site id's
	 */
	public function listSiteIds() {
		if($this->sites == null) {
			$roles = $this->db->query('SELECT r.* FROM '.$this->tableName.'_roles ur JOIN usr_bo_roles r ON ur.roleid = r.id WHERE ur.userid='.(int) $this->id)->fetchAllRows();

			$ret = array();
			foreach ($roles as $role) $ret[$role['site_id']] = true;
			$this->sites = $ret;
		}

		return $this->sites;
	}

	/**
	 * Returns list of Site's associated to this user by the roles.
	 * @return array list of Site objects
	 */
	public function listSites() {
		if(!class_exists('Site')) require_once('Site.class.php');

		if($this->sites_obj == null) {
			$ids = array_keys($this->listSiteIds());

			if(!empty($ids)) {
				$ret = new Site();
				$this->sites_obj = $ret->getList(null, 'WHERE id IN ('.implode(', ', $ids).')');
			} else return array();
		}
		return $this->sites_obj;
	}
}

?>