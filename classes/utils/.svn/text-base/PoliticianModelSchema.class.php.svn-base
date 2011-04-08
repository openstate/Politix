<?php

require_once('NotFoundException.class.php');
require_once('PoliticianModel.class.php');


/**
* Handles politician set.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class PoliticianModelSchema {

	/** politician index by stemmed key */
	private $politicians = array();
	/** politician index by id */
	private $id_index = array();
	/** politician index by external id */
	private $extern_id = array();

	/** @var PDO */
	private $db;
	private $global_schema;

	/** Default politicians */
	private $def_politics = array();


	/**
	 * Load politician schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 * @param ModelSchema $global_schema the global schema
	 */
	public function __construct($db, ModelSchema $global_schema) {
		$log = JLogger::getLogger("utils.import.schema.politician");
		$log->enter("Starting with fetch of the whole politician schema.");

		$this->db = $db;
		$this->global_schema = $global_schema;

		$log->preSelect("Fetching all politicians.");
		$ret = $this->db->query('SELECT * FROM '.PoliticianModel::TABLE_NAME);
		$ret->setFetchMode(PDO::FETCH_ASSOC);

  		$regn = $this->db->prepare('SELECT id, party, region, category, description, to_char(time_start, \'yyyy-mm-dd\') as start, to_char(time_end, \'yyyy-mm-dd\') as end FROM '.PoliticianModel::FUNCTION_TABLE.' WHERE politician = :politician ORDER BY time_end;');
  		$regn->setFetchMode(PDO::FETCH_ASSOC);

  		$regs = $global_schema->getRegionSchema();
  		$i = 0;
		foreach ($ret as $row) {
			$pol = new PoliticianModel(
				$row['first_name'],
				$row['last_name'],
				($row['gender_is_male'])? 'male': 'female',
				$row['title'],
				$row['email'],
				$row['region_created']? $regs->lookup($row['region_created']): null,
				null,
				$row['def_party']
			);

			//$log->preSelect("Fetching all functions for politician: {$pol->last_name}");
			$regn->execute(array(':politician' => $row['id']));
			$funcs = array();
			foreach ($regn as $rg) {
				$funcs["{$rg['party']}-{$rg['region']}-{$rg['category']}"][$rg['id']] = array(
					'category' => $this->global_schema->getCategorySchema()->lookup($rg['category']),
					'region' => $this->global_schema->getRegionSchema()->lookup($rg['region']),
					'party' => $this->global_schema->getPartySchema()->lookup($rg['party']),

					'start' => $rg['start'],
					'end' => $rg['end'],
					'description' => $rg['description']
				);
			}

			$pol->resolve($this, $this->db, $row['id'], $funcs);

			$this->id_index[$pol->getId()] = $pol;
			if($row['def_party'] === null) $this->politicians[$pol->getKey()] = $pol;
			else $this->def_politics[$row['def_party']][] = $pol;

			$i += 1;
		}

		unset($regn);
		unset($ret);

		$log->leave("Fetched {$i} politicians.");
	}


	/**
	 * Returns global schema.
	 * @return ModelSchema
	 */
	public function getGlobalSchema() {
		return $this->global_schema;
	}


	/**
	 * Returns politician by internal, external id.
	 * Method recognizes prefixes:
	 *   - 'in', 'intern', 'internal' -- as internal index (defined in document)
	 *   - 'ex', 'extern', 'external' -- as external index (in watstemtmijnraad.nl database)
	 *   - no index -- as internal index
	 *
	 * Examples:
	 *   - '90' -- internal index 90
	 *   - 'test' -- internal index 'test'
	 *   - 'in:5' -- internal index '5'
	 *   - 'ex:1' -- external index '1'
	 *
	 * @throws NotFoundException if politician is not found
	 * @param string $politician_ext_id
	 * @return PoliticianModel
	 */
	public function getPolitician($politician_ext_id) {
		$mth = null;
		if(preg_match('#([a-zA-Z]+):\\s*([0-9]+)#', $politician_ext_id, $mth)) {
			if(in_array($mth[1], array('ex', 'extern', 'external'))) return $this->lookup($mth[2]);
			if(!in_array($mth[1], array('in', 'intern', 'internal'))) throw new RuntimeException("Unknown id prefix: {$mth[1]}");
			$id = $mth[2];
		} else $id = $politician_ext_id;

		if(!isset($this->extern_id[$id])) throw new NotFoundException("Politician with internal id: '{$id}' is not found!");
		return $this->extern_id[$id];
	}

	/**
	 * Lookup for politician by id.
	 * @param integer $id
	 * @return PoliticianModel
	 */
	public function lookup($id) {
		$id = intval($id);

		if(!isset($this->id_index[$id])) {
			$ret = $this->db->prepare('SELECT * FROM '.PoliticianModel::TABLE_NAME.' WHERE id = :id;');
			$row = $ret->execute(array(':id' => $id))->fetch(PDO::FETCH_ASSOC);

			if(!$row) throw new NotFoundException("Politician with id '{$id}' is not found!");

  			$regn = $this->db->prepare('SELECT id, party, region, category, description, to_char(time_start, \'yyyy-mm-dd\') as start, to_char(time_end, \'yyyy-mm-dd\') as end FROM '.PoliticianModel::FUNCTION_TABLE.' WHERE politician = :politician;');
  			$regn->setFetchMode(PDO::FETCH_ASSOC);

  			$regs = $this->global_schema->getRegionSchema();
			$pol = new PoliticianModel(
				$row['last_name'],
				($row['gender_is_male'] == 't')? 'male': 'female',
				$row['title'],
				$row['first_name'],
				$row['email'],
				$row['region_created']? $regs->lookup($row['region_created']): null,
				null,
				$row['def_party']
			);

			$regn->execute(array(':politician' => $row['id']));
			$funcs = array();
			foreach ($regn as $rg) {
				$funcs["{$rg['party']}-{$rg['region']}-{$rg['category']}"][$rg['id']] = array(
					'category' => $this->global_schema->getCategorySchema()->lookup($rg['category']),
					'region' => $this->global_schema->getRegionSchema()->lookup($rg['region']),
					'party' => $this->global_schema->getPartySchema()->lookup($rg['party']),

					'start' => $rg['start'],
					'end' => $rg['end'],
					'description' => $rg['description']
				);
			}

			$pol->resolve($this, $this->db, $row['id'], $funcs);

			$this->id_index[$pol->getId()] = $pol;
			if($row['def_party'] === null) $this->politicians[$pol->getKey()] = $pol;
			else $this->def_politics[$row['def_party']][] = $pol;

			unset($regn);
			unset($ret);
		}

		return $this->id_index[$id];
	}

	/**
	 * Returns default politician that can made a vote for party.
	 * @param PartyModel $party the party model
	 * @param RegionModel $region associated region
	 * @return PoliticianModel politician that can vote for party
	 */
	public function getDefaultPoliticianForParty(PartyModel $party, $date, RegionModel $region) {
		if($date == '') throw new InvalidArgumentException("Date is required!");

		if(isset($this->def_politics[$party->getId()])) {
			$politicians = $this->def_politics[$party->getId()]; //usually 1
			foreach ($politicians as $pol) {
				if($pol->canVoteFor($party, $region, $date)) return $pol;
			}

			if($politicians) { //upate, reuse
				$pol = array_pop($politicians);
				$pol->registerFunction($region, $party, $date, $date); //geen category
				return $pol;
			}
		}

		//we have to create new virtual politician
		$pol = new PoliticianModel(null, 'Onbekend', 'male', null, null, null, null, $party->getId());
		$pol->resolve($this, $this->db, null);
		$this->id_index[$pol->getId()] = $pol;
		$this->def_politics[$party->getId()][] = $pol;
		//whole date range, so we will not floo db with day registrations
		$pol->registerFunction($region, $party, null, null, null, "Created on demand");

		return $pol;
	}


	/**
	 * Add/merge politician.
	 *
	 * @param PoliticianModel $politician
	 * @return PoliticianModel either new $politician or already defined politician
	 */
	public function addPolitician(PoliticianModel $politician) {
		if(isset($this->politicians[$politician->getKey()])) {
			$pol = $this->politicians[$politician->getKey()];
			if($politician->externalId) $this->extern_id[$politician->externalId] = $pol;
			return $pol;
		}

		$politician->resolve($this, $this->db, null);


		$this->id_index[$politician->getId()] = $politician;
		$this->politicians[$politician->getKey()] = $politician;
		if($politician->externalId) $this->extern_id[$politician->externalId] = $politician;

		return $politician;
	}


	/**
	 * Serialize this schema to the DOM tree.
	 *
	 * If "politician.real-id" option is set, then actual
	 * id's from the database will be used as document id's. Otherwise
	 * document id's [1..) will be generated instead.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'politicians' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options = null) {
		$el = $dom->createElement('politicians');
		$root->appendChild($el);
		$el->appendChild($dom->createComment("The (initials, last name) combination is not unique, to prevent disambiguations always specify the region where this politician from and/of email, otherwise a vote can be assigned to a wrong person!"));

		$options['politician.external_id'] = 1;
		foreach ($this->politicians as $par) {
			$el->appendChild($dom->createComment("Politician unique key '(region)_initials_lastname_gender_email': ".$par->getKey()));

			$par->toXml($dom, $el, $options);
			if(isset($options['politician.real-id']) && isset($options['politician.real-id'])) {
				$options['politician.external_id'] = $par->getId();
			} else $options['politician.external_id'] += 1;
		}
	}


	/**
	 * Read & update schema from XML data.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $node schema node
	 * @return void
	 */
	public function update(SimpleXMLElement $node) {
		foreach ($node ->politician as $row) {
			$p = new PoliticianModel((string)$row['initials'], (string)$row['last_name'], (string)$row['gender'], (string)$row['title'], (string)$row['email'], $this->global_schema->getRegionSchema()->getRegion((string)$row['region']), (string)$row['id']);
			$p = $this->addPolitician($p);

			foreach ($row->function as $func) {
				$region = $this->global_schema->getRegionSchema()->getRegion((string)$func['region']);
				$party = $this->global_schema->getPartySchema()->getParty((string)$func['party']);

				$category = (string)$func['category'];
				$category = $category == ''? null: $this->global_schema->getCategorySchema()->getCategory($category);
				$p->registerFunction($region, $party, (string)$func['date_start'], (string)$func['date_end'], $category, (string)$row['description']);
			}
		}
	}
}
?>