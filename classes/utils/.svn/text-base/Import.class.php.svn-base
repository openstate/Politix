<?php

require_once('ModelSchema.class.php');
require_once('RaadsstukModel.class.php');
require_once('JLogger.class.php');

/**
* Raadsstukken import (job file processor).
*
* Logger: utils.import
*
* @author Sardar Yumatov
*/
class Import {

	/** Validation schema file */
	const XML_SCHEMA_FILE = "./import.xsd";


	/** @var PDO */
	private $db;
	/** @var ModelSchema */
	private $schema;
	/** @var XMLReader */
	private $reader;

	private $site;


	/**
	 * Construct new importer.
	 * This will load the database schema objects.
	 *
	 * Note: the PDO will be set in error-mode:exception, oracle-nulls:empty-string-to-null.
	 *
	 * @param PDO $db db link
	 */
	public function __construct($db) {
		$log = JLogger::getLogger('utils.import');
		$log->debug("Constructing importer.");

		$this->db = $db;
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

		$this->schema = new ModelSchema($db);

		$this->reader = new XMLReader();

		//if(!$this->reader->setSchema(self::XML_SCHEMA_FILE)) throw new RuntimeException("Can't set XML Schema file: ".self::XML_SCHEMA_FILE);
	}

	/**
	 * Returns watstemtmijnraad.nl schema.
	 * @return ModelSchema
	 */
	public function getSchema() {
		return $this->schema;
	}

	/**
	 * Set URL/URI pointing to the source to parse.
	 * @param string $uri path to file to read
	 * @return void
	 */
	public function setURISource($uri) {
		if(!$this->reader->open($uri)) throw new RuntimeException("Can't open source URI: {$uri}");
	}

	/**
	 * Set already loaded XML data as source.
	 * @param string $xml xml data
	 * @return void
	 */
	public function setStringSource($xml) {
		if(!$this->reader->XML($xml)) throw new RuntimeException("Can't set XML data, by unknown reason.");
	}

	/**
	 * Parse and execute job file.
	 *
	 * Warning: this method doesn't start the database transaction!
	 * You probably should start the transaction and enclose call
	 * to this method with try/catch statement, rollingback transaction
	 * on any error.
	 *
	 * @throws RuntimeException on any error
	 * @return void
	 */
	public function process() {
		$log = JLogger::getLogger('utils.import');
		$log->enter("Beginning with import procedure.");

		try {
			$this->nextElement('import');
			if(($ver = $this->reader->getAttribute('version')) != '1.0')
				throw new RuntimeException("Unsupported version '{$ver}', expecting '1.0'!");

			$log->info("Processing import file version: {$ver}");

			$this->site = $this->schema->getSiteSchema()->getSite($this->reader->getAttribute('site'));
			$log->debug("Import block for site '{$this->reader->getAttribute('site')}', id: {$this->site->getId()}");

			$this->nextElement(array('schema', 'raadsstukken')); //either
			if($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name == 'schema') {
				$log->enter("Reading schema definition.");

				$schema = $this->reader->expand();
				$this->reader->next(); //skip schema

				$dom = new DOMDocument();
				$dom->appendChild($schema);
				$this->schema->update(simplexml_import_dom($dom));

				$log->leave("Successfully processed schema definition.");
			} else $log->info("Schema definition is not found.");

			//current: either text node, raadsstuken or closing import
			if($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name != 'raadsstukken') $this->nextElement('raadsstukken');
			if($this->reader->nodeType != XMLReader::ELEMENT) $this->reader->read();
			if($this->reader->nodeType == XMLReader::ELEMENT) {
				$log->enter("Starting import of voorstellen.");
				//read raadsstukken data
				$i = $this->importRaadsstukken();
				$log->leave("Successfully imported all {$i} voorstellen.");
			} else{
				$log->info("Voorstellen block is not found.");
			}

			$this->nextElement();
			if($this->reader->nodeType != XMLReader::END_ELEMENT || $this->reader->name != 'import') throw new RuntimeException("Unexpected element: ".$this->reader->name);

			//end
			$this->reader->close();
		} catch (Exception $e) {
			$this->reader->close();
			throw $e;
		}

		$log->leave("Successfully processed the import data!");
	}


	/**
	 * Move cursor to the next element.
	 * @param string|array $el
	 */
	private function nextElement($el = null) {
		if($this->reader->nodeType == XMLReader::END_ELEMENT) return;

		while ($this->reader->read()) {
			if($this->reader->nodeType == XMLReader::ELEMENT) {
				if($el) {
					if((is_array($el) && in_array($this->reader->name, $el)) || (is_string($el) && $this->reader->name == $el)) return;
					throw new RuntimeException("Expecting ".(is_array($el)? "one of: ".implode(', ', $el): $el).", but got: ".$this->reader->name);
				}
			} elseif($this->reader->nodeType == XMLReader::END_ELEMENT) return;
			//ignore whitespace shit
		}
		if(!$this->reader->isValid()) throw new RuntimeException("Document is invalid!");
		else throw new RuntimeException("Unexpected stop of XML stream!");
	}


	/**
	 * Read raadsstukken block
	 *
	 * @throws RuntimeException on any error
	 * @return integer number of imported raadsstukken
	 */
	private function importRaadsstukken() {
		$log = JLogger::getLogger('utils.import');

		$dom = new DOMDocument('1.0', 'UTF-8');
		$i = 0;

		while ($this->reader->read()) {
			if($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name == 'raadsstuk') {

				$node = $this->reader->expand();
				$this->reader->next();

				$dom->appendChild($node);
				$xml = simplexml_import_dom($node);

				$log->debug("Processing voorstel: {$xml['title']}");

				$region = $this->schema->getRegionSchema()->getRegion((string)$xml['region']);
				$show = in_array(trim(strtolower((string)$xml['show'])), array('y', 'yes', '1', 'enable', 'on', 'true'));
				$id = (string)$xml['id'] == ''? null: (string)$xml['id'];

				$rs = new RaadsstukModel(
					$this->schema,
					$this->db,
					$this->site, //site identifier
					(string)$xml['title'],
					(string)$xml['vote_date'],
					$region,
					(string)$xml['code'],
					$show,
					$id
				);
				$rs->setSummary((string)$xml->summary);

				$tag_schema = $this->schema->getTagSchema();
				foreach ($xml->tag as $tag) $rs->addTag($tag_schema->getTag((string)$tag['name']));

				$cat_schema = $this->schema->getCategorySchema();
				foreach ($xml->category as $cat) $rs->addCategory($cat_schema->getCategory((string)$cat['name']));

				if(!$xml->submitter) throw new RuntimeException("Submitter is required!");
				else {
					$log->debug("Defining submitter procedure: ".((string)$xml->submitter['type']));
					$submitter = $rs->defineSubmitter((string)$xml->submitter['type'], (string)$xml->submitter['submitter']);

					if($xml->submitter->parentref) $submitter->setParentRaadsstuk((string)$xml->submitter->parentref['raadsstuk']);
					foreach ($xml->submitter->politicianref as $pol) $submitter->addPolitician((string)$pol['politician']);
				}

				if(!$xml->votes) throw new RuntimeException("Expecting vote block!");
				else {
					$vts = $xml->votes;
					$log->debug("Adding votes by: ".$vts['type']);
					$voteblock = $rs->defineVoteBlock((string)$vts['type'], (string)$vts['result']);

					foreach ($vts->vote as $vote) {
						if(isset($vote['politician']) && $vote['politician'] != '') $voteblock->votePolitician((string)$vote['vote'], (string)$vote['politician']);
						elseif(isset($vote['party']) && $vote['party'] != '') $voteblock->voteParty((string)$vote['vote'], (string)$vote['party']);
						else throw new RuntimeException("Expecting either 'politician' or 'party' for vote, got nothing.");
					}
				}

				$log->debug("Resolving new voorstel: {$rs->title}");
				$rs->resolve();

				unset($rs);
				$dom->removeChild($node);

				$i += 1;
			}

			if($this->reader->nodeType == XMLReader::END_ELEMENT && $this->reader->name == 'import') break;
		}

		return $i;
	}
}


?>