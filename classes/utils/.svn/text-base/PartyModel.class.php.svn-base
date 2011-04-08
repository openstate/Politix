<?php

require_once('RegionModel.class.php');

/**
* Handles parties.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PartyModel {

	/** DB table name containing all parties. */
	const TABLE_NAME = 'pol_parties';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'pol_parties_id_seq';

	/** region registrations*/
	const REGION_REGISTRATION_TABLE = "pol_party_regions";
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const REGION_REGISTRATION_SEQUENCE = "pol_party_regions_id_seq";

	/** party parents. */
	const REFERENCE_TABLE = 'pol_party_parents';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const REFERENCE_SEQUENCE = 'pol_party_parents_id_seq';


	//used when dates are null
	const POS_INFINITY = 'infinity';
	const NEG_INFINITY = '-infinity';


	protected $id;
	protected $name;
	protected $key;
	protected $region;
	protected $abbreviation;

	protected $schema;
	protected $db;

	/** @var array (pol_party_parents.id => PartyModel) */
	protected $combi;
	/** @var array (PartyModel.id => PartyModel) */
	protected $revcombi;

	/** @var array (RegionModel.id => (pol_party_regions.id => [start, end])) */
	protected $inregions;


	/**
	 * Construct new unresolved party.
	 *
	 * @param string $name party name
	 * @param RegionModel $region region path
	 * @param string $abbreviation short name
	 */
	public function __construct($name, RegionModel $region, $abbreviation = null) {
		$this->id = null;
		$this->name = $name;
		$this->key = self::stem($name);

		$this->region = $region;
		$this->abbreviation = $abbreviation;
		$this->schema = null;

		$this->combi = array();
		$this->revcombi = array();
		$this->inregions = array();
	}

	/**
	 * Resolve this object.
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param PartyModelSchema $schema the parent schema
	 * @param PDO $db database link
	 *
	 */
	public function resolve(PartyModelSchema $schema, $db, $id, $regions) {
		$this->schema = $schema;
		$this->db = $db;

		if($id === null) {
			$log = JLogger::getLogger("utils.import.schema.party");
			$log->preUpdate("Inserting new party: {$this->name}");

			//all parties are already loaded, so this should be new one
			$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.' (name, combination, owner, short_form) VALUES(:name, :combination, :owner, :short_form)');
			$ins->execute(array(
				':name' => $this->name,
				':combination' => $this->isCombination()? 1: 0,
				':owner' => $this->getRegion()->getId(),
				':short_form' => $this->abbreviation
			));

			if($ins->rowCount() != 1) throw new RuntimeException("Can't insert new party '{$this->getName()}', database error!");
			$id = $this->db->lastInsertId(self::ID_SEQUENCE);
            $this->id = $id;

            $log->postUpdate("Successfully inserted new party: {$this->name}, id: {$id}");
		} else $this->id = $id;

		$this->inregions = $regions;
	}


	/**
	 * Add party as partent (this is a combination)
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param integer $id reference id
	 * @param PartyModel $parent parent party
	 * @return void
	 */
	public function resolveParent($id, $parent) {
		$this->combi[$id] = $parent;
		$this->revcombi[$parent->getId()] = $parent;
	}


	/**
	 * Returns record ID of this party.
	 * @return integer
	 */
	public function getId() {
		if($this->id === null) throw new RuntimeException("Party '{$this->name}' is not yet resolved!");
		return $this->id;
	}

	/**
	 * Returns <tt>PartyModelSchema</tt> that handles all the parties.
	 * @return PartyModelSchema
	 */
	public function getSchema() {
		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");
		return $this->schema;
	}

	/**
	 * Returns party name.
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns stemmed party name.
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Returns abbreviation (short name).
	 * @return string null if not set
	 */
	public function getAbbreviation() {
		return $this->abbreviation;
	}

	/**
	 * Returns region where that party was "created" or the biggest area
	 * where this party is present.
	 *
	 * Note: this has nothing to do with party registrations in the regions,
	 * it is just a field in the database that is probably not used anymore...
	 *
	 * @return RegionModel the party region
	 */
	public function getRegion() {
		if(!($this->region instanceof RegionModel)) {
			if($this->schema == null) throw new RuntimeException("Can't obtain region for party '{$this->name}', party is not resolved!");
			$this->region = $this->schema->getGlobalSchema()->getRegionSchema()->getRegion($this->region);
		}
		return $this->region;
	}

	/**
	 * Returns true if this party is a combination of other parties.
	 * @return boolean
	 */
	public function isCombination() {
		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");
		return sizeof($this->combi) > 0;

	}

	/**
	 * Returns list of parties that form together this party.
	 * @return array of PartyModel objects
	 */
	public function listCombinationParties() {
		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");
		return $this->combi;
	}

	/**
	 * Returns true if given $party is whin the list of parent parties of this party.
     * @param string|PartyModel $party the party to check
     * @return boolean
	 */
	public function isCombinationOf($party) {
		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");
		$id =($party instanceof PartyModel)? $party->getId(): $this->schema->getParty($party)->getId();
		return isset($this->revcombi[$id]);
	}


	/**
	 * Ensure party is registered in the $region at the [$date_start - $date_end] time range.
	 *
	 * If there is a registration record for a party that includes the time range [$date_start - $date_end],
	 * then method does nothing. If [$date_start - $date_end] is partially within an already
	 * registered time range, then that time range will be extended to include this time range.
	 * If [$date_start - $date_end] not within any already registered time ranges, then a new
	 * time range will be created.
	 *
	 * The time range [$date_start - $date_end] is inclusive both dates, so the range ($date_start == $date_end)
	 * represents a single day. If date is null, then 'infinity' is assumed.
	 *
	 * Warning: giving $date_start = null, $date_end = null you will register the party
	 * in the region for unlimited time.  Old registrations will not be deleted for archiving reasons.
	 *
	 * @throws RuntimeException on any error
	 * @param RegionModel $region region path where in the party should be registered
	 * @param string $date_start first day as 'YYYY-mm-dd' string, null for 'infinity'
	 * @param string $date_end last day as 'YYYY-mm-dd' string, null for 'infinity'
	 * @return void
	 */
	public function ensureRegisteredInRegion(RegionModel $region, $date_start, $date_end = null) {
		$log = JLogger::getLogger("utils.import.schema.party");
		if($log->isEnabled(JLogger::ENTER)) $log->enter("Ensuring region registration for party '{$this->name}' in region: {$region->getPath()} for time range: [{$date_start} - {$date_end}]");

		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");
		if($date_start != '' && !preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date_start)) throw new InvalidArgumentException("Incorrect start date: '{$date_start}'. Expecting: yyyy-mm-dd");
		if($date_end != '' && !preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date_end)) throw new InvalidArgumentException("Incorrect end date: '{$date_start}'. Expecting: yyyy-mm-dd");

		//$reg = $this->schema->getGlobalSchema()->getRegionSchema()->getRegion($region);
		$reg = $region;
		if(isset($this->inregions[$reg->getId()])) { //ensure correct time
			$ranges = $this->inregions[$reg->getId()];
			$best_left = null;
			$best_right = null;

			foreach ($ranges as $k => $r) {
				$left = $r['start'] == ''? -1: ($date_start == ''? 1: strcmp($r['start'], $date_start)); //fail: positive
				$right = $r['end'] == ''? 1: ($date_end == ''? -1: strcmp($r['end'], $date_end)); //fail: negative

				if($left <= 0 && $right >= 0) return; //good, within the range
				elseif($left <=0 && $right < 0) { //extend right
					if($best_right === null || (strcmp($ranges[$best_right]['end'], $r['end']) < 0)) { //new range spans further to right
						$best_right = $k;
					}
				}  elseif($left > 0 && $right >= 0) { //extend left
					if($best_left === null || (strcmp($ranges[$best_left]['start'], $r['start']) > 0)) { //new range spans further to left
						$best_left = $k;
					}
				}
			}

			if($best_right !== null) { //prefer right
				if(defined('DRY_RUN')) die("Before expanding party region registration: ".$best_right.", for party: ".$this->name." to right (future).");

				$log->preUpdate("Expanding party region registration: {$best_right} for party '{$this->getName()}' to right (future).");
				$stm = $this->db->prepare('UPDATE '.self::REGION_REGISTRATION_TABLE.' SET time_end = :end WHERE id = :id;');
				$stm->execute(array(':end' => $date_end == ''? self::POS_INFINITY: $date_end, ':id' => $best_right));

				if($stm->rowCount() != 1) throw new RuntimeException("Can't update party.region registration (".self::REGION_REGISTRATION_TABLE ."), record: {$best_right}!");

				$log->postUpdate("Successfully expanded party region registration {$best_right} for party '{$this->name}' to right (future).");
				$this->inregions[$reg->getId()][$best_right]['end'] = $date_end == ''? null: $date_end;

				if($log->isEnabled(JLogger::LEAVE)) $log->leave("Leaving region registration for party '{$this->name}' in region: {$region->getPath()} for time range: [{$date_start} - {$date_end}]");
				return;

			} elseif($best_left !== null) {//extend left
				if(defined('DRY_RUN')) die("Before expanding party region registration: ".$best_left.", for party: ".$this->name." to left (past).");

				$log->preUpdate("Expanding party region registration: {$best_left} for party '{$this->getName()}' to left (past).");
				$stm = $this->db->prepare('UPDATE '.self::REGION_REGISTRATION_TABLE.' SET time_start = :start WHERE id = :id;');
				$stm->execute(array(':start' => $date_start == ''? self::NEG_INFINITY: $date_start, ':id' => $best_left));

				if($stm->rowCount() != 1) throw new RuntimeException("Can't update party.region registration (".self::REGION_REGISTRATION_TABLE ."), record: {$best_left}!");

				$log->postUpdate("Successfully expanded party region registration {$best_left} for party '{$this->name}' to left (past).");
				$this->inregions[$reg->getId()][$best_left]['start'] = $date_start == ''? null: $date_start;

				if($log->isEnabled(JLogger::LEAVE)) $log->leave("Leaving region registration for party '{$this->name}' in region: {$region->getPath()} for time range: [{$date_start} - {$date_end}]");
				return;
			} //else OK, we have to insert new one

		} else $this->inregions[$reg->getId()] = array();

		if(defined('DRY_RUN')) die("Before inserting inregion registration for party: ".$this->name);

		//so, we haven't found any overlapping registration, create new one
		if($log->isEnabled(JLogger::PRE_UPDATE)) $log->preUpdate("Inserting new party region registration for party: '$this->name', region: '{$region->getPath()}' for range: [{$date_start} - {$date_end}]");

		$stm = $this->db->prepare('INSERT INTO '.self::REGION_REGISTRATION_TABLE.'(party, region, time_start, time_end) VALUES(:party, :region, :time_start, :time_end);');
		$stm->execute(array(
			':party' => $this->id,
			':region' => $reg->getId(),
			':time_start' => $date_start == ''? self::NEG_INFINITY: $date_start,
			':time_end' => $date_end == ''? self::POS_INFINITY: $date_end
		));
		if($stm->rowCount() != 1) throw new RuntimeException("Can't insert new party.region registration (".self::REGION_REGISTRATION_TABLE .")!");

		$id = $this->db->lastInsertId(self::REGION_REGISTRATION_SEQUENCE);
		$this->inregions[$reg->getId()][$id] = array('start' => $date_start, 'end' => $date_end);

		if($log->isEnabled(JLogger::POST_UPDATE)) $log->postUpdate("Successfully inserted new party region registration '{$id}' for party '{$this->name}' in region '{$region->getName()}' for range: [{$date_start} - {$date_end}]");

		if($log->isEnabled(JLogger::LEAVE)) $log->leave("Leaving region registration for party '{$this->name}' in region: {$region->getPath()} for time range: [{$date_start} - {$date_end}]");
	}


	/**
	 * Register this party as a combination of other parties and add such party reference.
	 *
	 * @param string|PartyModel $name the party to add
	 * @return void
	 */
	public function addPartyReference($name) {
		if($this->schema == null) throw new RuntimeException("Party '{$this->name}' is not yet resolved");

		$party = $this->schema->getParty(is_string($name)? $name: $name->getName());
		if(isset($this->revcombi[$party->getId()])) return; //already defined

		$log = JLogger::getLogger("utils.import.schema.party");
		$log->debug("Adding party reference '{$party->getName()}' -> '{$this->name}'");
		$log->preSelect("Fetching party parent reference '{$party->getName()}' -> {$this->name}'");

		$stm = $this->db->prepare('SELECT id FROM '.self::REFERENCE_TABLE.' WHERE party = :party AND parent = :parent');
		$stm->execute(array(':party' => $this->id, ':parent' => $party->getId()));

		$row = $stm->fetch(PDO::FETCH_ASSOC);
		if($row) $id = $row['id'];
		else { //insert new reference
			if(defined('DRY_RUN')) die("Before inserting party-parent reference: ".$this->name.", parent: ".$party->getName());

			$log->preUpdate("Inserting new party parent reference '{$party->getName()}' -> {$this->name}'");
			$ins = $this->db->prepare('INSERT INTO '.self::REFERENCE_TABLE.'(party, parent) VALUES(:party, :parent);');
			$ins->execute(array(':party' => $this->id, ':parent' => $party->getId()));

			if($ins->rowCount() != 1) throw new RuntimeException("Can't register party parent reference '{$this->name}' to '{$party->getName()}'.");
			$id = $this->db->lastInsertId(self::REFERENCE_SEQUENCE);

			$log->postUpdate("Successfully inserted new party parent reference {$id} -- '{$party->getName()}' -> {$this->name}'");

			$log->preUpdate("Updating party combination flag for party '{$this->name}'");
			$up = $this->db->prepare('UPDATE '.self::TABLE_NAME.' SET combination = 1 WHERE id = :id ;');
			$up->execute(array(':id' => $this->getId()));
			if($ins->rowCount() != 1) throw new RuntimeException("Can't change combination flag of party '{$this->name}'.");
			$log->postUpdate("Party combination flag for party '{$this->name}' is successfully set.");
		}

		$this->combi[$id] = $party;
		$this->revcombi[$party->getId()] = $party;
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
		return preg_replace('#[^a-z0-9_]+#', '_', strtolower(trim($key)));
	}


	/**
	 * Serialize this party to the DOM tree.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'party' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options) {
		$el = $dom->createElement('party');
		$el->setAttribute('name', $this->name);
		$el->setAttribute('region', $this->getRegion()->getPath());
		if($this->abbreviation) $el->setAttribute('abbreviation', $this->abbreviation);
		$root->appendChild($el);


		if($this->isCombination()) {
			$combi = $dom->createElement('combination');

			foreach ($this->combi as $cm) {
				$c = $dom->createElement('partyref');
				$c->setAttribute('party', $cm->getName());
				$combi->appendChild($c);
			}

			$el->appendChild($combi);
		}

		$regs = $this->schema->getGlobalSchema()->getRegionSchema();
		foreach ($this->inregions as $regid => $reg) {
			$rr = $regs->lookup($regid);

			foreach ($reg as $tm) {
				$r = $dom->createElement('inregion');
				$r->setAttribute('region', $rr->getPath());
				if($tm['start'] != '') $r->setAttribute('date_start', $tm['start']);
				if($tm['end'] != '') $r->setAttribute('date_end', $tm['end']);
				$el->appendChild($r);
			}
		}
	}
}


?>
