<?php
require_once('ObjectList.class.php');

class Politician extends Record {
	protected $data = array(
		'title'          => null,
		'first_name'     => null,
		'last_name'      => null,
		'gender_is_male' => null,
		'photo'          => null,
		'email'          => null,
		'region_created' => null,
		'extern_id'	     => null,
	);
	protected $tableName = 'pol_politicians';
	protected $functionsTableName = 'pol_politician_functions';
	protected $politicianUsersTableName = 'pol_politician_users';
	protected $timeKey = 'time';

	protected static $gettext = null;

	public function loadFiltered($filter, $order = '') {
		$query = 'SELECT DISTINCT t.* FROM '.$this->tableName.' t JOIN '.$this->functionsTableName.' f ON t.id = f.politician WHERE TRUE';
		foreach($filter as $key => $val) {
			if (strtolower($key) == $this->timeKey)
				$query .= $this->db->formatQuery(' AND % BETWEEN f.time_start AND f.time_end', $val);
			else
				$query .= $this->db->formatQuery(' AND f.'.$key.'=%', $val);
		}
		$politicians = $this->db->query($query.' '.$order)->fetchAllRows();
		$politicianList = new ObjectList(get_class());
		foreach ($politicians as $politician) {
			$obj = new Politician();
			$obj->loadFromArray($politician);
			$politicianList->add($obj);
		}
		return $politicianList;
	}

	public function loadByBoUser($boUser, $order='', $limit='') {
		return $this->getList('JOIN '.$this->politicianUsersTableName.' u ON t.id = u.politician', 'WHERE u.bo_user = '.$boUser, $order, $limit);
	}

	public function loadByParty($localparty, $includeExpired = false, $order='', $limit='') {
		$query = 'SELECT t.*, pf.id AS pid, pf.time_start, pf.time_end, pf.description, c.name AS cat_name FROM '.$this->tableName.' t JOIN '.$this->functionsTableName.' pf ON t.id = pf.politician JOIN pol_party_regions pr ON pf.party = pr.party AND pf.region = pr.region JOIN sys_categories c ON pf.category = c.id WHERE '.(!$includeExpired ? 'pf.time_end > now() AND ' : '').'pr.id = '.$localparty;
		return $this->db->query($query.' '.$order.' '.$limit)->fetchAllRows();
	}

	public function formatName() {
		return Politician::formatPoliticianName($this->title, $this->first_name, $this->last_name, $this->gender_is_male);
	}

	public function formatSortName() {
		return Politician::formatPoliticianSortName($this->title, $this->first_name, $this->last_name, $this->gender_is_male);
	}

	protected static function gettext() {
		if (!Politician::$gettext) {
			Politician::$gettext = new GettextPO($_SERVER['DOCUMENT_ROOT'].'/../locale/'.
			(Dispatcher::inst()->locale ? Dispatcher::inst()->locale : 'nl').'/title.po');
		}
		return Politician::$gettext;
	}

	public static function formatPoliticianName($title, $firstName, $lastName, $gender) {
		$genderTitle = ''; //Politician::gettext()->getMsgstr('title.'.($gender ? 'male' : 'female'));
		if ($firstName != null)
			return ($gender ? '' : $genderTitle.' ').$title.' '.$firstName.' '.$lastName;
		else
			return ($gender && isset($title) ? '' : $genderTitle.' ').$title.' '.ucfirst($lastName);
	}

	public static function formatPoliticianSortName($title, $firstName, $lastName, $gender) {
		$namePrefix = '';
		if (preg_match('/^([^A-Z]+)([A-Z].*)$/', $lastName, $matches)) {
			$namePrefix = trim($matches[1]);
			$lastName = trim($matches[2]);
		}

		$genderTitle = ''; //Politician::gettext()->getMsgstr('title.'.($gender ? 'male' : 'female'));
		if ($firstName != null)
			return $lastName.', '.($gender ? '' : $genderTitle.' '). ($title ? $title.' ' : '') .$firstName. ($namePrefix ? ' '.$namePrefix : '');
		else
			return $lastName.' '.($gender && isset($title) ? '' : $genderTitle.' ').$title. ($namePrefix ? ' '.ucfirst($namePrefix) : '');
	}

	public static function getDropDownPoliticiansAll() {
		$p = new Politician();
		$ps = $p->getList($order = 'ORDER BY name_sortkey, last_name, first_name');

		$result = array();
		foreach($ps as $p) {
			$result[$p->id] = $p->formatSortName();
		}

		return $result;
	}

	public static function getDropDownPoliticians($party, $region = null, $includeExpired = false) {
		if (!$party) return array();
		if(($region != null && !ctype_digit((string)$region)) || !ctype_digit((string)$party)) return array(); //FUCK!!! This was a security hole!

		$pol = new Politician();
		//fuck, we don't have escaping functionality in Record, so parameters will be passes as is... at least we are sure they are numbers...
		return array_map(create_function('$p', 'return $p->formatName();'), $pol->getList('JOIN pol_politician_functions pf ON t.id = pf.politician JOIN pol_party_regions pr ON pf.party = pr.party AND pf.region = pr.region JOIN sys_categories c ON pf.category = c.id WHERE '.(!$includeExpired ? 'pf.time_end > now() AND ' : '').'pr.'.($region ? 'party' : 'id').' = '.$party.($region ? ' AND pr.region = '.$region : '').' ORDER BY t.name_sortkey ASC'));
	}


	public function getEmailAddresses() {
		$to = array();
		$cc = array();

		if (isset($this->email)) {
			$to[$this->formatName()] = $this->email;
		}

		$boUser = new BackofficeUser(true);
		$boUsers = $boUser->getList(
			$join = 'JOIN pol_politician_users p ON p.bo_user = t.id',
			$where = 'WHERE p.politician = '.$this->id
		);

		if (count($boUsers) > 0)
			foreach ($boUsers as $user)
				if (count($to) > 0)
					$cc[$user->formatName()] = $user->email;
				else {
					$to[$user->formatName()] = $user->email;
				}

		return array($to, $cc);
	}
}

?>