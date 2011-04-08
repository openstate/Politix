<?php

require_once('User.class.php');

class FrontofficeUser extends User {
	protected $tableName = 'usr_users';
	protected $cookieName = 'user';

	protected static $gettext = null;

	protected $data = array(
		'firstname'   => '',
		'lastname'    => '',
		'gender_is_male'      => 0,
		'postalcode'  => '',
	);

	public function formatName() {
		return FrontofficeUser::formatUserName($this->firstname, $this->lastname, $this->gender_is_male);
	}

	public static function formatUserName($firstName, $lastName, $gender) {
		if (!FrontofficeUser::$gettext) {
			FrontofficeUser::$gettext = new GettextPO($_SERVER['DOCUMENT_ROOT'].'/../locale/'.
			(Dispatcher::inst()->locale ? Dispatcher::inst()->locale : 'nl').'/title.po');
		}
		if ($firstName != null)
			return $firstName.' '.$lastName;
		else
			return FrontofficeUser::$gettext->getMsgstr('title.'.($gender ? 'male' : 'female')).' '.ucfirst($lastName);
	}

	/*	public function blacklist($time_end = 'infinity') {
		$bl = new Blacklist();
		$bl->ip = isset($this->ip) ? $this->ip : 'x';
		$bl->email = $this->email;
		$bl->time_start = 'now()';
		$bl->time_end = $time_end;
		$bl->save();
		}*/
}

?>