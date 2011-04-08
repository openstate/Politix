<?php

require_once('DBs.class.php');
require_once('UserPrefs.class.php');
require_once('Role.class.php');
require_once('Record.class.php');

class UserException extends Exception { }
class UserDuplicateEmailException extends Exception { };

/*
	Class: User
	Manages a user.

	This user class allows management of users, logging in (direct and by cookie), logging out,
	assigning them access rights (via <$rights>), and managing preferences (via <$prefs>). The
	data for the user is very minimalistic, descendants of this class should add extra data.
*/
class User extends Record {
	/*
		Property: $rights
		Holds the user's rights. This is an instance of the <Role> class.
	*/
	protected $rights = null;

	/*
		Property: $prefs
		Holds the user's preferences. This is an instance of the <UserPrefs> class.
	*/
	protected $prefs = null;

	/*
		Property: $defaultRoles
		Lists the ids of the roles of a logged-out user.
	*/
	protected $defaultRoles = array(0);

	/*
		Property: $loggedIn
		Stores whether the user is logged in or not.
	*/
	protected $loggedIn = false;

	protected $tableName = 'usr_users';

	/*
		Property: $cookieName
		Gives the name of the cookie that stores data to log the user in.
	*/
	protected $cookieName = 'user';

	/*
		Property: $cookieDuration
		Gives the time (in seconds) the cookie given in <$cookieName> will last.
	*/
	protected $cookieDuration = 1209600; //60*60*24*14;

	/*
		Property: $domain
		The domain for which the user cookie is valid. Computed in the constructor.
	*/
	protected $domain;

	/*
		Property: $partial
		Indicates that roles and privileges should not be loaded.
	*/
	protected $partial = false;

	/*
		Constructor: __construct
		Creates a new User.

		A user is created in a logged-out state, with empty (default) preferences, and access
		rights as loaded from <$defaultRoles>.

		Parameters:
		$partial - Indicates that roles and privileges should not be loaded.
	*/
	public function __construct($partial = false) {
		parent::__construct();

		$this->partial = $partial;

		$this->data = array_merge(array(
			'username' => '',
			'password' => '',
			'created'  => '',
			'ip'       => ''
		), $this->data);

		preg_match('/([^.]+\.[^.]+)$/', $_SERVER['HTTP_HOST'], $match);
		$this->domain = '.'.$match[1];
		$this->clear();
	}

	// Group: Login functions

	/*
		Method: clear
		Clears the user object.
	*/
	protected function clear() {
		if (!$this->partial) {
			$this->prefs = new UserPrefs($this);
			$this->prefs->load();
			$this->rights = new Role($this);
			$this->rights->loadIDs($this->defaultRoles);
		}
	}

	/*
		Method: login
		Attempts to log in a user.
		If logging in is successful, the associated data will be loaded into this object. Otherwise, it
		will remain at its previous state.

		Parameters:
		$username - The username of the user
		$password - The unencrypted password of the user
		$cookie   - Whether to return a cookie containing login info for the user so the framework may
		            log the user in without the user needing to enter username and password.

		Returns:
		A boolean stating whether logging in was successful.
	*/
	public function login($username, $password, $cookie = false) {
		$result = $this->db->query('SELECT id FROM '.$this->tableName.' WHERE username = % AND password = %',
			$username, sha1($password))->fetchRow();

		if ($result) {
			$this->doLogin($result['id'], $cookie);
			return $this->loggedIn;
		}
	}

	/*
		Method: doLogin
		Performs the actions required to set the logged-in state on the User object.

		First the user is logged out to clear any remaining data from the previous user, then
		the user data is loaded, and the logged in flag set. If requested, the login cookie is also set.
	*/
	public function doLogin($id, $setCookie) {
		$this->logout();

		$this->load($id);
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->save();

		$this->loggedIn = true;
		if ($setCookie) $this->setCookie();
	}

	/*
		Method: logout
		Logs out the user.
		The object is completely cleared on logout.
	*/
	public function logout() {
		if (!$this->loggedIn) return;
		foreach ($this->data as &$val)
			$val = '';
		$this->loggedIn = false;
		$this->removeCookie();
		$this->clear();
	}

	/*
		Method: cookieLogin
	  Logs the user in using the persistent login cookie.

		Returns:
		Whether login through this method was successful.
	*/
	public function cookieLogin() {
		if (!isset($_COOKIE[$this->cookieName]) || $_COOKIE[$this->cookieName] == '')
			return false;

		$id = $this->db->query('SELECT id FROM '.$this->tableName.' WHERE md5(id || \'|\' || username || \'|\' || created) = %',
			$_COOKIE[$this->cookieName])->fetchCell();

		if ($id) {
			$this->doLogin($id, true);
			return $this->loggedIn;
		} else
			return false;
	}

	/*
		Method: removeCookie
		Removes the persistent login cookie.
	*/
	private function removeCookie() {
		setcookie($this->cookieName, '', time() - 3600, '/', '.' . $this->domain); // delete cookie
		unset($_COOKIE[$this->cookieName]);
	}

	/*
		Method: setCookie
	  Set the persistent login cookie.
	*/
	private function setCookie() {
		$data = md5($this->id.'|'.$this->username.'|'.$this->created);
		setcookie($this->cookieName, $data, time() + $this->cookieDuration, '/', '.'.$this->domain); // two week login cookie
	}

	/*
		Method: refresh
		Reloads data from the database.

		If this function is called, the user's <$rights> are reloaded from the database.
	*/
	public function refresh() {
		parent::refresh();
		$this->rights = new Role($this);
		if (!$this->loggedIn) {
			$this->rights->loadIDs($this->defaultRoles);
		} else {
			$this->rights->loadForUser();
		}
		if (!$this->partial) {
			$this->prefs = new UserPrefs($this);
			$this->prefs->load();
		}
	}

	/*
		Method: loadFromUsername
		Loads a user based on a user name

		Parameters:
		$username - The user name identifying the user
	*/
	public function loadFromUsername($username) {
		$id = $this->db->query('SELECT id FROM '.$this->tableName.' WHERE username = %', $username)->fetchCell();
		if ($id)
			$this->load($id);
		return (bool)$id;
	}

	/*
		Method: loadFromEmail
		Loads a user based on an email address

		Parameters:
		$email - The email address identifying the user
	*/
	public function loadFromEmail($email) {
		return $this->loadFromUsername($email);
	}

	/*
		Method: load
		Loads the user data from the database for a specific user.

		This also loads the users <$rights> and <$prefs>.
	*/
	public function load($id) {
		parent::load($id);
		if (!$this->partial) {
			$this->rights = new Role($this);
			$this->rights->loadForUser();
			$this->prefs = new UserPrefs($this);
			$this->prefs->load();
		}
	}

	/*
		Method: requestNewPassword
		Starts a password reset request for the current user.

		Returns:
		A string hash that must be provided to <confirmNewPassword> to actually have the password
		reset.
	*/
	public function requestNewPassword() {
		if (!$this->id)
			throw new Exception('Attempted to request a new password for a new user');

		$hash = randomString(40);
		if ($this->db->query('UPDATE usr_passwordrequests SET hash=% WHERE userid=%', $hash, $this->id)->affectedRows() == 0)
			$this->db->query('INSERT INTO usr_passwordrequests (userid, hash) VALUES (%, %)', $this->id, $hash);

		return $hash;
	}

	/*
		Method: confirmNewPassword
		Confirms a previously requested password reset.

		Note that this method will load the user associated to the reset request. Also, the
		new password is automatically saved.

		Parameters:
		$hash - The reset request hash, which was returned from <requestNewPassword>.

		Returns:
		*false* if the request hash was not found, otherwise a string with the new password for
		the user.
	*/
	public function confirmNewPassword($hash) {
		$userID = $this->db->query('SELECT userid FROM usr_passwordrequests WHERE hash=%', $hash)->fetchCell();
		if (!$userID)
			return false;

		$this->db->query('DELETE FROM usr_passwordrequests WHERE userid=%', $userID);
		$this->load($userID);

		$password = randomString(8);
		$this->password = $password;
		$this->save();

		return $password;
	}

	/*
		Method: __get
		Magic method used to enable access to some protected properties.

		In this case, we allow the <$loggedIn>, <$rights> and <$prefs> properties to be
		read, but not set.

		Also, for the <Role> and <UserPrefs> classes, we allow <$tableName> to be read.
	*/
	public function __get($name) {
		if ($name == 'loggedIn' || $name == 'rights' || $name == 'prefs' || $name == 'tableName')
			return $this->$name;
		else
			return parent::__get($name);
	}

	public function __set($name, $value) {
		if ($name == 'password')
			$value = sha1($value);
		parent::__set($name, $value);
	}

	/*
		Method: __sleep
		Specifies what properties to serialize.

		We serialize <$loggedIn>, <$prefs> and <$rights>.
	*/
	public function __sleep() {
		$ar = parent::__sleep();
		$ar[]= 'loggedIn';
		$ar[]= 'prefs';
		$ar[]= 'rights';
		$ar[]= 'partial';
		return $ar;
	}

	public function __wakeup() {
		preg_match('/([^.]+\.[^.]+)$/', $_SERVER['HTTP_HOST'], $match);
		$this->domain = '.'.$match[1];
		parent::__wakeup();
	}

	//listSiteIds stubb
	public function listSiteIds() {
		return array('2' => true);
	}

	/**
	 * If $_SESSION['user'] is not available.
	 * @return arrat of ID's
	 */
	public static function listDefaultSiteIds() {
		return array('2' => true);
	}
}

?>
