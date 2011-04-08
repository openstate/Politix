<?php

require_once('NotFoundException.class.php');
require_once('RegionModel.class.php');

/**
* Handles raadsstukken.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class RaadsstukModel {
	/** DB table name containing all raadsstukken. */
	const TABLE_NAME = 'rs_raadsstukken';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'rs_raadsstukken_id_seq';
	/** DB table name containing all categories links */
	const CATEGORIES_TABLE = 'rs_raadsstukken_categories';
	/** DB table name containing all tag links */
	const TAGS_TABLE = 'rs_raadsstukken_tags';


	/** Mapping (external_id => internal_id) */
	protected static $raadsstukken = array();

	private $schema;
	private $db;

	private $site;
	private $title;
	private $vote_date;
	private $region;
	private $summary = null;

	private $code = null;
	private $show = false;
	private $extid = null;

	private $tags = array();
	private $categories = array();

	private $submitter = null;
	private $voter = null;

	/**
	 * Construct new raadsstuk (import)
	 *
	 * @param ModelSchema site schema
	 * @param PDO $db database link
	 * @param integer $site site id
	 * @param string $title raadsstuk title
	 * @param string $vote_date 'yyyy-mm-dd' or 'dd
	 * @param RegionModel $region region path
	 * @param string $code optional code
	 * @param boolean $show show on home page
	 * @param string $extid external id
	 */
	public function __construct(ModelSchema $schema, $db, $site, $title, $vote_date, RegionModel $region, $code = null, $show = false, $extid = null) {
		$this->schema = $schema;
		$this->db = $db;

		$mth = null;
		$vote_date = trim($vote_date);
		if(preg_match('#([0-9]{1,2})[\\-/. ]([0-9]{1,2})[\\-/. ]([0-9]{4})#', $vote_date, $mth)) {
			$vote_date = $mth[3].'-'.$mth[2].'-'.$mth[1];
		} elseif (!preg_match('#([0-9]{4})[\\-/. ]([0-9]{1,2})[\\-/. ]([0-9]{1,2})#', $vote_date)) {
			throw new InvalidArgumentException("Incorrect vote date, expecting 'yyyy-mm-dd' or 'dd-mm-yyyy', got: {$vote_date}");
		}
		$this->vote_date = $vote_date;

		$this->region = $region;
		$this->site = $site;
		$this->title = $title;
		$this->code = $code;
		$this->show = $show;
		$this->extid = $extid;
		$this->summary = '';
	}


	/** Handles read only properties of this class. */
	public function __get($name) {
		switch ($name) {
			case 'title': return $this->title;
			case 'voteDate': return $this->vote_date;
			case 'region': return $this->region;
			case 'code': return $this->code;
			case 'show': return $this->show;
			case 'externalId': return $this->extid;
			case 'summary': return $this->summary;
			case 'schema': return $this->schema;

			default:
				throw new RuntimeException('Unsupported field: '.$name);
		}
	}

	/** Set raadsstuk summary text. */
	public function setSummary($text) {
		$this->summary = $text;
	}

	/**
	 * Assign tag.
	 * @param TagModel $tag
	 */
	public function addTag(TagModel $tag) {
		$this->tags[$tag->getName()] = $tag->getId();
	}

	/** List all assigned tags. */
	public function listTags() {
		return array_keys($this->tags);
	}

	/**
	 * Assign category.
	 * @param CategoryModel $category
	 */
	public function addCategory(CategoryModel $category) {
		$this->categories[$category->getName()] = $category->getId();
	}

	/** List all assigned categories. */
	public function listCategories() {
		return array_keys($this->categories);
	}

	/**
	 * Define submitting procedure.
	 *
	 * @param string $type submitting type
	 * @param string $submitter submitter
	 * @return SubmitterProcedure
	 */
	public function defineSubmitter($type, $submitter = null) {
		$this->submitter = SubmitterProcedure::forType($this->schema, $this->db, $type, $submitter);
		return $this->submitter;
	}

	/**
	 * Returns defined submitter procedure.
	 * Submitter must be defined prior to calling this method.
	 *
	 * @throws RuntimeException if submitter block is not yet defined
	 * @return SubmitterProcedure
	 */
	public function getSubmitter() {
		if($this->submitter == null) throw new RuntimeException("Invalid state, submitter is not yet defined!");
		return $this->submitter;
	}


	/**
	 * Define vote block object.
	 * Vote block must be defined prior to calling this method.
	 *
	 * @param string $type either 'party' or 'politician'
	 * @param string $result one of 'new', 'declined', 'accepted'
	 * @return RaadsstukVoteBlock
	 */
	public function defineVoteBlock($type, $result = null) {
		$this->voter = RaadsstukVoteBlock::forType($this, $this->schema, $this->db, $type, $result);
		return $this->voter;
	}

	/**
	 * Returns defined vote block.
	 * @throws RuntimeException if vote block is not yet defined
	 * @return RaadsstukVoteBlock
	 */
	public function getVoteBlock() {
		if($this->voter == null) throw new RuntimeException("Invalid state, vote block is not yet defined!");
		return $this->voter;
	}

	/**
	 * Insert data to the database.
	 *
	 * @throws RuntimeException on any error
	 * @return void
	 */
	public function resolve() {
		$log = JLogger::getLogger('utils.import.raadsstuk');

		if(defined('DRY_RUN')) die("Before inserting new raadsstuk: ".$this->title);

		$log->preUpdate("Inseting new raadsstuk: {$this->title}");
		static $ins = null;
		if($ins == null) $ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.'(region, title, vote_date, summary, code, type, result, submitter, parent, show, site_id) VALUES(:region, :title, :vote_date, :summary, :code, :type, :result, :submitter, :parent, :show, :site_id);');

		$ins->execute(array(
			':region' => $this->region->getId(),
			':title' => $this->title,
			':vote_date' => $this->vote_date,
			':summary' => $this->summary,
			':code' => $this->code,
			':type' => $this->getSubmitter()->getTypeRef(),
			':submitter' => $this->getSubmitter()->getSubmitterRef(),
			':parent' => $this->submitter->getParentRaadstukId(),
			':result' => $this->getVoteBlock()->getResult(),
			':show' => $this->show? 1: 0,
			':site_id' => $this->site->getId()
		));

		if($ins->rowCount() != 1) throw new RuntimeException("Can't insert new raadsstuk '{$this->title}', database failed!");
		$id = $this->db->lastInsertId(self::ID_SEQUENCE);
		if($this->extid) self::$raadsstukken[$this->extid] = $id;
		$log->postUpdate("Successfully insterted new raadsstuk: {$this->title}, id {$id}");

		$log->preUpdate("Registering raadsstuk id: {$id} with ".sizeof($this->categories)." categories.");
		static $cats = null;
		if($cats == null) $cats = $this->db->prepare('INSERT INTO '.self::CATEGORIES_TABLE.'(raadsstuk, category) VALUES(:raadsstuk, :category)');

		foreach ($this->categories as $catid) {
			$cats->execute(array(':raadsstuk' => $id, ':category' => $catid));
		}
		$log->postUpdate("Successfully linked categories with raadsstuk id: {$id}");

		$log->preUpdate("Registering ".sizeof($this->tags)." tags for raadsstuk id: {$id}");
		static $tags = null;
		if($tags == null) $tags = $this->db->prepare('INSERT INTO '.self::TAGS_TABLE.'(raadsstuk, tag) VALUES(:raadsstuk, :tag)');

		foreach ($this->tags as $tagid) {
			$tags->execute(array(':raadsstuk' => $id, ':tag' => $tagid));
		}
		$log->postUpdate("Successfully registered all tags for raadsstuk id: {$id}");

		$this->getSubmitter()->install($id);
		$this->getVoteBlock()->install($id);
	}


	/**
	 * Lookup for parent raadsstuk id.
	 *
	 * @throws NotFoundException if raadsstuk with such id is not yet defined
	 * @param string $extid external id
	 * @return integer internal id
	 */
	public static function mapExternalToInternalId($extid) {
		if(!isset(self::$raadsstukken[$extid])) throw new NotFoundException("Raadsstuk with external id '{$extid}' is not found!");
		return self::$raadsstukken[$extid];
	}
}


/**
* Vote procedure.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
abstract class RaadsstukVoteBlock {
	const TABLE_NAME = 'rs_votes';
	private static $ins = null;

	const YES = 0;
	const NO = 1;
	const REMEMBER = 2;
	const ABSENT = 3;

	const RESULT_NEW = 0;
	const RESULT_ACCEPTED = 1;
	const RESULT_DECLINED = 2;

	protected $type;
	protected $schema;
	protected $db;
	protected $raadsstuk;
	protected $votes = array();
	protected $result = self::RESULT_NEW;


	/** Construct new vote block */
	public function __construct($raadsstuk, $schema, $db, $type, $result = null) {
		$this->raadsstuk = $raadsstuk;
		$this->schema = $schema;
		$this->db = $db;
		$this->type = $type;

		if(self::$ins == null) {
			self::$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.'(politician, raadsstuk, vote) VALUES(:politician, :raadsstuk, :vote);');
			if(!self::$ins) throw new RuntimeException("Failed to create prepared statement for insert!");
		}

		if($result !== null) {
			static $types = array(
				'new' => self::RESULT_NEW,
				'declined' => self::RESULT_DECLINED,
				'accepted' => self::RESULT_ACCEPTED
			);

			if(is_string($result)) {
				$result = strtolower(trim($result));
				if(!isset($types[$result])) throw new InvalidArgumentException("Unknown result type: '{$result}', expecting one of constants!");
				else $result = $types[$result];
			} elseif(!in_array(intval($result), array(self::RESULT_NEW, self::RESULT_ACCEPTED, self::RESULT_DECLINED))) {
				throw new InvalidArgumentException("Unknown result type: {$result}, expecting one of constants.");
			}

			$this->result = $result;
		}
	}

	/** Returns new vote block for type. */
	public static function forType($raadsstuk, $schema, $db, $type, $result = null) {
		$type = trim(strtolower($type));
		switch ($type) {
			case 'party': return new PartyRaadsstukVoteBlock($raadsstuk, $schema, $db, $type, $result);
			case 'politician': return new PoliticianRaadsstukVoteBlock($raadsstuk, $schema, $db, $type, $result);

			default: throw new InvalidArgumentException("Unknown vote block type: {$type}");
		}
	}

	/** Returns type of this vote block */
	public function getType() {
		return $this->type;
	}

	/**
	 * Returns voting result.
	 * @return integer one of result constants
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Vote by politician.
	 * @throws RuntimeException if voting by politician is not allowed by this block
	 * @param integer $vote one of vote constants
	 * @param string $politician_id external id to politician
	 * @return void
	 */
	public function votePolitician($vote, $politician_id) {
		throw new RuntimeException("Voting by politician is not allowed by this vote block type: {$this->type}! Vote: {$vote}, politician: {$politician_id}");
	}

	/**
	 * Vote by party.
	 * @throws RuntimeException if voting by party is not allowed by this block
	 * @param integer $vote one of vote is constants
	 * @param string $party_name party name
	 * @return void
	 */
	public function voteParty($vote, $party_name) {
		throw new RuntimeException("Voting by party is not allowed by this vote block type: {$this->type}! Vote: {$vote}, party: {$party_name}");
	}

	/**
	 * Assign votes to the given raadsstuk.
	 * @throws RuntimeException on any error
	 * @param integer $raaadstukid raadsstuk id
	 * @return void
	 */
	public function install($raaadstukid) {
		$log = JLogger::getLogger("utils.import.raadsstuk");
		$log->preUpdate("Making ".sizeof($this->votes)." votes for raadsstuk: {$raaadstukid}");

		if(defined('DRY_RUN')) die("Before voting for the raadsstuk: ".$raaadstukid);
		foreach ($this->votes as $polid => $vote) {
			self::$ins->execute(array(
				':politician' => $polid,
				':raadsstuk' => $raaadstukid,
				':vote' => $vote
			));

			if(self::$ins->rowCount() != 1) throw new RuntimeException("Can't set vote for raadsstuk id: '{$raaadstukid}' -- [vote: {$vote}, politician id: {$polid}]");
		}

		$log->postUpdate("Successfully inserted all votes.");
	}


	/** Recognize vote */
	public static function mapVote($vote) {
		static $votes = array(
			'yes' => self::YES,
			'no' =>  self::NO,
			'remember' => self::REMEMBER,
			'absent' =>  self::ABSENT
		);

		if(is_string($vote)) {
			if(isset($votes[$vote])) return $votes[$vote];
			else throw new RuntimeException("Unknown vote '{$vote}', excepting on of the constants!");
		}

		if(!in_array($vote, array(self::YES, self::NO, self::REMEMBER, self::ABSENT)))
			throw new InvalidArgumentException("Unknown vote: '{$vote}', must be one of the constants.");

		return $vote;
	}
}


/**
* Vote procedure with resolution up to party.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PartyRaadsstukVoteBlock extends RaadsstukVoteBlock {

	/**
	 * Vote by party.
	 * @param integer $vote one of vote is constants
	 * @param string $party_name party name
	 * @return void
	 */
	public function voteParty($vote, $party_name) {
		$vote = self::mapVote($vote);

		$par = $this->schema->getPartySchema();
		$pol = $this->schema->getPoliticianSchema();

		$id = $pol->getDefaultPoliticianForParty($par->getParty($party_name), $this->raadsstuk->voteDate, $this->raadsstuk->region)->getId();

		$this->votes[$id] = $vote;
	}
}


/**
* Vote procedure with resolution up to politician
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PoliticianRaadsstukVoteBlock extends RaadsstukVoteBlock {

	/**
	 * Vote by politician.
	 * @throws RuntimeException if voting by politician is not allowed by this block
	 * @param integer $vote one of vote constants
	 * @param string $politician_id external id to politician
	 * @return void
	 */
	public function votePolitician($vote, $politician_id) {
		$vote = self::mapVote($vote);

		$par = $this->schema->getPoliticianSchema();
		$id = $par->getPolitician($politician_id)->getId();
		$this->votes[$id] = $vote;
	}
}




/**
* Submitting procedure.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
abstract class SubmitterProcedure {

	const SUBMITTERS_TABLE = 'rs_raadsstukken_submitters';


	protected $schema;
	protected $db;

	protected $submitter;
	protected $type;
	protected $parent = null;
	protected $politicians = array();

	private static $types = null;
	private static $submitters = null;



	/**
	 * Construct new submitter.
	 * This constructor will lookup for $type en $submitter.
	 *
	 * @param ModelSchema $schema
	 * @param PDO $db
	 * @param string $type valid/real type name
	 * @param string $submitter valid/real submitter type
	 */
	public function __construct($schema, $db, $type, $submitter) {
		$this->schema = $schema;
		$this->db = $db;

		if(self::$types == null) {
			self::$types = array();

			$sel = $this->db->query('SELECT * FROM rs_raadsstukken_type;');
			foreach ($sel as $row) {
				self::$types[$row['name']] = $row['id'];
			}
			unset($sel);

			$sel = $this->db->query('SELECT * FROM rs_raadsstukken_submit_type;');
			foreach ($sel as $row) {
				self::$submitters[$row['name']] = $row['id'];
			}
			unset($sel);
		}

		if(!isset(self::$types[$type])) throw new InvalidArgumentException("Unknown submitter type: '{$type}'");
		$this->type = self::$types[$type];

		if(!isset(self::$submitters[$submitter])) throw new InvalidArgumentException("Unknown submitter: '{$submitter}'");
		$this->submitter = self::$submitters[$submitter];
	}

	/**
	 * Return procedure for type.
	 *
	 * @param ModelSchema $schema
	 * @param PDO $db
	 * @param string $type
	 * @param string $submitter
	 * @return SubmitterProcedure
	 */
	public static function forType($schema, $db, $type, $submitter = null) {
		switch (strtolower(trim($type))) {
			case 'raadsvoorstel': return new RaadsvoorstelSubmitterProcedure($schema, $db, $type, $submitter);
			case 'burgerinitiatief': return new BurgerinitiatiefSubmitterProcedure($schema, $db, $type, $submitter);
			case 'initiatiefvoorstel': return new InitiatiefvoorstelSubmitterProcedure($schema, $db, $type, $submitter);
			case 'motie':
			case 'amendement': return new AmendementSubmitterProcedure($schema, $db, $type, $submitter);
			case 'onbekend': return new OnbekendSubmitterProcedure($schema, $db, $type, $submitter);

			default:
				throw new InvalidArgumentException("Unknown submitter type: {$type}");
		}
	}


	/**
	 * Returns reference (id) of the raadsstuk type object.
	 * @return integer
	 */
	public function getTypeRef() {
		return $this->type;
	}

	/**
	 * Returns reference (id) of the submitter object.
	 * @return integer
	 */
	public function getSubmitterRef() {
		return $this->submitter;
	}

	/**
	 * Returns parent raadsstuk id.
	 * @return integer null if there is not parent defined
	 */
	public function getParentRaadstukId() {
		return $this->parent;
	}

	/**
	 * Assign parent reference.
	 *
	 * @throws RuntimeException if violates logic constraint
	 * @param string $parent_id parent raadsstuk external id
	 * @return void
	 */
	public function setParentRaadsstuk($parent_id) {
		throw new RuntimeException("Parent is not used by this procedure! Parent: {$parent_id}");
	}

	/**
	 * Assign politician as submitter.
	 *
	 * @throws RuntimeException if violates logic constraint
	 * @param string $politician_id politician external id
	 * @return void
	 */
	public function addPolitician($politician_id) {
		throw new RuntimeException("Politician submitter is not used by this procedure! Politician: {$politician_id}");
	}


	/**
	 * Install submitters if needed
	 * @param integer $raadsstukid target raadsstuk
	 * @return void
	 */
	public function install($raadsstukid) {
		if($this->politicians) {
			$log = JLogger::getLogger("utils.import.raadsstuk");

			$log->preUpdate("Inserting submitter politicians for raadsstuk: {$raadsstukid}");

			static $ins = null;
			$ins = $this->db->prepare('INSERT INTO '.self::SUBMITTERS_TABLE.'(raadsstuk, politician) VALUES(:raadsstuk, :politician);');

			if(defined('DRY_RUN')) die("Before setting submitters for the raadsstuk: ".$raadsstukid);

			foreach (array_keys($this->politicians) as $pol) {
				$ins->execute(array(
					':raadsstuk' => $raadsstukid,
					':politician' => $pol
				));
			}

			$log->postUpdate("Successfully inserted all submitter politicians for raadsstuk: {$raadsstukid}");
		}
	}
}


/**
* Raadsvoorstel.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class RaadsvoorstelSubmitterProcedure extends SubmitterProcedure {

	const DEFAULT_SUBMITTER = 'College';

	/**
	 * Allows 'College' and 'Presidium' submitters.
	 *
	 * @param ModelSchema $schema
	 * @param PDO $db
	 * @param string $type
	 * @param string $submitter
	 */
	public function __construct($schema, $db, $type, $submitter = null) {
		if($submitter) {
			$submitter_ = strtolower(trim($submitter));
			if(in_array($submitter_, array('college', 'presidium', 'onbekend'))) $submitter = ucfirst($submitter_);
			else throw new InvalidArgumentException("Expecting submitter 'College', 'Presidium' or 'Onbekend', but got: {$submitter}");
		} else $submitter = self::DEFAULT_SUBMITTER;

		parent::__construct($schema, $db, 'Raadsvoorstel', $submitter);
	}
}


/**
* Burgerinitiatief
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class BurgerinitiatiefSubmitterProcedure extends SubmitterProcedure {

	public function __construct($schema, $db, $type, $submitter = null) {
		parent::__construct($schema, $db, 'Burgerinitiatief', 'Burger');
	}
}

/**
* Initiatiefvoorstel
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class InitiatiefvoorstelSubmitterProcedure extends SubmitterProcedure {

	public function __construct($schema, $db, $type = null, $submitter = null) {
		parent::__construct($schema, $db, 'Initiatiefvoorstel', 'Raadslid');
	}

	/**
	 * Assign politician as submitter.
	 *
	 * @param string $politician_id politician external id
	 * @return void
	 */
	public function addPolitician($politician_id) {
		$pol = $this->schema->getPoliticianSchema();
		$id = $pol->getPolitician($politician_id)->getId();

		$this->politicians[$id] = true;
	}
}


/**
* Amendement.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class AmendementSubmitterProcedure extends SubmitterProcedure {

	public function __construct($schema, $db, $type, $submitter = null) {
		parent::__construct($schema, $db, 'Raadsvoorstel', 'Raadslid');
	}

	/**
	 * Returns parent raadsstuk id.
	 * @return integer null if there is not parent defined
	 */
	public function getParentRaadstukId() {
		//[FIXME: not required anymore, but this violates our submitting procedures!]
		//if($this->parent == null) throw new RuntimeException("Parent raadsstuk is required for submitter of type 'Amendement' or 'Motie'!");
		return $this->parent;
	}

	/**
	 * Assign parent reference.
	 * @throws RuntimeException if parent voorstel is not found
	 * @param string $parent_id parent raadsstuk external id
	 * @return void
	 */
	public function setParentRaadsstuk($parent_id) {
		$this->parent = RaadsstukModel::mapExternalToInternalId($parent_id);
	}

	/**
	 * Assign politician as submitter.
	 *
	 * @throws RuntimeException if politician is not found
	 * @param string $politician_id politician external id
	 * @return void
	 */
	public function addPolitician($politician_id) {
		$pol = $this->schema->getPoliticianSchema();
		$id = $pol->getPolitician($politician_id)->getId();

		$this->politicians[$id] = true;
	}
}

/**
* Onbekend.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class OnbekendSubmitterProcedure extends SubmitterProcedure {

	public function __construct($schema, $db, $type = null, $submitter = null) {
		parent::__construct($schema, $db, 'Onbekend', 'Onbekend');
	}
}

?>