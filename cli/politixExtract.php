<?php
/**
* Extracts info from Politix database and creates job file for
* watstemtmijnraad.nl importer.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/

//setup environment
require_once(dirname(__FILE__).'/../includes/prequel.cli.php');


//==========- Politix database, usually MySQL or SQLite -==============
$host =  'localhost';
$database = 'politix';
$user = 'root';
$password = '12345';



//=================- Source DB dependent -======================

//###################### voorstellentwee #########################


/*
$voorstellen_table = 'voorstellentwee';

$parties = array ( //for voorstellentwee db
	'sp', 'groenlinks', 'pvda', 'd66', 'cda', 'christenunie', 'sgp',
	'vvd', 'lpf', 'wilders', 'nawijn', 'lazrak', 'vanoudenallen',
	'eerdmansvanschijndel'
);
*/

//#################### voorstelen2006 ############################
$voorstellen_table = 'voorstellen2006';

$parties = array ( //for voorstellentwee db
	'sp', 'groenlinks', 'pvda', 'pvdd', 'd66', 'cda',
	'christenunie', 'sgp', 'vvd', 'pvv', 'verdonk'
);


//====================- Mapping data -======================
$type_map = array(
	'wetsvoorstel' => "Raadsvoorstel",
	'amendement' => "Amendement",
	'' => "Onbekend",
	'initiatiefwetsvoorstel' => "Initiatiefvoorstel"
);

//snapshot from live 4-08-2008
$category_map = array(
	'overig' => array("Geen"),
	'democratie en bestuur' => array(),
	'internationaal' => array("Internationale Betrekkingen"),
	'arbeid en sociale zekerheid' => array("Werk en Inkomen"),
	'onderwijs' => array("Onderwijs"),
	'justitie en politie' => array("Openbare Orde en Veiligheid"),
	'milieu en omgeving' => array("Natuur en Milieu"),
	'gezondheidszorg' => array("Gezondheid"),
	'vervoer en verkeer' => array("Verkeer en Vervoer"),
	'wonen' => array("Bouwen en Wonen"),
	'belastingen' => array("Financiën en Belasting"),
	'energie' => array(),
	'media en communicatie' => array(),
	'economie en consument' => array("Economische Zaken En Werkgelegenheid"),
	'immigratie en integratie' => array("Burgerzaken"),

    //fixes voorstellen2006
    '' => array(),
);


$votes_map = array(
	'niet bestaand' => null, //skip vote
	'voor' => 'yes',
	'tegen' => 'no',
	'niet aanwezig' => 'absent',
	'onthouden van stemming' => 'remember',

    //fixes for voorstellen2006
    '' => null, //skip vote
    'tegen,niet aanwezig' => 'no',
);

$result_map = array(
	'Aangenomen' => 'accepted',
	'Afgewezen' => 'declined',
	'Nog niet over gestemd' => 'new',
	'' => 'new'
);

//snapshot from live 4-08-2008
$party_map = array(
    "sp" => "Socialistische Partij",
    "groenlinks" => "GroenLinks",
    "pvda" => "Partij van de Arbeid",
    "d66" => "D66",
    "cda" => "Christen-Democratisch Appèl",
    "christenunie" => "ChristenUnie",
    "sgp" => "Staatkundig Gereformeerde Partij",
    "vvd" => "Volkspartij voor Vrijheid en Democratie",

    //specific to voorstellentwee
    "lpf" => "Lijst Pim Fortuyn",
    "wilders" => "Partij voor de Vrijheid",
    "nawijn" => "Groep Nawijn",
    "lazrak" => "Groep Lazrak",
    "vanoudenallen" => "Groep Van Oudenallen",
    "eerdmansvanschijndel" => "Groep Eerdmans-Van Schijndel",

    //patch from voorstellen2006
    "pvdd" => "Partij voor de Dieren",
    "pvv" => "Partij voor de Vrijheid",
    "verdonk" => "Trots op Nederland",
);

//==================- Data dump -===========================
$xw = new XMLWriter();
if(!$xw->openURI("./import.{$voorstellen_table}.xml")) die("Can't write to 'import.{$voorstellen_table}.xml', XMLWriter doesn't accept this!"); //this damn thing doesn't throw exceptions...
$xw->setIndent(true);

$xw->startDocument('1.0','UTF-8');
$xw->startDtd('wsmr', null, 'http://watstemtmijnraad.gl/import.dtd');
$xw->endDtd();

$xw->startElement('import');
$xw->writeAttribute('version', '1.0');
$xw->writeAttribute('site', 'Politix');




$pdo = new PDO("mysql:host={$host};dbname={$database}", $user, $password);
$pdo->query("SET NAMES 'utf8'"); //[XXX: needed for MySQL 5.x on my machine, comment out if causes problems ]

$source = $pdo->query("SELECT * FROM {$voorstellen_table};");
$source->setFetchMode(PDO::FETCH_ASSOC);

$time_start = time();
$time_end = 0;

try {
	$xw->startElement('raadsstukken');

	foreach ($source as $row) {
		$vote_date = strtotime("1/1/{$row['jaartal']} +{$row['weeknummer']} week");
		if($vote_date < $time_start) $time_start = $vote_date;
		if($vote_date > $time_end) $time_end = $vote_date;

		$xw->startElement('raadsstuk');
		$xw->writeAttribute('title', $row['rss']);
		$xw->writeAttribute('code', "I{$row['id']}W{$row['wet']}K{$row['nr']}");
		$xw->writeAttribute('vote_date', date('Y-m-d', $vote_date));
		$xw->writeAttribute('region', '/Europa/Nederland');
		$xw->writeAttribute('show', 'yes'); //show in home page
		//contents
		$xw->writeElement('summary', $row['voorstel']);

		$xw->startElement('submitter');
		if(!isset($type_map[$row['soort']])) throw new RuntimeException("Unresolved raadsstuk type/soort: ".$row['soort']);
		$xw->writeAttribute('type', $type_map[$row['soort']]);
		$xw->writeAttribute('submitter', 'Onbekend'); //no parent references, no submitters
		$xw->endElement(); //submitter

		$xw->startElement('tag');
		$xw->writeAttribute('name', 'politix');
		$xw->endElement();

		if(!isset($category_map[$row['ond']])) throw new RuntimeException("Unresolved raadsstuk category/ond: ".$row['ond']);
		foreach ($category_map[$row['ond']] as $cat) {
			$xw->startElement('category');
			$xw->writeAttribute('name', $cat);
			$xw->endElement();
		}

		if(!isset($result_map[$row['aangenomen']])) throw new RuntimeException("Unresolved result type: {$row['aangenomen']}");
		$xw->startElement('votes');
		$xw->writeAttribute('type', 'party'); //per party resolution
		$xw->writeAttribute('result', $result_map[$row['aangenomen']]);

		foreach($parties as $party) {
			if(!isset($party_map[$party])) throw new RuntimeException("Unresolved party: {$party}");
			if(!array_key_exists($row[$party], $votes_map)) throw new RuntimeException("Unresolved vote type: {$row[$party]}, party: {$party}");
			if($votes_map[$row[$party]] === null) continue; //skip vote

			$xw->startElement('vote');
			$xw->writeAttribute('vote', $votes_map[$row[$party]]);
			$xw->writeAttribute('party', $party_map[$party]);
			$xw->endElement();
		}
        $xw->endElement(); //votes

		$xw->endElement(); //raadsstuk
	}

	$xw->endElement(); //raadsstukken
} catch (Exception $e) {
	$xw->writeElement('error', $e->getMessage());
	echo $e->getMessage();
	exit(1);
}

$xw->endElement(); //import
$xw->flush();

echo "\nDone";
?>
