<?php

/*
	Class: UserPrefs
	Stores preferences for a user.

	This class enables easy storage and retrieval of preferences for a single user.
	Preferences are available as properties of this class ($obj->pref), and preferences
	of any name can be read and set. If a nonexistant preference is queried, its value
	will be *null*.

	Preferences are automatically saved on destruction of this object, so there is no
	need to explicitly save.
*/
class UserPrefs {
	// Property: $user
	// The user object these preferences are for.
	protected $user;

	// Property: $prefs
	// An associative array of preferences.
	protected $prefs = array();

	// Property: $dirty
	// Whether the preferences were changed since the last save.
	protected $dirty = false;

	protected $tableName = 'usr_users_prefs';

	/*
		Constructor: __construct
		Creates a new UserPrefs.

		Parameters:
		$userId - The user id for which the preferences are.
	*/
	public function __construct(User $user) {
		$this->user = $user;
		$this->tableName = $user->tableName.'_prefs';
	}

	public function __destruct() {
		$this->save();
	}

	/*
		Method: load
		Loads the preferences for the user this object was instanced for.
	*/
	public function load() {
		if (!$this->user->id) return;
		$this->prefs = DBs::inst(DBs::SYSTEM)->query('SELECT value, key FROM '.$this->tableName.' WHERE userid = %', $this->user->id)->fetchAllCells('key');

		foreach ($this->prefs as &$val) {
			if (strlen($val)>0 && $val[0] == "\x08") {
				$val = unserialize(substr($val, 1));
			}
		}
	}

	/*
		Method: save
		Saves the preferences to the database.
	*/
	public function save() {
		if (!$this->dirty || !$this->user->id) return;
		$this->dirty = false;

		$db = DBs::inst(DBs::SYSTEM);
		$db->query('begin');
		$db->query('DELETE FROM '.$this->tableName.' WHERE userid = %', $this->user->id);
		foreach ($this->prefs as $key => $val) {
			if (is_array($val))
				$val = "\x08".serialize($val);
			$db->query('INSERT INTO '.$this->tableName.' (userid, key, value) VALUES (%, %, %)', $this->user->id, $key, $val);
		}
		$db->query('commit');
	}

	public function __get($name) {
		if (isset($this->prefs[$name]))
			return $this->prefs[$name];
		else
			return null;
	}

	public function __set($name, $value) {
		if (preg_match('/^([^[]+)\[([^]]+)\]$/', $name, $match))
			$this->prefs[$match[1]][$match[2]] = $value;
		else
			$this->prefs[$name] = $value;
		$this->dirty = true;
	}
}

?>