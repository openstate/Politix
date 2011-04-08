<?php

require_once('RegionModel.class.php');

/**
* Handles politicians.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PoliticianModel {

	/** DB table name containing all politicians. */
	const TABLE_NAME = 'pol_politicians';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'pol_politicians_id_seq';

	/** (politician, party, time-range) registration */
	const FUNCTION_TABLE = 'pol_politician_functions';
	const FUNCTION_SEQUENCE = 'pol_politician_functions_id_seq';



	//used when dates are null
	const POS_INFINITY = 'infinity';
	const NEG_INFINITY = '-infinity';


	protected $id = null;
	protected $def_party = null;

	protected $extid;
	protected $title;
	protected $initials;
	protected $last_name;
	protected $gender;
	protected $email;

	protected $region;
	protected $key;

	/** @var array ("{party}-{region}-{category}" => [start, end, description, category, region, party]) */
	protected $functions = array();

	protected $schema = null;
	protected $db = null;

	/**
	 * Create new unitialized public politician.
	 *
	 * @param string $initials initials or first name
	 * @param string $last_name last name
	 * @param string $gender 'male' or 'female' gender, since back-end uses boolean here, we require this
	 * @param string $title optional title
	 * @param string $email optional e-mail adres
	 * @param RegionModel $region resolved region object or null if not set
	 * @param string $extid external id optional external (import file wide) id
	 * @param integer $def_party linked party, for internal use only
	 */
	public function __construct($initials, $last_name, $gender, $title = null, $email = null, $region = null, $extid = null, $def_party = null) {
		$this->initials = $initials;
		$this->last_name = $last_name;

		$gender = strtolower(trim($gender));
		if(!in_array($gender, array('male', 'female'))) throw new InvalidArgumentException("Unknown gender: {$gender}, expecting 'male' or 'female'");
		$this->gender = $gender;

		$this->title = $title;
		$this->email = $email;
		$this->extid = $extid;

		if($region !== null && !($region instanceof RegionModel)) throw new InvalidArgumentException("Expecting resolved region! Got: {$region}");
		$this->region = $region;

		if($region) {
			$path = $region->getPath();
			$path = preg_replace('#[^a-z0-9_]#', '_', str_replace('/', '_', strtolower($path)));
		} $path = '';

		$this->key = "({$path})_".self::stem($initials).'_'.self::stem($last_name).'_'.$gender.'_'.trim($email);
		$this->def_party = $def_party;
	}

	/**
	 * Resolve this object.
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param PoliticianModelSchema $schema the parent schema
	 * @param PDO $db database link
	 *
	 */
	public function resolve(PoliticianModelSchema $schema, $db, $id, $functions = array()) {
		$this->schema = $schema;
		$this->db = $db;

		if($id === null) {
			if(defined('DRY_RUN')) die("Before inserting new politician: ".$this->last_name);

			$log = JLogger::getLogger('utils.import.schema.politician');
			$log->preUpdate("Inserting new politician: {$this->last_name}");
			$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.'(title, first_name, last_name, gender_is_male, photo, email, name_sortkey, region_created, def_party) VALUES (:title, :first_name, :last_name, :gender_is_male, :photo, :email, :name_sortkey, :region_created, :def_party);');
			$ins->execute(array(
				':title' => $this->title,
				':first_name' => $this->initials,
				':last_name' => $this->last_name,
				':gender_is_male' => $this->gender == 'male'? 1: 0,
				':photo' => null,
				':email' => $this->email,
				':name_sortkey' => null, //changed by stored procedure
				':region_created' => $this->region? $this->region->getId(): null,
				':def_party' => trim($this->def_party) == ''? null: intval($this->def_party)
			));

            if($ins->rowCount() != 1) {
                ob_start();
                print_r($ins->errorInfo());
                $msg = ob_get_clean();
                $log->error($msg);
                throw new RuntimeException("Can't insert new politician '{$this->last_name}', database failure, rows: !" . $ins->rowCount());
            }

			$this->id = $this->db->lastInsertId(self::ID_SEQUENCE);

			$log->postUpdate("Successfully inserted new politician: {$this->last_name}, id: {$this->id}");
		} else $this->id = $id;

		$this->functions = $functions;
	}


	/**
	 * Returns true if this politician is an 'Unknown' or default for a party object.
	 * Default politician is needed to vote from the whole party perspective.
	 * @return boolean true - politician is of a default type
	 */
	public function isDefault() {
		return $this->def_party !== null;
	}


	/**
	 * Returns record ID of this party.
	 * @return integer
	 */
	public function getId() {
		if($this->id === null) throw new RuntimeException("Politician '{$this->last_name}' is not yet resolved!");
		return $this->id;
	}

	/**
	 * Returns <tt>PoliticianModelSchema</tt> that handles all the politicians.
	 * @return PoliticianModelSchema
	 */
	public function getSchema() {
		if($this->schema == null) throw new RuntimeException("Politician '{$this->last_name}' is not yet resolved");
		return $this->schema;
	}

	/** Returns some of read-only properties */
	public function __get($name) {
		switch ($name) {
			case 'title': return $this->title;
			case 'externalId': return $this->extid;
			case 'initials': return $this->initials;
			case 'last_name': return $this->last_name;
			case 'gender': return $this->gender;
			case 'email': return $this->email;
			case 'region': return $this->region;

			default:
				throw new InvalidArgumentException("Unknown property: {$name}");
		}
	}


	/**
	 * Returns stemmed concatenation of (region, initials, last_name, gender, email)
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}


	/**
	 * Returns region where that politician was "created" or the biggest area
	 * where this politician is present.
	 *
	 * Region together with email is used to distinguish politicians with equal names.
	 *
	 * @return RegionModel the politician region
	 */
	public function getRegion() {
		return $this->region;
	}


	/**
	 * Returns true if this politician has a function related to given $party with time range containing $date.
	 * If $category is set, then method checks that function is of specified category or there is funtion
	 * with category 'Geen'.
	 *
	 * @param PartyModel $party associated party
	 * @param RegionModel $region associated region
	 * @param string $date 'yyyy-mm-dd' date
	 * @param string|CategoryModel $category restrict to category
	 * @return boolean true if politician has valid function for given $party, otherwise false
	 */
	public function canVoteFor(PartyModel $party, RegionModel $region, $date, $category = null) {
		if($this->schema == null) throw new RuntimeException("Politician '{$this->last_name}' is not yet resolved");
		if($date == '') throw new InvalidArgumentException("Date is required for vote check!");

		if($category !== null && !($category instanceof CategoryModel)) $category = $this->schema->getCategorySchema()->getCategory($category);
		$category = $category !== null? $category->getId(): null;

		foreach ($this->functions as $funcs) {
			foreach ($funcs as $func) {
				if($party->getId() != $func['party']->getId()) continue;
				if($func['region']->getId() != $region->getId()) continue;

				if($category !== null && $category != $func['category']->getId() && $func['category']->getId() >= 0) continue;

				$left = $func['start'] == ''? -1: strcmp($func['start'], $date); //fail: positive
				$right = $func['end'] == ''? 1: strcmp($func['end'], $date); //fail: negative
				if($left <= 0 && $right >= 0) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Ensure politician is registered in the $region for specific $party at the [$date_start - $date_end] time range.
	 *
	 * Each politician has one or more functions associated with different categories by different parties in different
	 * time ranges. The politician may vote if and only if he/shi has valid function in associated region.
	 *
	 * If there is a registration record that includes the time range [$date_start - $date_end],
	 * then method does nothing. If [$date_start - $date_end] is partially within an already
	 * registered time range, then that time range will be extended to include this time range.
	 * If [$date_start - $date_end] not within any already registered time ranges, then a new
	 * time range will be created.
	 *
	 * The time range [$date_start - $date_end] is inclusive both dates, so the range ($date_start == $date_end)
	 * represents a single day. If date is null, then 'infinity' is assumed.
	 *
	 * Warning: giving $date_start = null, $date_end = null you will register the politician
	 * in the region for unlimited time. Old registrations will not be deleted for archiving reasons.
	 *
	 * @throws RuntimeException on any error
	 * @param RegionModel $region associated region
	 * @param PartyModel $party associated party
	 * @param string $date_start first day as 'YYYY-mm-dd' string, null for 'infinity'
	 * @param string $date_end last day as 'YYYY-mm-dd' string, null for 'infinity'
	 * @param CategoryModel $category optional associated category, if not set, then default "Geen" is used
	 * @param string $description optional function description
	 * @return void
	 */
	public function registerFunction(RegionModel $region, PartyModel $party, $date_start = null, $date_end = null, $category = null, $description = null) {
		if($this->schema == null) throw new RuntimeException("Politician '{$this->last_name}' is not yet resolved");

		$log = JLogger::getLogger("utils.import.schema.politician");
		if($log->isEnabled(JLogger::ENTER)) $log->enter("Ensuring politician '{$this->last_name}' has valid function in region: {$region->getPath()} by party '{$party->getName()}' for time range: [{$date_start} - {$date_end}]");

		if($date_start != '' && !preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date_start)) throw new InvalidArgumentException("Incorrect start date: '{$date_start}'. Expecting: yyyy-mm-dd");
		if($date_end != '' && !preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date_end)) throw new InvalidArgumentException("Incorrect end date: '{$date_start}'. Expecting: yyyy-mm-dd");

		//ensure our party is registered too
		$party->ensureRegisteredInRegion($region, $date_end, $date_end);

		if($category == null) $category = CategoryModelSchema::NO_CATEGORY_OBJECT;
		else $category = $category->getId();

		$key = $party->getId().'-'.$region->getId().'-'.$category;
		if(isset($this->functions[$key])) { //registered, ensure correct time
			$ranges = $this->functions[$key];
			$best_left = null;
			$best_right = null;

			foreach ($ranges as $k => $func) {
				$left = $func['start'] == ''? -1: ($date_start == ''? 1: strcmp($func['start'], $date_start)); //fail: positive
				$right = $func['end'] == ''? 1: ($date_end == ''? -1: strcmp($func['end'], $date_end)); //fail: negative

				if($left <= 0 && $right >= 0) return; //correct function found
				elseif($left <=0 && $right < 0) { //extend right
					if($best_right === null || (strcmp($ranges[$best_right]['end'], $func['end']) < 0)) { //new range spans further to right
						$best_right = $k;
					}
				}  elseif($left > 0 && $right >= 0) { //extend left
					if($best_left === null || (strcmp($ranges[$best_left]['start'], $func['start']) > 0)) { //new range spans further to left
						$best_left = $k;
					}
				}
			}

			if($best_right !== null) { //extend right
				if(defined('DRY_RUN')) die("Before expanding politician region-party-category registration: ".$best_right.", for party: {$this->last_name}, id: {$this->id}");

				$log->preUpdate("Expanding politician function: {$best_right} for politician '{$this->last_name}', id: {$this->id} to right (future).");
				$stm = $this->db->prepare('UPDATE '.self::FUNCTION_TABLE.' SET time_end = :end WHERE id = :id;');
				$stm->execute(array(':end' => $date_end == ''? self::POS_INFINITY: $date_end, ':id' => $best_right));
				if($stm->rowCount() != 1) throw new RuntimeException("Can't update politician.region registration (".self::FUNCTION_TABLE ."), record: {$best_right}!");

				$this->functions[$key][$best_right]['end'] = $date_end == ''? null: $date_end;

				$log->preUpdate("Successfully updated politician function: {$best_right} for politician '{$this->last_name}', id: {$this->id} to right (future).");
				if($log->isEnabled(JLogger::LEAVE)) $log->enter("Leaving registration for politician '{$this->last_name}' in region: {$region->getPath()} by party '{$party->getName()}' for time range: [{$date_start} - {$date_end}]");
				return;
			} elseif($best_left !== null) { //extend left
				if(defined('DRY_RUN')) die("Before expanding politician region-party-category registration: ".$best_left.", for party: {$this->last_name}, id: {$this->id}");

				$log->preUpdate("Expanding politician function: {$best_right} for politician '{$this->last_name}', id: {$this->id} to left (past).");
				$stm = $this->db->prepare('UPDATE '.self::FUNCTION_TABLE.' SET time_end = :end WHERE id = :id;');
				$stm->execute(array(':end' => $date_start == ''? self::POS_INFINITY: $date_start, ':id' => $best_left));
				if($stm->rowCount() != 1) throw new RuntimeException("Can't update politician.region registration (".self::FUNCTION_TABLE ."), record: {$best_left}!");

				$this->functions[$key][$best_left]['start'] = $date_start == ''? null: $date_start;

				$log->preUpdate("Successfully updated politician function: {$best_left} for politician '{$this->last_name}', id: {$this->id} to left (past).");
				if($log->isEnabled(JLogger::LEAVE)) $log->enter("Leaving registration for politician '{$this->last_name}' in region: {$region->getPath()} by party '{$party->getName()}' for time range: [{$date_start} - {$date_end}]");
				return;
			} //else OK, we have to insert new one
		} else $this->functions[$key] = array();

		//so, we haven't found any overlapping registration, create new one
		if($log->isEnabled(JLogger::PRE_UPDATE)) $log->preUpdate("Inserting new function for politician: '$this->last_name', id: {$this->id}, region: '{$region->getPath()}', party '{$party->getName()}' for range: [{$date_start} - {$date_end}]");
		$stm = $this->db->prepare('INSERT INTO '.self::FUNCTION_TABLE.'(politician, party, region, category, time_start, time_end, description) VALUES(:politician, :party, :region, :category, :time_start, :time_end, :description);');
		$stm->execute(array(
			':politician' => $this->id,
			':party' => $party->getId(),
			':region' => $region->getId(),
            ':category' => $category,
            ':time_start' => $date_start == ''? self::NEG_INFINITY: $date_start,
            ':time_end' => $date_end == ''? self::POS_INFINITY: $date_end,
			':description' => $description
		));
		if($stm->rowCount() != 1) throw new RuntimeException("Can't insert new politician.region registration (".self::FUNCTION_TABLE .")!");

		$id = $this->db->lastInsertId(self::FUNCTION_SEQUENCE);
		$this->functions[$key][$id] = array(
			'category' => $this->schema->getGlobalSchema()->getCategorySchema()->lookup($category),
			'region' => $region,
			'party' => $party,

			'start' => $date_start,
			'end' => $date_end,
			'description' => $description
		);

		if($log->isEnabled(JLogger::PRE_UPDATE)) $log->preUpdate("Successfully inserted new function as {$id} for politician: '$this->last_name', id: {$this->id}, region: '{$region->getPath()}', party '{$party->getName()}' for range: [{$date_start} - {$date_end}]");

		if($log->isEnabled(JLogger::LEAVE)) $log->enter("Leaving registration for politician '{$this->last_name}' in region: {$region->getPath()} by party '{$party->getName()}' for time range: [{$date_start} - {$date_end}]");
	}



	/**
	 * Stem the given key.
	 *
	 * This method converts the given string to lowercase, trim and replaces
	 * any '[^a-z0-9_]+' sequence by '_'.
	 *
	 * @param string $key key to stem
	 * @return string stemmed string
	 */
	public static function stem($key) {
		return preg_replace('#[^a-z0-9_]+#', '', strtolower(trim($key)));
	}


	/**
	 * Serialize this politician to the DOM tree.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'party' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options) {
		$el = $dom->createElement('politician');

		$el->setAttribute('id', $options['politician.external_id']);
		$el->setAttribute('last_name', $this->last_name);
		$el->setAttribute('gender', $this->gender);
		$el->setAttribute('title', $this->title);
		$el->setAttribute('initials', $this->initials);
		$el->setAttribute('email', $this->email);
		if($this->getRegion() != null) $el->setAttribute('region', $this->getRegion()->getPath());

		$root->appendChild($el);

		foreach ($this->functions as $bla) {
			foreach ($bla as $func) {
				$r = $dom->createElement('function');
				if(!isset($func['category'])) var_dump(array_keys($func));

				$r->setAttribute('category', $func['category']->getName());
				$r->setAttribute('region', $func['region']->getPath());
				$r->setAttribute('party', $func['party']->getName());

				$r->setAttribute('description', $func['description']);
				if($func['start'] != '') $r->setAttribute('date_start', $func['start']);
				if($func['end'] != '') $r->setAttribute('date_end', $func['end']);

				$el->appendChild($r);
			}
		}
	}
}


?>
