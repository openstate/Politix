<?php

require_once('ModelSchema.class.php');
require_once('JLogger.class.php');

/**
* Fetches db schema in import.xsd format.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class SchemaPage {

	public function processGet($get) {
		//parse query
		$arg = isset($get['arg'])? strval($get['arg']): '';
		$toks = array_filter(array_map('trim', explode('/', $arg)));

		$options = array('regions.flat' => true);

		$inf = require('database.private.php');
		$inf = $inf[DBs::SYSTEM];

		$config = array(
			'port' => 5432,
			'host' => $inf['host'],
			'user' => $inf['user'],
			'password' => $inf['pass'],
			'database' => $inf['database']
		);

		$pdo = new PDO("pgsql:host={$config['host']} port={$config['port']} dbname={$config['database']}", $config['user'], $config['password']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//set logging
		//$collector = new CollectorJLoggerHandler();
		//$root = JLogger::getLogger();
		//$root->addLogHandler($collector);

		$site = 'Watstemtmijnraad';

		$d = Dispatcher::inst();

		$impl = new DOMImplementation();
		$dtd = $impl->createDocumentType('wsmr', '', "http://{$d->domain}.{$d->tld}/import.dtd");
		$dom = $impl->createDocument("", "", $dtd);

		//$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;
		$el = $dom->createElement('import');
		$el->setAttribute('version', '1.0');
		$el->setAttribute('site', $site);
		$dom->appendChild($el);

		try {
			$pdo->beginTransaction(); //no writes will ever happen, this is just to prevent any damage because of possible bugs
			define('DRY_RUN', true); //another way to 'die' when unexpected writes happen

			$schema = new ModelSchema($pdo);

			if($toks) {
				$toks = array_flip($toks);
				if(isset($toks['regions'])) $schema->getRegionSchema()->toXml($dom, $el, $options);
				if(isset($toks['categories'])) $schema->getCategorySchema()->toXml($dom, $el, $options);
				if(isset($toks['parties'])) $schema->getPartySchema()->toXml($dom, $el, $options);
				if(isset($toks['politicians'])) $schema->getPoliticianSchema()->toXml($dom, $el, $options);
			} else $schema->toXml($dom, $el, $options); //dump everything

			$pdo->rollBack();
		} catch (Exception $e) {
			try {
				$pdo->rollBack();
			} catch (Exception $bla) {

			}
			//$root->error("Database failure: ".$e->getMessage(), $e);
		}

		echo $dom->saveXML();
	}
}

?>