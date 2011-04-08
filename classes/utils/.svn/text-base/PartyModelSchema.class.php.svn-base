<?php

require_once('NotFoundException.class.php');
require_once('PartyModel.class.php');


/**
* Handles party set.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PartyModelSchema {

	/** party index by stemmed name */
	private $parties = array();
	/** party index by id */
	private $id_index = array();

	/** @var PDO */
	private $db;
	private $global_schema;


	/**
	 * Load party schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 * @param ModelSchema $global_schema the global schema
	 */
	public function __construct($db, ModelSchema $global_schema) {
		$log = JLogger::getLogger("utils.import.schema.party");
		$log->enter("Starting with fetch of the whole party schema.");

		$this->db = $db;
		$this->global_schema = $global_schema;

		$log->preSelect("Fetching all parties.");
		$ret = $this->db->query('SELECT * FROM '.PartyModel::TABLE_NAME);
		$ret->setFetchMode(PDO::FETCH_ASSOC);

  		$regn = $this->db->prepare('SELECT id, region, to_char(time_start, \'yyyy-mm-dd\') as start, to_char(time_end, \'yyyy-mm-dd\') as end FROM '.PartyModel::REGION_REGISTRATION_TABLE.' WHERE party = :party;');
  		$regn->setFetchMode(PDO::FETCH_ASSOC);

  		$regs = $global_schema->getRegionSchema();
		foreach ($ret as $row) {
			$party = new PartyModel($row['name'], $regs->lookup($row['owner']), $row['short_form']);

			//$log->preSelect("Fetching region regisrations for party: {$party->getName()}");
			$regn->execute(array(':party' => $row['id']));
			$regions = array();
			foreach ($regn as $rg) $regions[$rg['region']][$rg['id']] = array('start' => $rg['start'], 'end' => $rg['end']);

			$party->resolve($this, $this->db, $row['id'], $regions);
			$this->id_index[$party->getId()] = $party;
			$this->parties[$party->getKey()] = $party;
		}

		//few records
		$log->preSelect("Fetching all party parent references");
		$prn = $this->db->query('SELECT * FROM '.PartyModel::REFERENCE_TABLE.';');
  		$prn->setFetchMode(PDO::FETCH_ASSOC);

		foreach ($prn as $ref) {
			$pr = $this->lookup($ref['parent']);
			$me = $this->lookup($ref['party']);
			$me->resolveParent($ref['id'], $pr);
		}

		unset($ret);
		unset($regn);
		unset($prn);

		$log->leave("Successfully ended fetching party schema.");
	}


	/**
	 * Returns global schema.
	 * @return ModelSchema
	 */
	public function getGlobalSchema() {
		return $this->global_schema;
	}


	/**
	 * Add new party to the schema.
	 * If party with such name doesn't exists, then a new party record will be created.
	 * After adding party to the schema it becomes "resolved".
	 *
	 * @param PartyModel $party
	 * @return PartyModel either new $party or already defined party
	 */
	public function addParty(PartyModel $party) {
		if(isset($this->parties[$party->getKey()])) return $this->parties[$party->getKey()];

		$log = JLogger::getLogger("utils.import.schema.party");
		$log->debug("Creating new party: {$party->getName()}");
		$party->resolve($this, $this->db, null, array());

		$this->id_index[$party->getId()] = $party;
		$this->parties[$party->getKey()] = $party;
		return $party;
	}


	/**
	 * Returns party by name.
	 * @param string $name party name
	 */
	public function getParty($name) {
		$key = PartyModel::stem($name);
		if(isset($this->parties[$key])) return $this->parties[$key];
		else throw new NotFoundException("Party '{$name}' is not found!");
	}

	/**
	 * Returns party by id.
	 *
	 * @throws NotFoundException if party is not found
	 * @param integer $id party id
	 * @return PartyModel found party.
	 */
	public function lookup($id) {
		if(!isset($this->id_index[$id])) {
			$log = JLogger::getLogger("utils.import.schema.party");
			$log->debug("Database lookup for party id: {$id}");

			$log->preSelect("Select party by id: {$id}");
			$ret = $this->db->query('SELECT * FROM '.PartyModel::TABLE_NAME.' WHERE id = :id');
			$row = $ret->execute(array(':id' => $id))->fetch(PDO::FETCH_ASSOC);
			if(!$row) throw new NotFoundException("Party with id '{$id}' is not found!");

			$log->debug("Party for id: {$id} is found as: {$row['name']}");
			$log->preSelect("Fetching party region registrations for: {$id} - '{$row['name']}");
			$regn = $this->db->prepare('SELECT id, region, to_char(time_start, \'yyyy-mm-dd\') as start, to_char(time_end, \'yyyy-mm-dd\') as end FROM '.PartyModel::REGION_REGISTRATION_TABLE.' WHERE party = :party;');
  			$regn->setFetchMode(PDO::FETCH_ASSOC);

  			$regn->execute(array(':party' => $row['id']));
			$regions = array();
			foreach ($regn as $rg) $regions[$rg['region']][$rg['id']] = array('start' => $rg['start'], 'end' => $rg['end']);


			$regs = $this->global_schema->getRegionSchema();
			$par = new PartyModel($row['name'], $regs->lookup($row['owner']), $row['short_form']);
			$par->resolve($this, $this->db, $row['id'], $regions);

			$log->preSelect("Fetching all party parent references for: {$id} - '{$par->getName()}'");
			$prn = $this->db->query('SELECT * FROM '.PartyModel::REFERENCE_TABLE.' WHERE party = :party;');
  			$prn->setFetchMode(PDO::FETCH_ASSOC);
  			$prn->execute(array(':party' => $row['id']));

			foreach ($prn as $ref) {
				$pr = $this->lookup($ref['parent']);
				$par->resolveParent($ref['id'], $pr);
			}

			$this->id_index[$row['id']] = $par;
			$this->parties[$par->getKey()] = $par;

			unset($ret);
			unset($regn);
			unset($prn);

			$log->leave("Successfully recovered party '{$par->getName()}' by id: {$id}");
		}

		return $this->id_index[$id];
	}



	/**
	 * Serialize this schema to the DOM tree.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'parties' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options = null) {
		$el = $dom->createElement('parties');
		$root->appendChild($el);

		$comb = array();
		$done = array();
		foreach ($this->parties as $par) {
			if($par->isCombination()) $comb[] = $par;
			else {
				$par->toXml($dom, $el, $options);
				$done[$par->getKey()] = true;
			}
		}

		while(sizeof($comb) > 0) {
			$par = array_pop($comb);
			if(!isset($done[$par->getKey()])) $this->depToXml($dom, $el, $options, $done, $par);
		}
	}

	protected function depToXml($dom, $cont, $options, &$done, $par) {
		foreach ($par->listCombinationParties() as $prnt) {
			if(!isset($done[$prnt->getKey()])) $this->depToXml($dom, $cont, $options, $done, $prnt);
		}
		$par->toXml($dom, $cont, $options);
		$done[$par->getKey()] = true;
	}


	/**
	 * Read & update schema from XML data.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $node schema node
	 * @return void
	 */
	public function update(SimpleXMLElement $node) {
		$log = JLogger::getLogger("utils.import.schema.party");
		$log->enter("Updating party schema from XML source.");

		foreach ($node->party as $par) {
			$region = $this->global_schema->getRegionSchema()->getRegion((string)$par['region']);
			$p = new PartyModel((string)$par['name'], $region, (string)$par['abbreviation']);
			$p = $this->addParty($p);

			if($par->combination->partyref)
				foreach ($par->combination->partyref as $pr)
					$p->addPartyReference((string)$pr['party']);

			foreach ($par->inregion as $reg) {
				$region = $this->global_schema->getRegionSchema()->getRegion((string)$reg['region']);
				$p->ensureRegisteredInRegion($region, (string)$reg['date_start'], (string)$reg['date_end']);
			}
		}

		$log->leave("Successfully updated party schema from XML source");
	}
}
?>