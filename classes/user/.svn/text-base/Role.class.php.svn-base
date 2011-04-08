<?php
// File: Rights

/*
	Class: ModuleAccess
	Class that makes one of the <Role> class' access patterns possible.
*/
class ModuleAccess {
	protected $access = array();

	public function __construct(array $access = array()) {
		$this->access = $access;
		if (count($access) > 0)
			$this->access['access'] = true;
	}

	public function __get($name) {
		return isset($this->access[$name]);
	}
}

/*
	Class: Role
	Contains user rights.
	A set of roles is given, and the combined rights of these roles are available.

	Rights can be checked in two ways:
	1 - The Role class is indexable by module, which returns a class which
	    gives the rights for that module:
		  $role[module]->right
		  will return whether the right is granted or not.
	2 - The <hasRight> method takes a string parameter of the form
	    'module.right', and will return if the right is granted.
*/
class Role implements ArrayAccess {
	// Property: $db
	// Holds a <Database> instance where user rights are stored.
	protected $db;

	// Property: $modules
	// An array of <ModuleAccess> classes
	protected $modules = array();

	// Property: $roleIDs
	// The ids of the roles loaded in this class
	protected $roleIDs = array();

	// Property: $user
	// The user object for which the roles are
	protected $user;

	protected $tableName = 'usr_users_roles';
	protected $rolesTable = 'usr_roles';
	protected $rolesAccessTable = 'usr_roles_access';

	public function __construct(User $user) {
		$this->db = DBs::inst(DBs::SYSTEM);
		$this->user = $user;
		$this->tableName = $user->tableName.'_roles';		
		if($user->tableName != 'usr_users') {
			$this->rolesTable = 'usr_bo_roles';
			$this->rolesAccessTable = 'usr_bo_roles_access';
		}
	}

	public function __sleep() {
		return array('modules');
	}

	public function __wakeup() {}

	/*
		Method: clear
		Clears the access rights.
	*/
	public function clear() {
		$this->modules = array();
		$this->roleIDs = array();
	}

	// Group: Loading methods

	/*
		Method: load
		Loads access data from an array into the internal structures.

		Parameters:
		$data - An array of access data. Each row should contain a key named 'module', the name of the
		        module for which the right is, and a key named 'access', the name of the right. A third
						key, 'id', states the role id the right belongs to.
	*/
	protected function load($data) {
		$this->clear();
		$modules = array();
		foreach ($data as $row) {
			if (!isset($modules[$row['module']]))
				$modules[$row['module']] = array();
			$modules[$row['module']][$row['access']] = true;
			$this->roleIDs[$row['roleid']] = $row['roleid'];
		}

		foreach ($modules as $id => $m)
			$this->modules[$id] = new ModuleAccess($m);
	}

	/*
		Method: loadForUser
		Loads access rights for the associated user.
	*/
	public function loadForUser() {
		if (!$this->user->id)
			throw new Exception('No saved user was associated with this Role instance.');
		$this->load($this->db->query('
			SELECT r.*
			FROM '.$this->tableName.' ur
			JOIN '.$this->rolesAccessTable.' r ON ur.roleid = r.roleid
			WHERE ur.userid=%', $this->user->id)->fetchAllRows());
	}

	/*
		Method: loadIds
		Loads access rights from given roles

		Parameters:
		$roleIds - The IDs of the roles to load. Can be either a single integer, or an array of integers.
	*/
	public function loadIds($roleIds) {
		if (!is_array($roleIds))
			$roleIds = array($roleIds);
		$this->load($this->db->query('SELECT * FROM '.$this->rolesAccessTable.' WHERE roleid IN (%l)', implode(',', $roleIds))->fetchAllRows());
	}

	// Group: Right checking

	/*
		Method: hasRight
		Checks whether a right is granted.

		Parameters:
		$path - A path for a right. This is a string of the form 'module.right'

		Returns:
		A boolean stating whether the right is granted.
	*/
	public function hasRight($path) {
		$path = explode('.', $path);
		if (count($path) == 1)
			$path[] = 'access';
		return $this[$path[0]]->$path[1];
	}

	// Group: Role assignment

	public function addRole($roleID) {
		if (is_array($roleID))
			$this->roleIDs+= array_combine($roleID, $roleID);
		else
			$this->roleIDs[$roleID] = $roleID;
	}

	public function clearRoles() {
		$this->roleIDs = array();
	}

	public function removeRole($roleID) {
		unset($this->roleIDs[$roleID]);
	}

	public function getAssignedRoles() {
		return $this->roleIDs;
	}

	public function saveRoles() {
		if (!$this->user->id)
			throw new Exception('No saved user was associated with this Role instance.');
		$this->db->query('BEGIN');
		try {
			$this->db->query('DELETE FROM '.$this->tableName.' WHERE userid=%', $this->user->id);
			foreach ($this->roleIDs as $role)
				$this->db->query('INSERT INTO '.$this->tableName.' (userid, roleid) VALUES (%, %)', $this->user->id, $role);
		} catch (Exception $e) {
			$this->db->query('ROLLBACK');
			throw $e;
		}
		$this->db->query('COMMIT');
	}

	public function getAvailableRoles() {
		return $this->db->query('SELECT * FROM '.$this->rolesTable)->fetchAllRows('id');
	}

	// ArrayIterator interface
	public function offsetExists($offset)      { return true; }
	public function offsetGet($offset) {
		if (isset($this->modules[$offset]))
			return $this->modules[$offset];
		else
			return new ModuleAccess();
	}
	public function offsetSet($offset, $value) { throw new Exception('Cannot directly set access rights.'); }
	public function offsetUnset($offset)       { throw new Exception('Cannot directly set access rights.'); }
}

?>