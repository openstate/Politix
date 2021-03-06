<?php


/** Imports politix database snapshot. */
class PolitixImport2006Page {


	private $messages = array();
	private $success = false;
	private $db;

	public function __construct() {
		$this->db = DBs::inst(DBs::SYSTEM);
	}


	/** apply patch. */
	public function processGet($get) {
		$this->db->query("START TRANSACTION");

		try {

//=============- Time vote time ranges of the data dump -================
	$time_start = 1151791200;
	$time_end = 1213048800;

if($time_start >= $time_end) throw new RuntimeException("Time range for raadsstukken is invalid or zero: ".date('Y-m-d', $time_start)." - ".date('Y-m-d', $time_end));
if(is_numeric($time_start)) $time_start = date('Y-m-d', $time_start);
if(is_numeric($time_end)) $time_end = date('Y-m-d', $time_end);


//==============- Category map -===================
//snapshot from live 4-08-2008
$category_map = array(
	'overig' => array(array(-1 ,"Geen")),
	'democratie en bestuur' => array(),
	'internationaal' => array(array(19 ,"Internationale Betrekkingen")),
	'arbeid en sociale zekerheid' => array(array(3 ,"Werk en Inkomen")),
	'onderwijs' => array(array(10 ,"Onderwijs")),
	'justitie en politie' => array(array(14 ,"Openbare Orde en Veiligheid")),
	'milieu en omgeving' => array(array(4 ,"Natuur en Milieu")),
	'gezondheidszorg' => array(array(6 ,"Gezondheid")),
	'vervoer en verkeer' => array(array(7 ,"Verkeer en Vervoer")),
	'wonen' => array(array(1 ,"Bouwen en Wonen")),
	'belastingen' => array(array(18 ,"Financiën en Belasting")),
	'energie' => array(),
	'media en communicatie' => array(),
	'economie en consument' => array(array(9 ,"Economische Zaken En Werkgelegenheid")),
	'immigratie en integratie' => array(array(15 ,"Burgerzaken")),

    //fixes voorstellen2006
    '' => array(),
);


//==========- type map -========================
//snapshot 4-08-2008
$type_map = array(
	'wetsvoorstel' => array(1, "Raadsvoorstel"),
	'amendement' => array(3, "Amendement"),
	'' => array(null, "Onbekend"),
	'initiatiefwetsvoorstel' => array(2, "Initiatiefvoorstel")
);

$this->ensureRaadsstukTypeMap($type_map);


//===========- Result map -=================

$result_map = array(
	'Aangenomen' => array(1, "Aangenomen"),
	'Afgewezen' => array(2, "Afgewezen"),
	'Nog niet over gestemd' => array(0, "Niet gestemd"),
	'' => array(0, "Niet gestemd")
);


//============- Submitter type map -==============
$submitter_type_map = array(
	'@submitter@' => array(null, "Onbekend"),
);

$this->ensureRaadsstukSubmitter($submitter_type_map);


//==========- Region map -====================
$region_map = array(
	'@region@' => array(2, "Nederland"),
);


//==========- Tag map -======================
$tags_map = array(
	'politix' => array(null, 'politix'),
);

$this->ensureTags($tags_map);


//==========- Votes map -========================
$votes_map = array(
	'niet bestaand' => null, //skip vote
	'voor' => array(0, 'Voor'),
	'tegen' => array(1, 'Tegen'),
	'niet aanwezig' => array(3, 'Afwezig'),
	'onthouden van stemming' => array(2, 'Onthouden'),

    //fixes for voorstellen2006
    '' => null, //skip vote
    'tegen,niet aanwezig' => array(1, 'Tegen'),
);

//============- Party map -======================
$party_map = array(
    "sp" => array(40, "Socialistische Partij"),
    "groenlinks" => array(6, "GroenLinks"),
    "pvda" => array(1, "Partij van de Arbeid"),
    "d66" => array(32, "D66"),
    "cda" => array(4, "Christen-Democratisch Appèl"),
    "christenunie" => array(31, "ChristenUnie"),
    "sgp" => array(39, "Staatkundig Gereformeerde Partij"),
    "vvd" => array(44, "Volkspartij voor Vrijheid en Democratie"),

    //specific to voorstellentwee
    "lpf" => array(null, "Lijst Pim Fortuyn", "owner" => '@region@'),
    "wilders" => array(null, "Partij voor de Vrijheid", "owner" => '@region@'),
    "nawijn" => array(null, "Groep Nawijn", "owner" => '@region@'),
    "lazrak" => array(null, "Groep Lazrak", "owner" => '@region@'),
    "vanoudenallen" => array(null,"Groep Van Oudenallen", "owner" => '@region@'),
    "eerdmansvanschijndel" => array(null, "Groep Eerdmans-Van Schijndel", "owner" => '@region@'),

    //patch from voorstellen2006
    "pvdd" => array(null, "Partij voor de Dieren", "owner" => '@region@'),
    "pvv" => array(null, "Partij voor de Vrijheid", "owner" => '@region@'),
    "verdonk" => array(null, "Trots op Nederland", "owner" => '@region@'),
);
$this->ensureParties($party_map, $region_map, $time_start, $time_end);

//=========- All politicians that 'do' the vote -=================
$politician_map = array(
	"sp" => array(null, "Onbekend"),
    "groenlinks" => array(null, "Onbekend"),
    "pvda" => array(null, "Onbekend"),
    "d66" => array(null, "Onbekend"),
    "cda" => array(null, "Onbekend"),
    "christenunie" => array(null, "Onbekend"),
    "sgp" => array(null, "Onbekend"),
    "vvd" => array(null, "Onbekend"),

    //specific for voorstellentwee
    "lpf" => array(null, "Onbekend"),
    "wilders" => array(null, "Onbekend"),
    "nawijn" => array(null, "Onbekend"),
    "lazrak" => array(null, "Onbekend"),
    "vanoudenallen" => array(null, "Onbekend"),
    "eerdmansvanschijndel" => array(null, "Onbekend"),

    //specific for voorstellen2006
    "pvdd" => array(null, "Onbekend"),
    "pvv" => array(null, "Onbekend"),
    "verdonk" => array(null, "Onbekend"),
);
$this->ensurePoliticians($politician_map, $party_map, $region_map, $time_start, $time_end);


/** Serialized data from MySQL dump */
$data = array (
  0 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging budget sociale werkvoorzieningen',
    ':vote_date' => 1166914800,
    ':summary' => 'Het budget van de sociale werkvoorzieningen (dat besteedt wordt door gemeenten) dient met 25 miljoen euro te worden verhoogd. ',
    ':code' => 'I725W30588K3',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  1 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging budget voor nazorg ex-gedetineerden',
    ':vote_date' => 1166914800,
    ':summary' => 'De post Rechtshandhaving en criminaliteitsbestrijding op de begroting van het Ministerie van Justitie moet verhoogd worden met �Ǩ 1.030.000. Dit geld moet besteed worden aan de nazorg voor ex-gedetineerden die op vrijwillige basis nog in een justiti?�le inrichting verblijven. Om dit te financieren moet de post voor jeugd met hetzelfde bedrag verlaagd worden. ',
    ':code' => 'I726W30588K4',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  2 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijzigingen voor telefoonnummers met hoog tarief',
    ':vote_date' => 1170025200,
    ':summary' => 'Wijzigingen voor telefoonnummers met hoog tarief. Twee nieuwe situaties waarin OPTA uitgifte telefoonnummer met hoog tarief (bijv. 0900-nummers) mag weigeren. Ten eerste indien aanvrager buiten de Europese Economische Ruimte is gevestigd. Ten tweede wanneer het Bureau Bevordering Integriteitsbeoordelingen negatief over de aanvraag oordeelt. Het kennelijk misbruik maken van het hoge tarief van het telefoonnummer wordt wettelijke grond waarop de OPTA een nummer mag intrekkern. Nummerhouders mogen het nummer voortaan niet aan anderen in gebruik geven en moeten bepaalde gegevens over het nummer vastleggen. ',
    ':code' => 'I727W30537K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  3 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wettelijk vervallen tegemoetkoming ziektekosten',
    ':vote_date' => 1170630000,
    ':summary' => 'De tegemoetkoming in de ziektekosten die ministers, staatssecretarissen, leden van de beide kamers der Staten-Generaal, de leden van het Europees Parlement, de vice-president en de staatsraden van de Raad van State en de president en de overige leden van de Algemene Rekenkamer  tot 1 januari 2006 ontvingen komt in de wetten waarin de bezoldiging van deze ambten geregeld is te vervallen. Dit hangt samen met de invoering van het nieuwe zorgstelsel. ',
    ':code' => 'I728W30903K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  4 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verlening termijn opschorting van betaling',
    ':vote_date' => 1170025200,
    ':summary' => 'De OPTA kan aanbieders van openbare communicatienetwerken (bijvoorbeeld KPN) verzoeken om betaling aan eigenaren van telefoonnummers met een hoog tarief (0900-nummers) op te schorten met drie weken. Deze termijn moet worden verhoogd naar vier weken. ',
    ':code' => 'I729W30537K9',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  5 =>
  array (
    ':region' => '@region@',
    ':title' => 'Publicatie in staatscourant van overtreding telecommunicatiewet',
    ':vote_date' => 1170025200,
    ':summary' => 'Indien een eigenaar van een nummer met een hoog tarief (0900-nummer) de telecommunicatiewet heeft overtreden, moet de OPTA hiervan melding kunnen maken in de staatscourant. De nummerhouder mag van de consument geen betaling vragen nadat deze mededeling in de staatscourant is verschenen over over de periode waar de mededeling over gaat. ',
    ':code' => 'I730W30537K8',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  6 =>
  array (
    ':region' => '@region@',
    ':title' => 'Integratie verschillende regels voor chemische stoffen',
    ':vote_date' => 1171839600,
    ':summary' => 'Integratie van verschillende regels voor chemische stoffen. De bepalingen van de Wet milieugevaarlijke stoffen moeten worden overgeheveld naar de Wet milieubeheer. ',
    ':code' => 'I731W30600K2',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  7 =>
  array (
    ':region' => '@region@',
    ':title' => 'Technische wijzigingen pensioenwet politici',
    ':vote_date' => 1174860000,
    ':summary' => 'Aanpassing van de pensioenwet voor politici aan de nieuwe algemene pensioenwet die binnenkort ingaat. ',
    ':code' => 'I732W30898K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  8 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen maximumtermijn bijzondere maatregelen',
    ':vote_date' => 1174860000,
    ':summary' => 'De minister mag personen waarvan het vermoeden bestaat dat zij een bedreiging kunnen zijn voor de nationale veiligheid vrijheidsbeperkende maatregelen opleggen voor een periode van maximaal twee jaar. Dit maximum van twee jaar moet komen te vervallen.  ',
    ':code' => 'I733W30566K12',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  9 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen opzettelijk',
    ':vote_date' => 1174860000,
    ':summary' => '\'Opzettelijk handelen\' in strijd met de vrijheidsbeperkende maatregelen die de Minister heeft opgelegd aan personen die een gevaar zouden kunnen voor de nationale veiligheid is strafbaar. Het woord \'opzettelijk\' dient te vervallen, ieder handelen in strijd met de maatregelen moet strafbaar zijn. ',
    ':code' => 'I734W30566K10',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  10 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging maximale gevangenisstraf op overtreden vrijheidsbeperkende maatregelen',
    ':vote_date' => 1174860000,
    ':summary' => 'De gevangenisstraf die staat op het overtreden van de vrijheidsbeperkende maatregelen die de minister kan opleggen aan personen die een gevaar vormen voor de nationale veiligheid moet veranderd worden van maximaal ?�?�n jaar naar minimaal ?�?�n en maximaal vier jaar. ',
    ':code' => 'I735W30566K11',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  11 =>
  array (
    ':region' => '@region@',
    ':title' => 'Introductie vrijheidsbeperkende maatregelen in eerste instantie tijdelijk',
    ':vote_date' => 1174860000,
    ':summary' => 'De wet die de Minister de mogelijkheid geeft om personen die een gevaar kunnen vormen voor de nationale veiligheid vrijheidsbeperkingen op te leggen dient voor vijf jaar in plaats van voor onbeperkte tijd in werking te treden. Na deze vijf jaar kan de wet worden verlengd. ',
    ':code' => 'I736W30566K8',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  12 =>
  array (
    ':region' => '@region@',
    ':title' => 'Extra bepaling die duur wet inperkt',
    ':vote_date' => 1174860000,
    ':summary' => 'De wet die de Minister de mogelijkheid geeft om personen die een gevaar kunnen vormen voor de nationale veiligheid vrijheidsbeperkingen op te leggen dient tot 1 januari 2012 in plaats van voor onbepaalde tijd te gelden. Deze bepaling kan door de minister worden opgeheven. Het voornemen tot het opheffen van deze bepaling dient vier weken van te voren aan de Tweede en Eerste Kamer te worden voorgelegd. ',
    ':code' => 'I737W30566K13',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'voor',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  13 =>
  array (
    ':region' => '@region@',
    ':title' => 'Introductie vrijheidsbeperkende maatregelen',
    ':vote_date' => 1174860000,
    ':summary' => 'Introductie vrijheidsbeperkende maatregelen: Aan personen die een gevaar voor de staatsveiligheid kunnen zijn moeten door de Minister vrijheidsbeperkende maatregelen kunnen worden opgelegd. Deze vrijheidsbeperkende maatregelen zijn: het verbod om op bepaalde plaatsen in Nederland te komen; het verbod om bij bepaalde mensen in de buurt te komen; het zich op vaste tijdstippen melden bij de politie. ',
    ':code' => 'I738W30566K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  14 =>
  array (
    ':region' => '@region@',
    ':title' => 'Geen letterlijke vertaling maar getrouwe vertaling',
    ':vote_date' => 1174860000,
    ':summary' => 'Wanneer stukken die verplicht in openbare registers moeten worden ingeschreven in een vreemde taal zijn gesteld, dient een be?�digd vertaler het stuk letterlijk in het Nederlands te vertalen. De woorden \'letterlijke vertaling\' dienen vervangen te worden \'getrouwe vertaling\'. ',
    ':code' => 'I739W29936K28',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  15 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging maximale gevangenisstraf schending beroepsgeheim door tolken',
    ':vote_date' => 1174860000,
    ':summary' => 'De maximale gevangenisstraf voor tolken die ingeschreven staan in het register waar justitie en politie hun tolken uit kunnen halen, die het ambts- of beroepsgeheim opzettelijk schenden dient verhoogd te worden van ?�?�n naar vier jaar. Ook dient het mogelijk om deze persoon in voorlopige hechtenis te nemen. ',
    ':code' => 'I740W29936K29',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  16 =>
  array (
    ':region' => '@region@',
    ':title' => 'Introductie register tolken voor justitie en politie',
    ':vote_date' => 1174860000,
    ':summary' => 'Er dient een centraal register te komen van tolken die ingezet kunnen
worden bij rechtszaken en politiezaken. Justitie en Politie wordt
verplicht ?�?�n van de tolken uit dit register te gebruiken. De minister
stelt de kwaliteitseisen op voor deze tolken.
',
    ':code' => 'I741W29936K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  17 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen vervroegde invrijheidstelling',
    ':vote_date' => 1174860000,
    ':summary' => 'De mogelijkheid om gevangen vervroegd vrij te laten (met of zonder voorwaarden) moete helemaal komen te vervallen. ',
    ':code' => 'I742W30513K11',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  18 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen reden tekort aan cellen voor vervroegde vrijlating',
    ':vote_date' => 1174860000,
    ':summary' => 'De mogelijkheid voor de Minister van Justitie om gevangen eerder vrij te laten in verband met een tekort aan cellen (capaciteitstekort) moeten komen te vervallen. ',
    ':code' => 'I743W30513K9',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  19 =>
  array (
    ':region' => '@region@',
    ':title' => 'Openbaar Ministerie dient te beslissen over voorwaarden vervroegde invrijheidstelling',
    ':vote_date' => 1174860000,
    ':summary' => 'De mogelijkheid die de wet biedt om het nemen van beslissingen over de voorwaarden die worden gesteld bij het vervroegd in vrijlating stellen van gevangen over te dragen aan de Dienst Justiti?�le Inrichtingen moet komen te vervallen. Alleen het Openbaar Ministerie moet hierover kunnen beslissen. De Dienst Justiti?�le Inrichtingen en de reclassering moeten slechts advies kunnen geven. ',
    ':code' => 'I744W30513K8',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  20 =>
  array (
    ':region' => '@region@',
    ':title' => 'Omvorming vervroegde invrijheidstelling tot voorwaardelijke invrijheidstelling',
    ':vote_date' => 1174860000,
    ':summary' => 'De vervroegde invrijheidsstelling (het vrijlaten van gevangen nadat zij twee derde van hun straf hebben uitgezteen) wordt vervangen door een voorwaardelijke invrijheidstelling. Dit betekent dat er voorwaarden aan het vrijlaten van een gevangene kunnen worden gesteld en dat indien men zich niet aan deze voorwaarden houdt, de vrijlating kan worden ingetrokken. ',
    ':code' => 'I745W30513K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  21 =>
  array (
    ':region' => '@region@',
    ':title' => 'Geen maximale termijn voorwaardelijke be?�indiging TBS',
    ':vote_date' => 1175464800,
    ':summary' => 'Er dient geen maximum te zijn aan het aantal jaar dat er voorwaarden gesteld kunnen worden bij een voorwaardelijke be?�indiging van TBS. ',
    ':code' => 'I746W28238K8',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  22 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging maximumtermijn voorwaardelijke be?�indiging TBS',
    ':vote_date' => 1175464800,
    ':summary' => 'Het maximaal aantal jaar dat er voorwaarden gesteld kunnen worden aan een be?�indiging van TBS dient verhoogd te worden van 9 naar 15 jaar. ',
    ':code' => 'I747W28238K9',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  23 =>
  array (
    ':region' => '@region@',
    ':title' => 'Gelding voor TBS\'ers die al voorwaardelijk vrij zijn',
    ':vote_date' => 1175464800,
    ':summary' => 'Het wetsvoorstel dat het maximaal aantal jaar dat er voorwaarden gesteld kunnen worden aan een be?�indiging van TBS verhoogt dient ook te gelden voor TBS\'ers die nu al voorwaardelijk vrij zijn. ',
    ':code' => 'I748W28238K12',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  24 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhoging maximale duur voorwaardelijke be?�indiging TBS',
    ':vote_date' => 1175464800,
    ':summary' => 'Het maximaal aantal jaar dat er voorwaarden gesteld kunnen worden aan een be?�indiging van TBS dient verhoogd te worden van drie naar negen jaar. ',
    ':code' => 'I749W28238K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  25 =>
  array (
    ':region' => '@region@',
    ':title' => 'Leerplichtambtenaar dient onderwijsinspectie te volgen',
    ':vote_date' => 1176069600,
    ':summary' => 'Een leerplichtambtenaar dient het oordeel van de onderwijsinspectie over een particuliere school te volgen. Zo kunnen zij niet tot een ander oordeel komen. ',
    ':code' => 'I750W30652K13',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  26 =>
  array (
    ':region' => '@region@',
    ':title' => 'Particuliere basisschool dient binnen vier weken kennis te geven van oprichting',
    ':vote_date' => 1176069600,
    ':summary' => 'Nieuwe particuliere scholen voor basisonderwijs dienen binnen vier weken de Minister op de hoogte te stellen van de oprichting. ',
    ':code' => 'I751W30652K11',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  27 =>
  array (
    ':region' => '@region@',
    ':title' => 'Particuliere scholen',
    ':vote_date' => 1176069600,
    ':summary' => 'Particuliere scholen moeten de mogelijkheid hebben om als school voor de leerplicht te worden aangemerkt. Er dienen algemene regels op te worden gesteld waar deze scholen aan moeten voldoen. ',
    ':code' => 'I752W30652K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  28 =>
  array (
    ':region' => '@region@',
    ':title' => 'Uitbreiding bevoegdheid leerplichtambtenaren',
    ':vote_date' => 1176674400,
    ':summary' => 'Alle leerplichtambtenaren dienen wettelijk opsporingsbevoegdheid te hebben voor alle leerlingen dien in Nederland wonen. ',
    ':code' => 'I753W30901K8',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  29 =>
  array (
    ':region' => '@region@',
    ':title' => 'Invoering kwalificatieplicht en leerwerkplicht',
    ':vote_date' => 1176674400,
    ':summary' => 'De parti?�le leerplicht voor jongeren tussen de 16 en 18 jaar moeten worden vervangen door een kwalificatieplicht. Deze jongeren hebben een leerplicht totdat zij een startkwalificatie hebben gehaald (minimaal MBO-2, HAVO of VWO diploma). Ook moet een leerwerkplicht worden ingesteld. Jongeren tot 23 jaar worden verplicht of te werken of te studeren. ',
    ':code' => 'I754W30901K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  30 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wederzijdse erkenning geldelijke en strafrechtelijke sancties',
    ':vote_date' => 1176674400,
    ':summary' => 'Landen van de Europese Unie dienen de geldelijke en strafrechtelijke sancties die door een rechter in een ander land zijn opgelegd, in het eigen land te erkennen en uit te voeren in het geval de veroordeelde in het land woont of daar bezittingen heeft. ',
    ':code' => 'I755W30699K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  31 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen vestigingswet bedrijven',
    ':vote_date' => 1176674400,
    ':summary' => 'De vestigingswet bedrijven dient te vervallen. Dit betekent dat die categorie?�n bedrijven waarvoor nog een vergunning nodig was, niet langer een vergunning nodig hebben om zich te vestigen. ',
    ':code' => 'I756W30828K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  32 =>
  array (
    ':region' => '@region@',
    ':title' => 'Benoemingscode bestuur Kamer van Koophandel',
    ':vote_date' => 1176674400,
    ':summary' => 'De minister dient een benoemingscode op te stellen voor de besturen van de Kamers van Koophandel, waardoor moeilijk organiseerbare groepen zoals ZZP\'ers, vrouwelijke ondernemers, allochtone ondernemers en innovatieve bedrijven in elk geval vertegenwoordigd zijn in het bestuur. ',
    ':code' => 'I757W30857K8',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  33 =>
  array (
    ':region' => '@region@',
    ':title' => 'Snelle evaluatie nieuwe taken KvK',
    ':vote_date' => 1176674400,
    ':summary' => 'De nieuwe wettelijke taken die de Kamers van Koophandel krijgen, regiostimulering en voorlichting, dienen binnen twee jaar geevalueerd te worden. ',
    ':code' => 'I758W30857K10',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  34 =>
  array (
    ':region' => '@region@',
    ':title' => 'Beleggingsinstellingen en vastgoed',
    ':vote_date' => 1177279200,
    ':summary' => 'Het moet voor beleggingsinstellingen mogelijk zijn om vastgoed dat al in de portefeuille zit te ontwikkelen of nieuw vastgoed te verwerven. Als deze activiteiten zich in een dochterbedrijf afspelen, mag de beleggingsinstelling onder het 0% voor de vennootschapsbelasting blijven vallen. Het dochterbedrijf wordt wel belast. ',
    ':code' => 'I759W30689K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  35 =>
  array (
    ':region' => '@region@',
    ':title' => 'Voorschriften dieproductie',
    ':vote_date' => 1177279200,
    ':summary' => 'Nieuwe voorschriften voor dierproducten niet bestemd voor menselijke consumptie. ',
    ':code' => 'I760W30568K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  36 =>
  array (
    ':region' => '@region@',
    ':title' => 'Binnenvaartwet',
    ':vote_date' => 1177279200,
    ':summary' => 'De binnenschepenwet, de wet vervoer binnenvaart en de wet vaartijden en bemanningssterkte binnenvaart dienen vervangen te worden door ?�?�n nieuwe Binnenvaartwet. ',
    ':code' => 'I761W30523K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  37 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verlaging maximaal toegestane concentratie op twee markten',
    ':vote_date' => 1177884000,
    ':summary' => 'De maximale toegestane marktconcentratie van media op ?�?�n markt (televisie, radio of dagbladen) is 35%. Het maximale opgetelde marktaandeel van de drie markten van een bedrijf dat op twee of alle drie de markten actief is, is 90%. Voor een bedrijf dat op twee markten actief is, moet dit maximale percentage verlaagd worden naar 65%. ',
    ':code' => 'I762W30921K8',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen,niet aanwezig',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  38 =>
  array (
    ':region' => '@region@',
    ':title' => 'Opheffing verbod op crossownership media',
    ':vote_date' => 1177884000,
    ':summary' => 'Het verbod op het zich begeven op meer dan ?�?�n markt op het gebied van media (radio, televisie of dagbladen) vervalt, crossownership wordt toegestaan. De maximale toegestane marktconcentratie van media op ?�?�n markt (televisie, radio of dagbladen) wordt 35%. Het maximale opgetelde marktaandeel van de drie markten van een bedrijf dat op twee of alle drie de markten actief is, wordt 90%. ',
    ':code' => 'I763W30921K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  39 =>
  array (
    ':region' => '@region@',
    ':title' => 'Extra studiefinanciering voor eerstegraads docentenopleiding',
    ':vote_date' => 1180303200,
    ':summary' => 'Zij-instromers die tweedegraads docentenbevoegdheid hebben gehaald, dienen een jaar extra studiefinanciering te krijgen indien zij hierna de opleiding tot eerstegraads docent willen volgen.
',
    ':code' => 'I764W30971K13',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  40 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verlenen toevoeging \'of Arts\' en \'of Science\'',
    ':vote_date' => 1180303200,
    ':summary' => 'Het moet voor wetenschappelijke post-initi?�le opleidingen mogelijk zijn om de toevoeging \'of Arts\' of \'of Science\' te verlenen bij de Masterstitel.',
    ':code' => 'I765W30971K12',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  41 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging verschillende wetten onderwijs',
    ':vote_date' => 1180303200,
    ':summary' => 'Verschillende wijzigingen wetten onderwijs. Uitbreiding van de mogelijkheden om met studiefinanciering bepaalde lerarenopleidingen te volgen (zij-instromers). Introductie van de graad \'Associate Degree\' voor de gelijknamige HBO-opleidingen. ',
    ':code' => 'I766W30971K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  42 =>
  array (
    ':region' => '@region@',
    ':title' => 'Mogelijkheid verplichting vooraf verstrekken passagiersgegevens aan douane',
    ':vote_date' => 1180303200,
    ':summary' => 'Introductie van de mogelijkheid om vervoerders te verplichten gegevens te te verstrekken aan de grensbewaking. Uitvoering van de Europese richtlijn die regelt dat luchtvervoerders verplicht kunnen worden vooraf passagiersgegevens te verstrekken aan de douane. ',
    ':code' => 'I767W30897K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'immigratie en integratie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  43 =>
  array (
    ':region' => '@region@',
    ':title' => 'Klachtenregeling postbedrijven',
    ':vote_date' => 1181512800,
    ':summary' => 'Een postvervoerbedrijf dient wettelijk verplicht te zijn een klachtenprocedure te hebben. ',
    ':code' => 'I768W30536K25',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  44 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen mogelijkheid regels minister over arbeidsvoorwaarden postsector',
    ':vote_date' => 1181512800,
    ':summary' => 'De mogelijkheid dat de minister regels stelt over de arbeidsvoorwaarden in de postsector indien er tegen sociaal onaanvaardbare arbeidsvoorwaarden arbeid wordt verricht en dit een tijdelijk probleem is dat zich beperkt tot de postsector, moet komen te vervallen. ',
    ':code' => 'I769W30536K53',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  45 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verplichting dienstverband',
    ':vote_date' => 1181512800,
    ':summary' => 'Postvervoersbedrijven moeten voor het bezorgen van poststukken alleen gebruik mogen maken van mensen die een dienstverband hebben. Dus niet van mensen die bijvoorbeeld in opdracht werken. ',
    ':code' => 'I770W30536K52',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  46 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verkorting termijn evaluatie',
    ':vote_date' => 1181512800,
    ':summary' => 'De toegang van nieuwe postbedrijven na de liberalisering van de postmarkt dient door de OPTA na ?�?�n in plaats van na twee jaar ge?�valueerd te worden. ',
    ':code' => 'I771W30536K53',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  47 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verhuizen melden bij ?�?�n postbedrijf',
    ':vote_date' => 1181512800,
    ':summary' => 'Het moet mogelijk zijn om op ?�?�n plek een adreswijziging of melding tijdelijke stopzetting postbezorging  te kunnen doen. Een ieder die een systeem beheert met gegevens over verhuizing of tijdelijke stopzetting dient deze informatie tegen redelijke tarieven aan postbedrijven beschikbaar te stellen.
',
    ':code' => 'I772W30536K39',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  48 =>
  array (
    ':region' => '@region@',
    ':title' => 'Afhandelen post ander postbedrijf',
    ':vote_date' => 1181512800,
    ':summary' => 'Wanneer een poststuk terecht komt in de poststroom van een ander postvervoerbedrijf dan waar het poststuk is aangeboden, dient deze post binnen redelijke termijn afgehandeld te worden.  ',
    ':code' => 'I773W30536K16',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  49 =>
  array (
    ':region' => '@region@',
    ':title' => 'Voorhangprocedure',
    ':vote_date' => 1181512800,
    ':summary' => 'De regels die de minister stelt over de geliberaliseerde postmarkt dienen eerst aan de Eerste en Tweede Kamer voorgelegd te worden. ',
    ':code' => 'I774W30536K38',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  50 =>
  array (
    ':region' => '@region@',
    ':title' => 'Opnemen normen postbedrijven',
    ':vote_date' => 1181512800,
    ':summary' => 'Regels voor postbedrijven over het aantal bezorgdagen (zes), overkomstduur (95% de volgende dag) en aantal dienstverleningspunten (minimaal 2000) en brievenbussen (binnen straal 0,5km, in landelijk gebied binnen straal 2,5km) dienen in de wet te worden opgenomen, in plaats van de de minister dit mag regelen. ',
    ':code' => 'I775W30536K40',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  51 =>
  array (
    ':region' => '@region@',
    ':title' => 'Gelijk blijven aantal brievenbussen',
    ':vote_date' => 1181512800,
    ':summary' => 'Een postbedrijf dat een universele postdienst levert (zoals nu de TNT)dient ervoor te zorgen dat het aantal brievenbussen gelijk blijft aan het aantal op 1 januari 2007. ',
    ':code' => 'I776W30536K41',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  52 =>
  array (
    ':region' => '@region@',
    ':title' => 'Boekhoudkundige scheiding universele postdienst en andere activiteiten',
    ':vote_date' => 1181512800,
    ':summary' => 'TNT en later andere aanbieders van universele postdiensten dienen verplicht te worden om boekhoudkundige de kosten en opbrensten universele postdienst en kosten en opbrengsten andere activiteiten te scheiden.
',
    ':code' => 'I777W30536K35',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  53 =>
  array (
    ':region' => '@region@',
    ':title' => 'Redelijk tarief  universele postdienst',
    ':vote_date' => 1181512800,
    ':summary' => 'Het bedrijf dat de de minister wordt aangewezen om een universele postdienst aan te bieden (wat nu de TNT doet), dient dit tegen een redelijk (kosten + redelijk rendement) tarief te doen. ',
    ':code' => 'I778W30536K50',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  54 =>
  array (
    ':region' => '@region@',
    ':title' => 'Liberalisering postmarkt',
    ':vote_date' => 1181512800,
    ':summary' => 'Laatste deel van de liberalisering van de postmarkt. Postmarkt wordt nu voor alle poststukken (ook brieven) geliberaliseerd. In de wet is zijn een aantal minimumnormen opgenomen en is opgenomen dat de minister regels mag stellen over de arbeidsvoorwaarden van postbodes. De minister wijst ?�?�n postbedrijf aan dat een universele postdienst dient te voeren (iedere hoeveelheid post, naar iedere plek).  ',
    ':code' => 'I779W30536K2',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  55 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet markttoezicht registerloodsen',
    ':vote_date' => 1181512800,
    ':summary' => 'Invoering van specifiek markttoezicht op loodswezen. Tarieven dienen aan kosten gerelateerd te zijn om zo kruissubsidi?�ring tussen verschillende scheepsklassen en regio\'s te voorkomen.  ',
    ':code' => 'I780W30913K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  56 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijzigingen wet veiligheidsonderzoeken.',
    ':vote_date' => 1181512800,
    ':summary' => 'In de Wet veiligheidsonderzoeken is onder andere geregeld dat werkgevers die mensen in dienst nemen op functies die de nationale veiligheid zouden kunnen schaden (bijv. beveiliger schiphol) dient aan de AIVD dient te melden. In deze procedure worden aantal kleine wijzigingen doorgevoerd, zoals de definitie van het begrip werkgever, de informatie die doorgegeven moet worden. ',
    ':code' => 'I781W30805K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  57 =>
  array (
    ':region' => '@region@',
    ':title' => 'Echtscheiding zonder tussenkomst rechter',
    ':vote_date' => 1182117600,
    ':summary' => 'Echtgenoten die geen kinderen hebben moeten zonder tussenkomst van de rechter kunnen scheiden. ',
    ':code' => 'I782W30145K23',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  58 =>
  array (
    ':region' => '@region@',
    ':title' => 'Ouderschapsplan alleen voor gezamenlijke kinderen',
    ':vote_date' => 1182117600,
    ':summary' => 'Het verplicht opstellen van een ouderschapsplan bij een scheiding dient alleen te gelden voor gezamenlijke kinderen, voor kinderen waarover slechts ?�?�n van de echtgenoten het ouderlijk gezag heeft (bijvoorbeeld een kind uit een vorige relatie) dient geen ouderschapsplan opgesteld te worden.  ',
    ':code' => 'I783W30145K19',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  59 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wettelijke norm recht op opvoeding door beide ouders na scheiding',
    ':vote_date' => 1182117600,
    ':summary' => 'In de wet dient de norm opgenomen te worden dat een kind na een scheiding recht heeft op een gelijkwaardige verzorging en opvoeding door beide ouders. ',
    ':code' => 'I784W30145K26',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  60 =>
  array (
    ':region' => '@region@',
    ':title' => 'Ouderschapsplan ook voor niet-gehuwden die uit elkaar gaan',
    ':vote_date' => 1182117600,
    ':summary' => 'Het opstellen van een ouderschapsplan dient ook verplicht te zijn voor niet-getrouwde stellen met kinderen die uit elkaar gaan. ',
    ':code' => 'I785W30145K24',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  61 =>
  array (
    ':region' => '@region@',
    ':title' => 'Snelle behandeling door rechter bij niet-naleving ouderschapsplan',
    ':vote_date' => 1182117600,
    ':summary' => 'Indien een van de ouders de afspraken uit het ouderschapsplan niet nakomt, dient de rechter deze zaak binnen twee weken te behandelen, in plaats van de voorgeschreven zes weken. ',
    ':code' => 'I786W30145K15',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  62 =>
  array (
    ':region' => '@region@',
    ':title' => 'Introductie verplicht ouderschapsplan',
    ':vote_date' => 1182117600,
    ':summary' => 'Afschaffing van de flitsscheiding en introductie van verplicht ouderschapsplan voor gehuwden met kinderen die gaan scheiden.',
    ':code' => 'I787W30145K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  63 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verdrag van Pr?�m',
    ':vote_date' => 1182117600,
    ':summary' => 'Goedkeuring Verdrag van Pr?�m, dat een intensivering van samenwerking in het bestrijden van terrorisme en de illegale migratie regelt tussen Nederland, Belgi?�, Duitsland, Spanje,  Frankrijk, Luxemburg en Oostenrijk.  ',
    ':code' => 'I788W30881K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  64 =>
  array (
    ':region' => '@region@',
    ':title' => 'Beperking activiteiten medisch zorgteam',
    ':vote_date' => 1182722400,
    ':summary' => 'De bedrijfsarts activiteiten van een medisch zorgteam bij defensie dienen beperkt te blijven tot inzetbaarheid, belastbaarheid en re-integratie. Andere activiteiten dienen bij het ARBO-team terecht te komen.
',
    ':code' => 'I789W30674K12',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  65 =>
  array (
    ':region' => '@region@',
    ':title' => 'Internationale missie alleen bij volkenrechtelijk mandaat',
    ':vote_date' => 1182722400,
    ':summary' => 'Nederlandse militairen mogen alleen voor internationale missies worden ingezet indien voor deze missie een volkenrechtelijk mandaat is gegeven. ',
    ':code' => 'I790W30674K15',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  66 =>
  array (
    ':region' => '@region@',
    ':title' => 'Regeling ontslag militairen',
    ':vote_date' => 1182722400,
    ':summary' => 'Militaire dienen alleen ontslagen te kunnen worden indien zij minimaal een beroepsopleiding hebben afgerond of een vervangende arbeidsplaats hebben.  ',
    ':code' => 'I791W30674K16',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  67 =>
  array (
    ':region' => '@region@',
    ':title' => 'Terugkoppeling naar eigen arts',
    ':vote_date' => 1182722400,
    ':summary' => 'Wanneer een militair naar een andere arts gaat dan zijn eigen arts binnen het leger, heeft hij alleen de verplichting om dit te melden
wanneer het gaat om zaken die direct in verband staan met inzetbaarheid, belastbaarheid en re-integratie.
',
    ':code' => 'I792W30674K14',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  68 =>
  array (
    ':region' => '@region@',
    ':title' => 'Militair personeel',
    ':vote_date' => 1182722400,
    ':summary' => 'Wijziging van de Militaire ambtenarenwet. Rechten en plichten van ambtenaren wordt opnieuw vastgelegd. De mogelijkheid wordt gecre?�erd om regels te stellen ter bevordering van de instroom, doorstroom en uitstroom van militairen. Zo wordt het mogelijk om een leeftijdsgrens te stellen voor bepaalde functies. De wet voor het reservepersoneel der Krijgsmacht wordt ingetrokken. ',
    ':code' => 'I793W30674K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  69 =>
  array (
    ':region' => '@region@',
    ':title' => 'Geen Turks of Arabisch als vak op VMBO',
    ':vote_date' => 1182722400,
    ':summary' => 'Op het VMBO mag niet het vak Turks of Arabisch worden aangeboden in de vrije ruimte. ',
    ':code' => 'I794W30988K9',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  70 =>
  array (
    ':region' => '@region@',
    ':title' => 'Aanpassing examenvoorschriften VMBO',
    ':vote_date' => 1182722400,
    ':summary' => 'Aanpassing examenvoorschriften VMBO. Gymnastiek en Fries mogen voortaan als vak worden aangeboden in de vrije keuzeruimte. De school mag de mogelijkheid bieden aan VMBO leerlingen om bepaalde vakken op een hoger kwalificatieniveau dan de eigen leerweg aan te bieden. ',
    ':code' => 'I795W30988K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  71 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verruiming gedragsbe?�nvloeding jeugdige criminelen',
    ':vote_date' => 1182722400,
    ':summary' => 'Verruiming van de mogelijkheden tot gedragsbe?�nvloeding van jeugdigen die strafbare feiten hebben begaan. Introductie van de mogelijkheid om een gedragprogramma op te leggen aan deze jeugdigen. ',
    ':code' => 'I796W30332K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  72 =>
  array (
    ':region' => '@region@',
    ':title' => 'Verzamelwet vereenvoudiging vergunningen',
    ':vote_date' => 1183327200,
    ':summary' => 'Verzamelwet vereenvoudiging vergunningen. Niet-controversi?�le vereenvoudiging van diverse vergunningen. ',
    ':code' => 'I797W30959K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  73 =>
  array (
    ':region' => '@region@',
    ':title' => 'Spoedprocedure bij onderbreking gas, water, elektriciteit of communicatie',
    ':vote_date' => 1183327200,
    ':summary' => 'In geval van een onderbreking van een essenti?�le dienst (gas, elektriciteit, water, communicatie), dient het informatieuitwisselingssysteem dat voor ondergrondse netwerken geldt in ?�?�n uur in plaats van twee werkdagen doorlopen te kunnen worden. ',
    ':code' => 'I798W30475K30',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  74 =>
  array (
    ':region' => '@region@',
    ':title' => 'Opnemen actueel overzicht alle ondergrondse netten',
    ':vote_date' => 1151791200,
    ':summary' => 'In het kadaster dat informatieuitwisseling regelt over ondergrondse netten (voor gas, water, electriciteit en communicatie), dient  een actueel overzicht van alle liggingsgegevens van een net in de ondergrond opgenomen te worden.
',
    ':code' => 'I799W30475K10',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  75 =>
  array (
    ':region' => '@region@',
    ':title' => 'Juridische eigendomsverhouding sparen en beleggen',
    ':vote_date' => 1189980000,
    ':summary' => 'Voor de berekening van het voordeel uit sparen en beleggen dient, indien een van de partners voor een gedeelte van het jaar niet binnenlands belastingplichtig is, altijd uit te worden gegaan van de juridische eigendomsverhouding en kan niet gekozen worden om het voordeel uit sparen en beleggen automatisch voor de belasting fifty fifty te verdelen over de partners. ',
    ':code' => 'I800W30943K9',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'belastingen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  76 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijzigingen fiscale wetten',
    ':vote_date' => 1189980000,
    ':summary' => 'Technische wijzigingen van diverse fiscale wetten. ',
    ':code' => 'I801W30943K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'belastingen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  77 =>
  array (
    ':region' => '@region@',
    ':title' => 'Lijst van activiteiten met bijzondere maatregelen',
    ':vote_date' => 1190584800,
    ':summary' => 'Er dient door de minister een lijst van activiteiten die indien zij milieuschade veroorzaken, vallen onder de bijzondere maatregelen die in de wet milieubeheer zijn opgenomen, opgesteld te worden, naast als aanvulling op de EU-lijst van deze activiteiten.  Deze lijst dient eerst aan de Eerste en Tweede Kamer voorgelegd te worden. ',
    ':code' => 'I802W30920K17',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'voor',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  78 =>
  array (
    ':region' => '@region@',
    ':title' => 'Geen vergoeding milieuschade bij houden aan vergunning',
    ':vote_date' => 1190584800,
    ':summary' => 'Indien men zich aan de voorschriften van de milieuvergunning heeft gehouden of milieuschade op grond van de technische kennis niet had kunnen voorzien, dient men niet aansprakelijk te zijn voor de kosten van milieuschade. ',
    ':code' => 'I803W30920K8',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  79 =>
  array (
    ':region' => '@region@',
    ':title' => 'Milieuaansprakelijkheid',
    ':vote_date' => 1190584800,
    ':summary' => 'Implementatie van Europese regelgeving over milieuaansprakelijkheid. Het bdrijf dient preventieve of
herstelmaatregelen te treffen wanneer schade ontstaat of dreigt te ontstaan.De kosten voor de maatregelen komen voor zijn rekening. De overheid is verplicht tot het voorschrijven van preventieve of herstelmaatregelen. De over kan ook altijd zelf de nodige maatregelen nemen.In dat geval worden de kosten verhaald op het bedrijf.
',
    ':code' => 'I804W30920K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  80 =>
  array (
    ':region' => '@region@',
    ':title' => 'Regeling internationaal eigendosmvoorbehoud',
    ':vote_date' => 1190584800,
    ':summary' => 'De juridische gevolgen van een eigendomsvoorbehoud worden bepaald door het recht van het land waar de levering plaatsvindt. Partijen kunnen echter ook kiezen voor het recht van bestemming indien dit recht voor de schuldeiser gunstigere bepalingen bevat. Deze eis dient vervangen te worden door de eis dat op grond van dit recht het eigendomsvoorbehoud niet vervalt totdat de volledige prijs is betaald. ',
    ':code' => 'I805W30876K12',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  81 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet conflictenrecht goederenrecht',
    ':vote_date' => 1190584800,
    ':summary' => 'Invoering van een Wet conflictenrecht goederenrecht. Deze wet regelt de juridische gevolgen van internationale rechtshandelingen voor onder andere eigendom, vorderingsrechten, aandelen en giraal overdraagbare effecten.
',
    ':code' => 'I806W30876K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  82 =>
  array (
    ':region' => '@region@',
    ':title' => 'Voorwaarden opheffing huisverbod',
    ':vote_date' => 1190584800,
    ':summary' => 'De opheffing van een huisverbod door de burgemeester voor een geweldadige partner kan alleen worden opgeheven wanneer de uithuisgeplaatste niet alleen zelf hulp heeft aanvaard, maar ook de hulpverlening aan de achtergebleven partner en kinderen niet zal belemmeren.  ',
    ':code' => 'I807W30657K9',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  83 =>
  array (
    ':region' => '@region@',
    ':title' => 'Evaluatie Wet tijdelijk huisverbod',
    ':vote_date' => 1190584800,
    ':summary' => 'De wet tijdelijk huisverbod voor geweldadige partners dient al na ?�?�n jaar in plaats van na vier jaar ge?�valueerd te worden. ',
    ':code' => 'I808W30657K11',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  84 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet tijdelijk huisverbod',
    ':vote_date' => 1190584800,
    ':summary' => 'Invoering van een wet tijdelijk huisverbod. Deze wet maakt het mogelijk dat een burgemeester een geweldadige partner tijdelijk uit huis plaatst. ',
    ':code' => 'I809W30657K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  85 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging wet op de rechtsbijstand.',
    ':vote_date' => 1190584800,
    ':summary' => 'Wijziging van de Wet op de rechtsbijstand. De bureaus voor rechtshulp worden opgeheven. De raden voor de rechtsbijstand richten een nieuwe stichting op,\'het juridisch loket\'. De bureaus kunnen opgaan in deze stichting of zich als zelfstandig advocatenkantoor vestigen. Eerstelijns juridisch advies wordt voor mensen met lage inkomens door deze loketten gegeven. Ook komt er een mogelijkheid tot vergoeding van mediation (conflictbemiddeling). ',
    ':code' => 'I810W30436K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  86 =>
  array (
    ':region' => '@region@',
    ':title' => 'Informatieuitwisseling werk en inkomen',
    ':vote_date' => 1190584800,
    ':summary' => 'Welke overheidsinstanties op het gebied van werk en inkomen verplicht zijn gegevens uit te wisselen (in plaats van ze opnieuw aan de burger te vragen) dient vastgelegd te worden door de minster en aan de Tweede Kamer voorgelegd te worden.  ',
    ':code' => 'I811W30970K18',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  87 =>
  array (
    ':region' => '@region@',
    ':title' => 'Inzage opgenomen gegevens en correctierecht',
    ':vote_date' => 1190584800,
    ':summary' => 'De overheidsinstellingen op het gebied van werk en inkomen zullen meer gegevens uitwisselen en minder vaak gegevens vragen aan een burger.De minister dient regels te stellen over een inzagerecht, een mogelijkheid voor de betrokkene om de gegevens de corrigeren en om bij een geschil over de gegevens dit voor te leggen aan een onafhankelijke instantie. ',
    ':code' => 'I812W30970K17',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  88 =>
  array (
    ':region' => '@region@',
    ':title' => 'Evaluatie',
    ':vote_date' => 1190584800,
    ':summary' => 'De wet die regelt dat overheidsinstellingen op het gebied van werk en inkomen meer gegevens moeten uitwisselen en minder vaak gegevens vragen aan een burger, moet binnen twee jaar ge?�valueerd te worden. ',
    ':code' => 'I813W30970K11',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  89 =>
  array (
    ':region' => '@region@',
    ':title' => 'Informatieuitwisseling werk en inkomen',
    ':vote_date' => 1190584800,
    ':summary' => 'Overheidsinstellingen op het gebied van werk en inkomen mogen in principe niet vaker dan ?�?�n keer de gegevens van een burger te vragen. Zijn dienen te gegevens vervolgens uit te wisselen. ',
    ':code' => 'I814W30970K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  90 =>
  array (
    ':region' => '@region@',
    ':title' => 'Voorhangprocedure',
    ':vote_date' => 1190584800,
    ':summary' => 'Nieuwe regels over informatieuitwisseling tussen overheidsinstellingen op het gebied van werk en inkomen dienen eerst aan de Eerste en Tweede Kamer voorgelegd te worden. ',
    ':code' => 'I815W30970K9',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  91 =>
  array (
    ':region' => '@region@',
    ':title' => '\'Open end\' beleggingsinstelling',
    ':vote_date' => 1191794400,
    ':summary' => 'Ook de \'open end\' beleggingsinstelling dient onder de nieuwe regels voor grensoverschrijdende fusies van NV\'s en BV\'s te vallen.  ',
    ':code' => 'I816W30929K11',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  92 =>
  array (
    ':region' => '@region@',
    ':title' => 'Grensoverschrijdende fusies kapitaalvennootschappen',
    ':vote_date' => 1191794400,
    ':summary' => 'Invoering van Europese regels over grensoverschrijdende fusies van kapitaalvennootschappen (NV\'s en BV\'s). ',
    ':code' => 'I817W30929K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  93 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging Brandweerwet',
    ':vote_date' => 1191794400,
    ':summary' => 'Wijziging van de Brandweerwet 1985. De minister kan voortaan regels stellen over het opleiden, examineren, bijscholen en oefenen van brandweer en vrijwillige brandweer. Het Nederlands instituut voor brandweer en rampenbestrijding wordt het Nederlands instituut fysieke veiligheid en krijgt voortaan ook het onderzoek naar  geneeskundige hulpverlening bij rampen als taak. ',
    ':code' => 'I818W30875K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  94 =>
  array (
    ':region' => '@region@',
    ':title' => 'Regels over uitstoot luchtverontreiniging',
    ':vote_date' => 1193004000,
    ':summary' => 'Een luchthavenbesluit van een provincie (regels van de provincie voor een vliegveld) dient ook steeds grenswaarden of normen voor uitstoot van luchtverontreiniging te bevatten. ',
    ':code' => 'I821W30452K24',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  95 =>
  array (
    ':region' => '@region@',
    ':title' => 'Delegatieverbod luchthavenregeling',
    ':vote_date' => 1193004000,
    ':summary' => 'De bevoegdheid van provinciale staten om een regeling voor een luchthaven vast te stellen mag niet worden gedelegeerd aan een andere organisatie.  ',
    ':code' => 'I820W30452K33',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  96 =>
  array (
    ':region' => '@region@',
    ':title' => 'Omwonenden en milieuorganisaties in luchtvaartcommissies',
    ':vote_date' => 1193004000,
    ':summary' => 'In de commissie regionaal overleg luchthaven die een provincie voor ieder vliegveld dient in te stellen, dient ten minste ?�?�n omwonende ?�?�n milieuorganisatie te zitten. ',
    ':code' => 'I822W30452K40',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'voor',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  97 =>
  array (
    ':region' => '@region@',
    ':title' => 'Luchthavencommissie samenstelling',
    ':vote_date' => 1193004000,
    ':summary' => 'Aannpassing in de vereisten voor de luchthavencommissie die de provincie voor ieder vliegveld dient in te stellen. Het aantal vertegenwoordigers van de gemeente gaat omlaag van drie naar twee. Er wordt verplicht in plaats van optioneel om een vertegenwoordigers van een gebruikersorganisatie en van een milieuorganisatie in de commissie op te nemen. ',
    ':code' => 'I823W30452K42',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  98 =>
  array (
    ':region' => '@region@',
    ':title' => 'Mogelijkheid beroep bij bestuursrechter',
    ':vote_date' => 1193004000,
    ':summary' => 'Tegen een luchthavenbesluit van de provincie over een vliegveld moet beroep bij de bestuursrechter openstaan. ',
    ':code' => 'I824W30452K38',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  99 =>
  array (
    ':region' => '@region@',
    ':title' => 'Voortbestaan nationale regels',
    ':vote_date' => 1193004000,
    ':summary' => 'De nationale regels over sluiting luchthavens, belemmerende objecten en schadeloosstelling dienen te blijven bestaan, in plaats van dit over te laten aan provincies. ',
    ':code' => 'I825W30452K21',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  100 =>
  array (
    ':region' => '@region@',
    ':title' => 'Zelfde regels voor luchthavengroep',
    ':vote_date' => 1193004000,
    ':summary' => 'Voor schiphhol en andere luchthavens gelden andere regels. Indien ?�?�n van deze luchthavens onder Schiphol gaat vallen, dient deze luchthaven onder dezelfde regels als Schiphol te vallen. ',
    ':code' => 'I826W30452K44',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  101 =>
  array (
    ':region' => '@region@',
    ':title' => 'Aanpakken oneerlijke handelspraktijken',
    ':vote_date' => 1194822000,
    ':summary' => 'De Consumentenautoriteit en de Autoriteit Financi?�le Markten moeten alle oneerlijke handelspraktijken bestuursrechtelijk kunnen aanpakken. De voorgestelde wijziging houdt in dat er geen discrepantie meer zal zijn tussen het overtreden van open en gesloten normen.',
    ':code' => 'I827W30928K14',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  102 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'Het schrappen van de mogelijkheid van een persoonsgebonden budget voor werknemers in de sociale werkvoorziening. De werkgever blijft verantwoordelijk voor behoud en verbetering van de arbeidsbekwaamheid.',
    ':code' => 'I828W30673K15',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  103 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'De gemeente moet de wijze van periodiek overleg met de Wsw-ondernemingsraad en andere belanghebbenden (zoals vertegenwoordigers van wsw-geindiceerden) nader vastleggen in een verordening.',
    ':code' => 'I829W30673K18',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'tegen',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  104 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'Het begrip "het aantal wsw-ge?�ndiceerden dat beschikbaar is voor werk in sw-verband" moet duidelijk gedefinieerd worden. Zo wordt voorkomen dat er onderlinge verschillen optreden tussen de lijst met wsw-ge?�ndiceerden van gemeentes.',
    ':code' => 'I830W30673K19',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  105 =>
  array (
    ':region' => '@region@',
    ':title' => 'Aanpak van oneerlijke handelspraktijken',
    ':vote_date' => 1194822000,
    ':summary' => 'Het aanpassen van de wet betreffende oneerlijke handelspraktijken van ondernemingen tegenover consumenten op de interne markt naar Europese richtlijnen. ',
    ':code' => 'I833W30928K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  106 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'Het verplichten van grotere werkgevers om wsw-werknemers in dienst te nemen.',
    ':code' => 'I834W30673K21',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  107 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'Een voorstel tot wijziging van de Wet sociale werkvoorziening op diverse punten. Dit gebeurt in verband met een betere realisering van de met die wet beoogde doelen.',
    ':code' => 'I832W30673K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  108 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet sociale werkvoorziening',
    ':vote_date' => 1194822000,
    ':summary' => 'Het verplichten van gemeenten om binnen 12 maanden aan wsw-ge?�ndiceerden een dienstverband bij het SW-bedrijf aan te bieden. De gemeente kan regels vaststellen om van deze periode af te wijken.',
    ':code' => 'I835W30673K28',
    ':type' => 'amendement',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'tegen',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  109 =>
  array (
    ':region' => '@region@',
    ':title' => 'Richtlijnen minimumnormen Vreemdelingenwet',
    ':vote_date' => 1195426800,
    ':summary' => 'Dit wetsvoorstel betreft een wijziging van een richtlijn in de Vreemdelingenwet. Deze richtlijn voorziet in het vaststellen van minimumnormen voor de erkenning en status van vluchtelingen in brede zin. Het gaat hierbij onder andere om criteria voor de erkenning van vluchtelingen in de zin van het Vluchtelingenverdrag, het wel of niet verlengen van de vluchtelingenstatus en het in aanmerking komen voor bescherming.',
    ':code' => 'I837W30925K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'immigratie en integratie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  110 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging Mijnbouwwet',
    ':vote_date' => 1196031600,
    ':summary' => 'Voorstel tot wijziging van de Mijnbouwwet in verband met nieuwe regels voor een vennootschap waarvan de aandelen direct of indirect in handen zijn van de staat. Deze regels gaan onder andere over de publieke taken van de vennootschap. Tevens zullen de bijzondere positie van de vennootschap en de verhouding tussen haar en de miniser van Economische Zaken transparanter zijn vastgelegd.',
    ':code' => 'I838W31090K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'energie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  111 =>
  array (
    ':region' => '@region@',
    ':title' => 'Nieuwe regels inzake tuchtrechtspraak ten aanzien van accountants',
    ':vote_date' => 1196636400,
    ':summary' => 'Wetsvoorstel voor het stroomlijnen van het tuchtrecht voor accountants en om deze te integreren in ?�?�n wet. Deze wijziging van het tuchtrecht is onderdeel van meerdere wijzingen in de regelgeving voor accountants.',
    ':code' => 'I839W30397K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  112 =>
  array (
    ':region' => '@region@',
    ':title' => 'Heffingsrechten bij omgevingsvergunning',
    ':vote_date' => 1197241200,
    ':summary' => 'Met dit amendement wordt de mogelijkheid gecre?�erd om nadere regels te stellen aan de heffingen die door het bevoegd gezag kunnen worden gegeven. Deze heffingen hebben betrekking op het aanvragen tot verlening of intrekking/wijziging van een omgevingsvergunning.',
    ':code' => 'I840W30844K36',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  113 =>
  array (
    ':region' => '@region@',
    ':title' => 'Amendement Wet algemene bepalingen omgevingsrecht',
    ':vote_date' => 1197241200,
    ':summary' => 'Met dit amendement wordt de mogelijkheid tot inspraak beperkt tot belanghebbenden ofwel diegenen van wie de belangen rechtstreeks bij een besluit zijn betrokken zoals vermeld in de Algemene wet bestuursrecht. Dit amendement heeft betrekking op de Wet algemene bepalingen omgevingsrecht.',
    ':code' => 'I843W30844K16',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  114 =>
  array (
    ':region' => '@region@',
    ':title' => 'Moment van inwerking treden vergunning (inzake Wet algemene bepalingen omgevingsrecht)',
    ':vote_date' => 1197241200,
    ':summary' => 'Met dit amendement treedt een vergunning van rechtswege in werking nadat de bezwaarprocedure is afgerond dan wel dat op ingediende bezwaar is besloten. Dit amendement heeft betrekking op de Wet algemene bepalingen omgevingsrecht.',
    ':code' => 'I844W30844K37',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  115 =>
  array (
    ':region' => '@region@',
    ':title' => 'Amendement bestuurlijke lus (inzake Wet algemene bepalingen omgevingsrecht)',
    ':vote_date' => 1197241200,
    ':summary' => 'Dit amendement dient tot invoering van de zogenaamde bestuurlijke
lus. Hiermee ontstaat de mogelijkheid voor de rechtbank om het bevoegd
gezag in de gelegenheid te stellen om  besluiten die bestreden zijn, weg te nemen. Het gaat hierbij dan om (procedurele) vormfouten of eventuele gebreken, bijvoorbeeld vormfouten en rekenfouten. Dit amendement heeft betrekkin op de Wet algemene bepalingen omgevingsrecht.',
    ':code' => 'I846W30844K39',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  116 =>
  array (
    ':region' => '@region@',
    ':title' => 'Waarborging parlementaire betrokkenheid (inzake Wet algemene bepalingen omgevingsrecht)',
    ':vote_date' => 1197241200,
    ':summary' => 'Dit amendement houdt in dat de voordracht voor een algemene maatregel van bestuur wordt niet eerder gedaan dan vier weken nadat het ontwerp aan beide kamers der Staten-Generaal is
overgelegd. Op deze manier is parlementaire betrokkenheid gewaarborgd. Dit amendement heeft betrekking op de Wet algemene bepalingen omgevingsrecht.',
    ':code' => 'I847W30844K35',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  117 =>
  array (
    ':region' => '@region@',
    ':title' => 'Amendement om Algemene maatregelen van bestuur van voorhang te voorzien (Inzake Wet algemene bepalingen omgevingsrecht)',
    ':vote_date' => 1197241200,
    ':summary' => 'Dit amendement strekt om diverse Algemene maatregelen van bestuur van een voorhang (zogenaamd \'gordijn\') te
voorzien. De voordracht voor een vast te stellen algemene maatregel van bestuur wordt niet eerder gedaan dan vier weken nadat het ontwerp aan beide kamers der Staten-Generaal is overgelegd. Dit amendement heeft betrekking op de Wet algemene bepalingen omgevingsrecht.',
    ':code' => 'I848W30844K34',
    ':type' => 'amendement',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  118 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wetsvoorstel Wet algemene bepalingen omgevingsrecht',
    ':vote_date' => 1197846000,
    ':summary' => 'Dit wetsvoorstel betreft de dienstverlening door de overheid aan burgers en bedrijfsleven. In de wet worden de toestemmingen samengevoegd die nodig zijn als een burger/bedrijf een bepaalde plek wil (ver)bouwen, slopen, oprichten of gaan gebruiken. Het gaat om het integreren van vergunningen, ontheffingen en meldingen tot 1 omgevingsvergunning.',
    ':code' => 'I850W30844K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'tegen',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  119 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen bepaling over uitsluiting wilsonbekwamen van het kiesrecht',
    ':vote_date' => 1197241200,
    ':summary' => 'Met de aanname van dit wetsvoorstel vervalt de bepaling over het uitsluiten van wilsonbekwamen van het kiesrecht zoals vermeld in de Grondwet. Ook wilsonbekwamen krijgen dan het recht om te stemmen. ',
    ':code' => 'I851W31012K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  120 =>
  array (
    ':region' => '@region@',
    ':title' => 'Vervallen bepaling inzake voorzitterschap gemeenteraad en Provinciale Staten',
    ':vote_date' => 1197846000,
    ':summary' => 'Dit wetsvoorstel dient ertoe om de bepaling inzake het voorzitterschap van de gemeenteraad en Provinciale Staten te laten vervallen. Dit leidt ertoe dat er kan worden afgeweken van de hoofdregel dat de burgemeester en de commisaris van de Koningin voorzitter van respectievelijk de gemeenteraad en Provinciale Staten zijn.',
    ':code' => 'I852W31013K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  121 =>
  array (
    ':region' => '@region@',
    ':title' => 'rechten van slachtoffers in strafprocessen',
    ':vote_date' => 1198450800,
    ':summary' => 'Het uitgangspunt van dit wetsvoorstel is het versterken van de positie van slachtoffers in een strafproces. De positie van het slachtoffer zal hierdoor duidelijker worden. In het wetsvoorstel zijn verschillende rechten van slachtoffers concreet geformuleerd. Voorbeelden hiervan zijn recht op kennisneming van processtukken en het toevoegen van stukken en spreekrecht op de terechtzitting. ',
    ':code' => 'I853W30143K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  122 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijzigingen in Pensioenwet',
    ':vote_date' => 1198450800,
    ':summary' => 'Dit wetsvoorstel houdt in dat de Pensioenwet en andere samenhangende wetten gecorrigeerd worden op technische onvolkomenheden. Tevens houdt dit voorstel in dat de uitzendbranche, als enige uitzondering, een maximale wachttijd van zes maanden mag hanteren voor uitzendovereenkomsten. De reden hiervoor is dat uitzendkranten vaak korter werken dan zes maanden. In andere branches is deze wachttijd voor deelname aan de ouderdomspensioenregeling niet langer dan twee maanden. ',
    ':code' => 'I854W31226K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  123 =>
  array (
    ':region' => '@region@',
    ':title' => 'Aanpassingen in de Wet kinderopvang',
    ':vote_date' => 1198450800,
    ':summary' => 'Deze wet brengt een aantal wijzigingen van verschillende aard in de Wet kinderopvang aan. Het gaat onder andere om technische wijzigingen. Zo houdt het wetsvoorstel bijvoorbeeld in dat de overgang van de verantwoordelijkheid voor het beleidsterrein kinderopvang niet langer valt onder Sociale Zaken en Werkgelegenheid maar onder Onderwijs, Cultuur en Wetenschap. Ook houdt dit voorstel in dat de posities van oudercommissies versterkt worden, door middel van een verplichting voor de houder van een kindercentrum of gastouderbureau, om een regeling te treffen voor de behandeling van klachten. Zo staat de oudercommissie sterker wanneer zij een klacht hebben over de wijze waarop de houder bij zijn besluitvorming over het te voeren beleid, rekening houdt met de adviezen van deze commissie.',
    ':code' => 'I855W31134K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  124 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging wet overleg huurders verhuurder',
    ':vote_date' => 1201561200,
    ':summary' => 'Dit wetsvoorstel betreft een verbetering van de positie en zeggenschap van huurders ten opzichte van verhuurders. Het gaat hierbij om verhuurders die ten minste 25 woongelegenheden verhuren. De lijst met onderwerpen waarover een verhuurder de huurders desgevraagd of ongevraagd dient te informeren, wordt uitgebreid. Tevens wordt de positie van de huurder en huurderorganisaties in de particuliere sector zoveel mogelijk gelijk getrokken met de sociale sector. Ten slotte houdt dit wetsvoorstel in dat de huurder gehouden kan worden tot regelmatig overleg met de huurderorganisatie en de bewonerscommissie. ',
    ':code' => 'I856W30856K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'wonen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  125 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging Algemene douanewet',
    ':vote_date' => 1201561200,
    ':summary' => 'Met deze wet wordt de Algemene douanewet ingevoerd, deze komt in de plaats van de Douanewet, de In-en uitvoerwet en de Statistiekwet 1950. Ook worden een groot aantal wetten aangepast, bijvoorbeeld verwijzingen naar de Douanewet die komt te vervallen.',
    ':code' => 'I857W30580K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  126 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Telecommunicatiewet',
    ':vote_date' => 1201561200,
    ':summary' => 'Deze wetswijziging heeft betrekking op meerdere aspecten. Ten eerste betreft dit voorstel de instelling van een antenneregister. Een antenneregister bevat o.a. gegevens van antenneopstelpunten, antennesystemen en antennes. Het tweede aspect is een uitbreiding van het verbod op het verzenden van ongevraagde elektronische communicatie. De positie van de consument wordt hierdoor versterkt. Het derde aspect betreft de regeling van diverse andere onderwerpen, o.a. een verduidelijkende omschrijving van de samenwerking tussen de OPTA en de NMa. ',
    ':code' => 'I858W30661K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'media en communicatie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => NULL,
    ),
  ),
  127 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging Wet werk en bijstand',
    ':vote_date' => 1201561200,
    ':summary' => 'Dit voorstel houdt een wijziging van de Wet werk en bijstand in. Het gaat om het openstellen van de mogelijkheid van het verlenen van bijzondere bijstand aan bepaalde groepen. Dit betreft personen die gedwongen zijn opgenomen of worden verpleegd. Tevens gaat het om
uitbreiding van de doelgroep van de langdurigheidstoeslag met gedeeltelijk arbeidsgeschikten.
',
    ':code' => 'I859W31138K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => NULL,
    ),
  ),
  128 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Wet werk en bijstand',
    ':vote_date' => 1203375600,
    ':summary' => 'Met dit wetsvoorstel wordt het voor alle bijstandsgerechtigden die geen sollicitatieplicht en re�ntegratieplicht hebben, mogelijk om gedurende dertien weken in het buitenland te verblijven met behoud van de bijstandsuitkering. De huidige wet biedt deze mogelijkheid alleen aan personen ouder dan 57,5 jaar en jonger dan 65 jaar. De regering ziet echter geen gronden waarop deze leeftijdscategorie een uitzondering zou zijn. Het voorstel brengt geen verandering in de reeds bestaande uitzonderingspositie voor 65-plussers.',
    ':code' => 'I860W31127K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => NULL,
      'pvv' => NULL,
      'verdonk' => 'voor',
    ),
  ),
  129 =>
  array (
    ':region' => '@region@',
    ':title' => ' Wijziging van de Gaswet en de Elektriciteitswet',
    ':vote_date' => 1203375600,
    ':summary' => 'Dit wetsvoorstel strekt tot wijziging van enkele wetten die met name behoren tot de Gaswet en de Elektriciteitswet 1998. De wijzigingen hebben tot doel wetstechnische gebreken en onvolkomenheden weg te nemen en enkele kleine inhoudelijke wijzigingen aan te brengen. Tevens worden diverse wetten ingetrokken die uitgewerkt zijn. Het wetsvoorstel bevat ook een aantal meer inhoudelijke wijzigingen, onder andere over het uitwisselen van gegevens tussen toezichthouders.
',
    ':code' => 'I861W31120K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'energie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  130 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Wet educatie en beroepsonderwijs',
    ':vote_date' => 1203375600,
    ':summary' => 'Uit het themaonderzoek van de Inspectie van het onderwijs in 2006 naar de naleving van de 850 urennorm is gebleken dat er strenger toezicht en sancties nodig zijn om de naleving van de urennorm te verbeteren. Dit wetsvoorstel voorziet daarin. Deze wetswijziging heeft verschillende doelen: 1. Het realiseren van ��n normenstelsel. 2. Het loslaten van de directe koppeling tussen de 850 urennorm en het recht op studiefinanciering c.q. tegemoetkoming in de schoolkosten. 3. Het onderscheid tussen voltijdse en deeltijdse opleidingen geldt tevens als grens voor het onderscheid tussen deeltijd- en voltijdbekostiging van een deelnemer voor een instelling.',
    ':code' => 'I862W31048K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  131 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet wegvervoer goederen',
    ':vote_date' => 1203375600,
    ':summary' => 'Dit wetsvoorstel heeft betrekking op de het goederenvervoer over de weg met vrachtauto\'s. De regelgeving wordt hierdoor vereenvoudigd, de administratieve lasten verminderd en de handhaafbaarheid van de regelgeving wordt verbeterd.',
    ':code' => 'I863W30896K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  132 =>
  array (
    ':region' => '@region@',
    ':title' => 'Puntenstelsel rijbewijzen',
    ':vote_date' => 1203375600,
    ':summary' => 'Dit wetsvoorstel introduceert een puntenstelsel rijbewijzen. Dit als gevolg van het voornemen van het kabinet om recidive (opnieuw begaan) van verkeersdelicten harder aan te pakken. Het voorstel is bedoel voor de aanpak van ernstige verkeersdelicten. Het voorgestelde systeem komt erop neer dat de bestuurder van een motorrijtuig die binnen vijf jaar na een eerdere strafrechterlijke afdoening opnieuw een bepaald ernstig verkeersdelict begaat, een rijopzegging krijgt voor een nader te bepalen periode. Gedurende die periode mag de persoon niet rijden. Het kan daarbij voorkomen dat de opgelegde rijontzegging een bepaalde periode overstijgt waardoor het rijbewijs ongeldig wordt. Dan moet de betrokken persoon een nieuw rijbewijs aanvragen.',
    ':code' => 'I864W30324K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  133 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Wet op de architectentitel ',
    ':vote_date' => 1204585200,
    ':summary' => 'Dit wetsvoorstel betreft de erkenning van beroepskwalificaties voor architecten, stedenbouwkundigen, tuin-en landschapsarchitecten en interieurarchitecten. De doelstelling is het vergemakkelijken van de mogelijkheid tot werken in een andere lidstaat, EER-land of Zwitserland. Dit gebeurt door te waarborgen dat migrerende beroepsbeoefenaars toegang hebben tot hetzelfde gereglementeerde beroep in een andere lidstaat. De richtlijn brengt drie algemene richtlijnen en twaalf richtlijnen die vallen onder een bepaalde sector in ��n richtlijn onder, om te voorzien in een eenvoudiger en duidelijker geheel van voorschriften. Andere wijzigingen betreffen onder meer bij- en nascholing voor architecten, en het tijdelijk en incidenteel verrichten van diensten op het gebied van architectuur, stedenbouw, tuin- en landschapsarchitectuur, en interieurarchitectuur.',
    ':code' => 'I865W31079K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  134 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Rijkswet op het Nederlanderschap',
    ':vote_date' => 1204585200,
    ':summary' => 'Wijziging van de Rijkswet op het Nederlanderschap ter invoering van een verklaring van verbondenheid, en tot aanpassing van de regeling van de verkrijging van het Nederlanderschap na erkenning.

Dit wetsvoorstel betreft de invoering van een verklaring van verbondenheid als onderdeel van de verkrijging van het Nederlanderschap door optie of door naturalisatie. In de verklaring van verbondenheid gaat het om het besef dat de relatie met de samenleving wordt versterkt. Dit wordt uitgedrukt in het respect voor de rechtsorde die het samenleven mogelijk maakt en in de belofte de plichten te vervullen die uit het Nederlanderschap voortvloeien.

Tevens betreft dit wetsvoorstel een nuancering van de regels betreffende de verkrijging van het Nederlanderschap in geval van erkenning na geboorte, in het bijzonder voor vaders. Verder verduidelijkt het de rechtspositie van oudere minderjarigen bij de verkrijging en het verlies van het Nederlanderschap. ',
    ':code' => 'I866W30584K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'immigratie en integratie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'niet bestaand',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => 'voor',
    ),
  ),
  135 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van enige bepalingen van Boek 1 van het Burgerlijk Wetboek ',
    ':vote_date' => 1205190000,
    ':summary' => 'Dit wetsvoorstel strekt er in de eerste plaats toe om de artikelen te verduidelijken die bij toepassing in de praktijk onduidelijk zijn gebleken. Het gaat om een artikel dat bepaalt dat ouders van rechtswege gezag hebben over hun kind als dit tijdens hun geregistreerd partnerschap is geboren. De bepaling ziet op situaties dat de man tijdens de zwangerschap het kind heeft erkend, zodat hij vanaf de geboorte in familierechtelijke betrekking tot het kind staat. Ook wordt het artikel over situaties waar een kind wordt geboren tijdens een huwelijk of geregistreerd partnerschap van een ouder en een niet-ouder verduidelijkt.',
    ':code' => 'I867W29353K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'overig',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  136 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van diverse onderwijswetten',
    ':vote_date' => 1206399600,
    ':summary' => 'Met deze wetswijzigingen worden scholen verplicht om voor elk leerjaar de schoolboeken gratis aan leerlingen beschikbaar te stellen. Het gaat om lesmateriaal dat door dat bevoegd gezag specifiek voor dat leerjaar is voorgeschreven. Met ingang van het kalenderjaar 2009 ontvangen scholen voor de aanschaf van de schoolboeken extra gelden van de rijksoverheid.

Als gevolg hiervan wordt de hoogte van de tegemoetkoming op grond van de Wet tegemoetkoming onderwijsbijdrage en schoolkosten (WTOS) voor ouders van deze leerlingen verlaagd met de kosten van een gemiddeld schoolboekenpakket, namelijk 308 euro (per leerling per schooljaar). Het doel van deze wetswijziging is: het verlagen van de schoolkosten voor de ouders en een betere marktwerking op de educatieve boekenmarkt.',
    ':code' => 'I868W31325K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'tegen',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => 'tegen',
    ),
  ),
  137 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Comptabiliteitswet 2001',
    ':vote_date' => 1207000800,
    ':summary' => 'Met dit wetsvoorstel wordt een aantal wijzigingen in de Comptabiliteitswet 2001 aangebracht: 1. een zelfstandige begrotingswet voor de Staten-Generaal;
2. onderbrenging van begroting van het Kabinet van de Koning(in) in een aparte begrotingsstaat, vastgesteld bij de begrotingswet van het Ministerie van Algemene Zaken;
3. en een aparte begroting voor de Commissie van toezicht betreffende de inlichtingen- en veiligheidsdiensten.',
    ':code' => 'I869W29833K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'economie en consument',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => 'voor',
    ),
  ),
  138 =>
  array (
    ':region' => '@region@',
    ':title' => 'wijzigingen Waterwet',
    ':vote_date' => 1207000800,
    ':summary' => 'Er zijn diverse wetten die ge�ntegreerd en gemoderniseerd kunnen worden, o.a. de Wet op de waterhuishouding, de Wet verontreiniging oppervlaktewateren en de Wet verontreiniging zeewater. In de diverse hoofdstukken zullen specifieke bepalingen voor de Noordzee per deelonderwerp worden toegelicht. De Waterwet bevat allereerst in enkele beknopte bepalingen de doelstellingen die wezenlijk zijn voor het waterbeheer. Deze doelstellingen worden uitdrukkelijk verankerd als kader voor de uitvoering van de wet. Twee voorbeelden van doelstellingen zijn: 1) voorkoming en waar nodig beperking van overstromingen, wateroverlast en waterschaarste, in samenhang met 2) bescherming en verbetering van de chemische en ecologische kwaliteit van watersystemen. ',
    ':code' => 'I870W30818K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'milieu en omgeving',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  139 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Wet luchtvaart en de Luchtvaartwet ',
    ':vote_date' => 1208210400,
    ':summary' => 'Met dit wetsvoorstel worden twee verordeningen in de Nederlandse wetgeving ge�mplementeerd. Het gaat om:

1.Het vaststellen van een communautaire (zwarte) lijst. Daarmee wordt het publiek ge�nformeerd over luchtvaartmaatschappijen die niet aan de internationale veiligheidseisen voor de luchtvaart voldoen. Tevens wordt geregeld dat dergelijke maatschappijen binnen de Europese Gemeenschap een exploitatieverbod opgelegd krijgen;

2.Het reguleren van het verlenen van bijstand aan gehandicapten en personen met beperkte mobiliteit die per luchtvervoer reizen en het voorkomen van weigering van het vervoer van deze personen door luchtvaartmaatschappijen. Het gaat hierbij om het vaststellen van regels voor sancties op overtredingen van de verordeningen en moet een aantal strijdige bepalingen worden aangepast.
',
    ':code' => 'I871W31232K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'vervoer en verkeer',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  140 =>
  array (
    ':region' => '@region@',
    ':title' => 'Bevordering eigenwoningbezit',
    ':vote_date' => 1208210400,
    ':summary' => 'De Wet bevordering eigenwoningbezit (Web BEW) is op 1 januari 2001 in werking getreden. Op 1 januari 2007 is deze wet ingrijpend gewijzigd, waarbij de werking is verruimd en vereenvoudigd. Dit nieuwe wetsvoorstel strekt tot een verdergaande verbetering van de BEW, vooral wat betreft de uitvoering van deze wet.',
    ':code' => 'I872W31247K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'wonen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  141 =>
  array (
    ':region' => '@region@',
    ':title' => 'bevordering eigenwoningbezit-verkoop onder voorwaarden',
    ':vote_date' => 1208210400,
    ':summary' => 'In dit wetsvoorstel wordt geregeld dat de combinatie van koopsubsidie op grond van de Wet bevordering eigenwoningbezit (Wet BEW) met verkoop onder voorwaarden altijd toegestaan is. De combinatie koopsubsidie met verkoop onder voorwaarden betekent een verruiming van de keuzemogelijkheden voor de koper. Aan de andere kant is geborgd dat middelen uit de sociale sector weer kunnen worden ingezet voor de doelgroep. De woning wordt bijvoorbeeld teruggekocht of de overwaarde vloeit deels terug. Verwacht wordt dat deze maatregel zal leiden tot een toename van het aantal verkochte woningen.',
    ':code' => 'I873W31114K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'wonen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  142 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet educatie en beroepsonderwijs inzake colleges van bestuur en raden van toezicht',
    ':vote_date' => 1208210400,
    ':summary' => 'Met dit wetsvoorstel wordt ook in de BVE-sector (beroepsonderwijs en volwasseneneducatie) het raad-van-toezichtmodel ge�ntroduceerd. Hiermee wordt aangesloten bij een eerder ingezette ontwikkeling in het kader van goed bestuur (good governance) voor de hele onderwijssector. Dit model houdt in dat alle onderwijsinstellingen over zowel een college van bestuur (CvB) als een raad van toezicht (RvT) moeten beschikken. Het CvB is belast met het bestuur van de instelling en de RvT met het (interne) toezicht daarop.',
    ':code' => 'I874W30599K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => '',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  143 =>
  array (
    ':region' => '@region@',
    ':title' => 'Betrokkenheid van kinderen bij gewapende conflicten',
    ':vote_date' => 1208210400,
    ':summary' => 'Onderhavig wetsvoorstel strekt tot goedkeuring van het Facultatief Protocol bij het Verdrag inzake de rechten van het kind inzake de betrokkenheid van kinderen bij gewapende conflicten. Dit Protocol is op 25 mei 2000 tot stand gekomen en tijdens de Millenniumtop van 5-9 september 2000 door Nederland ondertekend. Het bevat diverse verplichtingen, waaronder:
1.leden van de krijgsmacht met een leeftijd onder de 18 jaar mogen niet rechtstreeks deelnemen aan vijandelijkheden;
2.personen met een leeftijd onder de 18 jaar mogen niet gedwongen worden ingelijfd of opgenomen in de krijgsmacht.
',
    ':code' => 'I875W29976K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'justitie en politie',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'tegen',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  144 =>
  array (
    ':region' => '@region@',
    ':title' => 'Regels voor Inkomensvoorziening voor Oudere Werklozen',
    ':vote_date' => 1208210400,
    ':summary' => 'Dit wetsvoorstel is ter invoering van een voorziening voor werknemers die op of na de leeftijd van 50 jaar werkloos zijn geworden, en die gedurende de WW-periode er niet in zijn geslaagd (voldoende) inkomen te verwerven. Deze voorziening biedt de werknemer, na afloop van zijn uitkering op grond van de Werkloosheidswet (WW), inkomensondersteuning tot 65 jaar, zolang hij nog niet in zijn bestaan kan voorzien door middel van het verrichten van arbeid. Hierbij krijgt hij niet te maken met een vermogenstoets. De IOW is activerend, omdat de IOW-gerechtigde zich beschikbaar dient te stellen voor de arbeidsmarkt (sollicitatieplicht). ',
    ':code' => 'I876W30819K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  145 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet educatie en beroepsonderwijs',
    ':vote_date' => 1208815200,
    ':summary' => 'Dit wetsvoorstel leidt tot minder regels en minder administratieve lasten voor de beroepsopleidingen. Het gaat daarbij onder andere om:
- afschaffing van de Onderwijs- en Examenregeling (OER) en de examenregeling van exameninstellingen als verplichte instrumenten;
- afschaffing van de verplichting om licenties aan te vragen voor het Centraal register beroepsopleidingen (CREBO) voor het bekostigd onderwijs;
',
    ':code' => 'I877W30853K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'onderwijs',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => 'voor',
    ),
  ),
  146 =>
  array (
    ':region' => '@region@',
    ':title' => 'kapitaalbescherming voor naamloze vennootschappen',
    ':vote_date' => 1208815200,
    ':summary' => 'Dit wetsvoorstel versoepelt het systeem van kapitaalbescherming voor naamloze vennootschappen. Het gaat onder andere om:
- Bij inbreng op aandelen anders dan in geld mag onder bepaalde voorwaarden een accountantsverklaring achterwege blijven. Hetzelfde geldt voor transacties met oprichters in de eerste fase na oprichting (de zogenaamde
- De mogelijkheden voor inkoop van eigen aandelen worden verruimd.',
    ':code' => 'I878W31220K2',
    ':type' => 'wetsvoorstel',
    ':result' => NULL,
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'arbeid en sociale zekerheid',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  147 =>
  array (
    ':region' => '@region@',
    ':title' => 'Internationale Gezondheidsregeling',
    ':vote_date' => 1211839200,
    ':summary' => 'Met deze wet wordt de internationale gezondheidsregeling ingevoerd. Door nieuwe internationale afspraken moet de nationale infectieziekteregeling aangepast worden. Hieronder vallen de Wet collectieve preventie volksgezondheid, de Infectieziektenwet en de Quarantainewet: deze worden grondig herzien.',
    ':code' => 'I879W31316K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'gezondheidszorg',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  148 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wet op het kindgebonden budget',
    ':vote_date' => 1211839200,
    ':summary' => 'Hiermee worden de systematiek en de hoogte van de bedragen per kind in 2009 in de Wet kindgebonden budget opgenomen. Tevens wordt het in de wet opgenomen afbouwpercentage gewijzigd. De hoogte van de bedragen per kind zijn degressief vormgegeven. Dat houdt in dat men voor het tweede kind minder ontvangt dan voor het eerste, en voor het derde kind ontvangt men minder dan voor het tweede kind.',
    ':code' => 'I880W31399K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'belastingen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'tegen',
      'pvv' => 'tegen',
      'verdonk' => 'voor',
    ),
  ),
  149 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijzigingen belastingwetten',
    ':vote_date' => 1213048800,
    ':summary' => 'In dit wetsvoorstel zijn technische wijzigingen in verband met het onderhoud van de fiscale wetgeving opgenomen. De wijzigingen betreffen een breed scala aan fiscale wetten en enkele daarmee samenhangende wetten. De wijzigingen hebben betrekking op zowel directe als indirecte belastingen en materi�le en formele belastingwetten.',
    ':code' => 'I881W31404K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'belastingen',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  150 =>
  array (
    ':region' => '@region@',
    ':title' => 'Wijziging van de Financi�le-verhoudingswet',
    ':vote_date' => 1213048800,
    ':summary' => 'Wijziging van de Financi�le-verhoudingswet en enkele andere wetten in verband met uitkeringen aan gemeenten en provincies. Het voorstel biedt instrumenten om vier doelen uit het Coalitieakkoord van februari 2007 te realiseren, te weten:
1.de overheid schenkt vertrouwen en werkt in dialoog met de medeoverheden;
2.de bestuurlijke drukte wordt verminderd;
3.decentralisatie van taken en bevoegdheden door het Rijk en zelfstandigheid van provincies en gemeenten wordt met kracht bevorderd;
4.minder \'bureaucratische\' drukte op rijksniveau.
',
    ':code' => 'I882W31327K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  151 =>
  array (
    ':region' => '@region@',
    ':title' => 'Overeenkomst inzake o.a. onrechtmatige invoer',
    ':vote_date' => 1213048800,
    ':summary' => 'Het gaat om implementatie van de op 14 november 1970 te Parijs tot stand gekomen Overeenkomst inzake de middelen om de onrechtmatige invoer, uitvoer of eigendomsoverdracht van culturele goederen te verbieden en te verhinderen om zo offici�le bekrachtiging van die Overeenkomst mogelijk te maken. Het onderhavige wetsvoorstel wordt tegelijk ingediend met het wetsvoorstel tot goedkeuring van genoemd Verdrag. Het verdrag heeft zowel betrekking op bescherming van belangrijke cultuurgoederen als het terugvorderen van die cultuurgoederen uit andere Verdragsstaten waar zij vervolgens zijn ingevoerd.',
    ':code' => 'I883W31255K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'internationaal',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  152 =>
  array (
    ':region' => '@region@',
    ':title' => 'Overeenkomst inzake o.a. onrechtmatige invoer',
    ':vote_date' => 1213048800,
    ':summary' => 'Dit wetsvoorstel betreft goedkeuring van de op 14 november 1970 te Parijs tot stand gekomen Overeenkomst inzake de middelen om de onrechtmatige invoer, uitvoer en eigendomsoverdracht van culturele goederen te verbieden en te verhinderen. Er is nu vastgelegd wanneer bij bepaalde, precies aangeduide of aan te duiden cultuurgoederen de bescherming van de koper te goeder trouw opzij wordt gezet. Deze aanpassing maakt de weg vrij om partij te worden bij het UNESCO-verdrag 1970. Dit wetsvoorstel vraagt hiervoor goedkeuring van de Staten-Generaal.',
    ':code' => 'I884W31256K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'internationaal',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'voor',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'voor',
      'verdonk' => 'voor',
    ),
  ),
  153 =>
  array (
    ':region' => '@region@',
    ':title' => 'Reglement van orde Nederlandse Antillen en Aruba',
    ':vote_date' => 1213048800,
    ':summary' => 'Dit betreft een voorstel van de Vaste commissie voor Nederlands-Antilliaanse en Arubaanse Zaken tot wijziging van het Reglement van Orde. De commissie stelt voor om, zodra de nieuwe staatkundige structuur van kracht is geworden, een afzonderlijk reglement van orde voor het POK vast te stellen. ',
    ':code' => 'I885W31470K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Aangenomen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'voor',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'voor',
      'christenunie' => 'voor',
      'sgp' => 'voor',
      'vvd' => 'voor',
      'pvv' => 'tegen',
      'verdonk' => 'tegen',
    ),
  ),
  154 =>
  array (
    ':region' => '@region@',
    ':title' => 'raadplegend referendum over het Hervormingsverdrag van de Europese Unie',
    ':vote_date' => 1213048800,
    ':summary' => 'Voorstel van wet betreffende het houden van een raadplegend referendum over het Hervormingsverdrag van de Europese Unie. Indieners van onderhavig wetsvoorstel zijn van mening dat de Nederlandse burger het recht heeft om een oordeel te geven over belangrijke en ingrijpende wijzigingen in de Europese Verdragen. Met dit voorstel wordt ervoor gezorgd dat met betrekking tot het Hervormingsverdrag de burger dit recht ook krijgt. Daarnaast wordt er beoogd de gegroeide betrokkenheid bij de besluitvorming over de Europese Grondwet vast te houden door de burgers nogmaals in een nationaal referendum advies te vragen over de bekrachtiging door Nederland.',
    ':code' => 'I886W31259K2',
    ':type' => 'wetsvoorstel',
    ':result' => 'Afgewezen',
    ':submitter' => '@submitter@',
    ':parent' => NULL,
    ':show' => 0,
    'categories' => 'democratie en bestuur',
    'tags' =>
    array (
      0 => 'politix',
    ),
    'votes' =>
    array (
      'sp' => 'tegen',
      'groenlinks' => 'tegen',
      'pvda' => 'voor',
      'pvdd' => 'voor',
      'd66' => 'voor',
      'cda' => 'tegen',
      'christenunie' => 'tegen',
      'sgp' => 'tegen',
      'vvd' => 'tegen',
      'pvv' => 'voor',
      'verdonk' => 'tegen',
    ),
  ),
);


			$this->message('begin', 'Inserting '.sizeof($data).' raadsstukken');

			foreach ($data as $row) {
				if(!isset($region_map[$row[':region']]) || $region_map[$row[':region']][0] === null)
					throw new RuntimeException("Can't map region {$row[':region']}, bug in prelude detected!");

				if(!isset($type_map[$row[':type']]) || $type_map[$row[':type']][0] === null)
					throw new RuntimeException("Can't map type {$row[':type']}, bug in prelude detected!");

				if(!isset($result_map[$row[':result']]) || $result_map[$row[':result']][0] === null)
					throw new RuntimeException("Can't map result type {$row[':result']}, bug in prelude detected!");

				if(!isset($submitter_type_map[$row[':submitter']]) || $submitter_type_map[$row[':submitter']][0] === null)
					throw new RuntimeException("Can't map submitter type {$row[':submitter']}, bug in prelude detected!");

				if($row[':parent'] !== null) throw new RuntimeException("Importing raadsstukken as a tree structure is currently not supported!");

				$sql = "INSERT INTO rs_raadsstukken(region, title, vote_date, summary, code, type, result, submitter, parent, show)
						VALUES(%i, %s, %s, %s, %s, %i, %i, %i, %, %i)";
				$sql = $this->db->formatQuery($sql, $region_map[$row[':region']][0], $row[':title'], date("Y-m-d", $row[':vote_date']), $row[':summary'],
									   $row[':code'], $type_map[$row[':type']][0], $result_map[$row[':result']][0], $submitter_type_map[$row[':submitter']][0],
									   $row[':parent'], $row[':show']);


				$this->message('pre-sql', htmlentities($sql));
				$res = $this->db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

				$sql = "SELECT currval('rs_raadsstukken_id_seq'::regclass)";
				$raadsstuk_id = $this->db->query($sql)->fetchCell();
				if("{$raadsstuk_id}" == '') throw new RuntimeException("Can't fetch new raadsstuk id: {$sql}");
				$this->message('post-sql', "Success. New raadsstuk id: {$raadsstuk_id}");


				//register tags
				foreach ($row['tags'] as $tag) {
					if(!isset($tags_map[$tag]) || $tags_map[$tag][0] === null)
						throw new RuntimeException("Can't map tag {$tag}, bug in prelude detected!");

					$sql = "INSERT INTO rs_raadsstukken_tags(raadsstuk, tag) VALUES(%i, %i)";
					$sql = $this->db->formatQuery($sql, $raadsstuk_id, $tags_map[$tag][0]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					$this->message('post-sql', "Success. Raasstuk {$raadsstuk_id} is linked to tag {$tag}");
				}

				//categories
				if(!isset($category_map[$row['categories']]))
					throw new RuntimeException("Can't find mapping for category: '{$row['categories']}'. Bug in prelude detected!");

				foreach ($category_map[$row['categories']] as $category) {
					if($category[0] === null) throw new RuntimeException("Category '{$category[1]}' is not mapped to id, bug in prelude detected!");

					$sql = "INSERT INTO rs_raadsstukken_categories(raadsstuk, category) VALUES(%i, %i)";
					$sql = $this->db->formatQuery($sql, $raadsstuk_id, $category[0]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					$this->message('post-sql', "Success. Raasstuk {$raadsstuk_id} is linked to category {$category[1]}");
				}

				//votes
				$this->message('info', "Voting for raadsstuk {$raadsstuk_id}");
				foreach ($row['votes'] as $party => $vote) {
					if(!array_key_exists($vote, $votes_map))
						throw new RuntimeException("Can't map vote '{$vote}' to internal vote, no mapping. Bug in prelude detected!");

					if(!isset($party_map[$party]) || $party_map[$party][0] == null)
						throw new RuntimeException("Party mapping for '{$party}' is not found!. Bug in prelude detected!");

					if(!isset($politician_map[$party]) || $politician_map[$party][0] === null)
						throw new RuntimeException("Can't find politician for party '{$party}'. Bug in prelude detected!");

					if($votes_map[$vote] != null) {
						$sql = "INSERT INTO rs_votes(politician, raadsstuk, vote) VALUES(%i, %i, %i)";
						$sql = $this->db->formatQuery($sql, $politician_map[$party][0], $raadsstuk_id, $votes_map[$vote][0]);

						$this->message('pre-sql', htmlentities($sql));
						$res = $this->db->query($sql);
						if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
						$this->message('post-sql', "Success. Vote '{$votes_map[$vote][1]}' is set for raasstuk {$raadsstuk_id} from party {$party_map[$party][1]} by politician {$politician_map[$party][1]}");
					} else $this->message('info', "Skiping vote for raadsstuk {$raadsstuk_id} from party {$party_map[$party][1]} by politician {$politician_map[$party][1]}");
				}
			}


			$this->db->query('ROLLBACK');
			$this->message('global-succes', "Success =)");

		} catch (Exception $e) {
			$this->message('sql-error', $e->getMessage());
			if($e instanceof DatabaseException) {
				$this->message('sql-error-query', $e->getSQL());
				$this->message('sql-error-detail', $e->getError());
			}

			$this->db->query('ROLLBACK');
			$this->message('info', 'Rollback complete');
		}
		
		$this->show2();
	}



	/** Create Onbekend type on demand */
	private function ensureRaadsstukTypeMap(&$type_map) { //throws RuntimeException on error
		$this->message('begin', 'Ensure all raadsstuk types are present');

		foreach ($type_map as $k => $tp) {
			if($tp[0] === null) {
				$this->message('info', "Searching for raadsstuk type: {$tp[1]}");
				$sql = "SELECT id FROM rs_raadsstukken_type WHERE name = %s;";
				$sql = $this->db->formatQuery($sql, $tp[1]);
				$res = $this->db->query($sql);

				if($res->numRows() != 0) {
					$type_map[$k][0] = $res->fetchCell();
					$this->message('info', "Raadsstuk type {$tp[1]} is found as {$type_map[$k][0]}");
				} else { //we have to insert new raadsstuk type
					$this->message('info', "Raadsstuk type {$tp[1]} is not found, creating new one.");
					$sql = "INSERT INTO rs_raadsstukken_type(name) VALUES(%s);";
					$sql = $this->db->formatQuery($sql, $tp[1]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

					$sql = "SELECT currval('rs_raadsstukken_type_id_seq'::regclass)";
					$val = $this->db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new raaddsstuk type id: {$sql}");
					$type_map[$k][0] = $val;
					$this->message('post-sql', "Success. Raadsstuk type {$tp[1]} is created and mapped to {$val}");
				}
			}
		}

		$this->message('end', 'Complete');
	}


	/** Creates "Onbekend" submitter (type) */
	private function ensureRaadsstukSubmitter(&$submit_type_map) {
		$this->message('begin', 'Ensure all submit types are present');

		foreach ($submit_type_map as $k => $sub) {
			if($sub[0] === null) {
				$this->message('info', "Searching for raadsstuk submit type: {$sub[1]}");
				$sql = "SELECT id FROM rs_raadsstukken_submit_type WHERE name = %s;";
				$sql = $this->db->formatQuery($sql, $sub[1]);
				$res = $this->db->query($sql);

				if($res->numRows() != 0) {
					$submit_type_map[$k][0] = $res->fetchCell();
					$this->message('info', "Raadsstuk submit type {$sub[1]} is found as {$submit_type_map[$k][0]}");
				} else { //we have to insert new raadsstuk type
					$this->message('info', "Raadsstuk submit type {$sub[1]} is not found, creating new one.");
					$sql = "INSERT INTO rs_raadsstukken_submit_type(name) VALUES(%s);";
					$sql = $this->db->formatQuery($sql, $sub[1]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

					$sql = "SELECT currval('rs_raadsstukken_submit_type_id_seq'::regclass)";
					$val = $this->db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new raaddsstuk submit type id: {$sql}");
					$submit_type_map[$k][0] = $val;

					$this->message('post-sql', "Success. Raadsstuk submit type {$sub[1]} is created and mapped to {$val}");
				}
			}
		}

		$this->message('end', 'Complete');
	}


	/** Create 'politix' tag on demand. */
	private function ensureTags(&$tags_map) {
		$this->message('begin', 'Ensure required tags are mapped');

		foreach ($tags_map as $k => $tp) {
			if($tp[0] === null) {
				$this->message('info', "Searching for tag: {$tp[1]}");
				$sql = "SELECT id FROM sys_tags WHERE name = %s;";
				$sql = $this->db->formatQuery($sql, $tp[1]);
				$res = $this->db->query($sql);

				if($res->numRows() != 0) {
					$tags_map[$k][0] = $res->fetchCell();
					$this->message('info', "Tag {$tp[1]} is found as {$tags_map[$k][0]}");
				} else { //we have to insert new tag
					$this->message('info', "Tag {$tp[1]} is not found, creating new one.");
					$sql = "INSERT INTO sys_tags(name) VALUES(%s);";
					$sql = $this->db->formatQuery($sql, $tp[1]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

					$sql = "SELECT currval('sys_tags_id_seq'::regclass)";
					$val = $this->db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new tag id: {$sql}");
					$tags_map[$k][0] = $val;
					$this->message('post-sql', "Success. Tag {$tp[1]} is created and mapped to {$val}");
				}
			}
		}

		$this->message('end', 'Complete');
	}

	/** Creates missing parties. */
	private function ensureParties(&$party_map, $region_map, $time_start, $time_end) {
		$this->message('begin', 'Ensure all parties exists and are valid in our regions.');

		foreach ($party_map as $party => $my_party) {
			if($my_party[0] === null) { //create party
				$this->message('info', "Searching for party: {$my_party[1]}");

				$sql = "SELECT id FROM pol_parties WHERE name = %s;";
				$sql = $this->db->formatQuery($sql, $my_party[1]);
				$res = $this->db->query($sql);

				if($res->numRows() != 0) {
					$party_map[$party][0] = $res->fetchCell();
					$this->message('info', "Party '{$party}' is found as {$party_map[$party][0]}:'{$party_map[$party][1]}'");
				} else { //insert new party
					$this->message('info', "Party '{$my_party[1]}' is not found, creating new one.");

					if(!isset($region_map[$my_party['owner']]) || $region_map[$my_party['owner']][0] === null)
						throw new RuntimeException("Can't map owner region {$my_party['owner']} to a valid region! Bug in prelude detected!");

					$sql = "INSERT INTO pol_parties(name, combination, owner, short_form) VALUES(%s, %i, %i, %s);";
					$sql = $this->db->formatQuery($sql, $my_party[1], isset($my_party['combination'])? $my_party['combination']: 0, $region_map[$my_party['owner']][0], $party);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

					$sql = "SELECT currval('pol_parties_id_seq'::regclass)";
					$val = $this->db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch party id: {$sql}");
					$party_map[$party][0] = $val;

					$this->message('post-sql', "Success. Party '{$my_party[1]}' is created and mapped to {$val}");
				}
			}

			$my_party = $party_map[$party];

			//check if party is valid in our regions
			foreach ($region_map as $region) {
				if($region[0] === null) throw new RuntimeException("Region map is invalid for '{$region[1]}'. Prelude bug detected!");

				$sql = "SELECT id FROM pol_party_regions WHERE party = %i AND region = %i AND time_start <= %s AND time_end >= %s";
				$sql = $this->db->formatQuery($sql, $my_party[0], $region[0], $time_start, $time_end);

				$res = $this->db->query($sql);
				if($res->numRows() != 0) {
					$this->message('info', "No change. Party '{$my_party[1]}' valid in region '{$region[1]}' for [{$time_start} - {$time_end}]");
				} else {
					$this->message('info', "Party '{$my_party[1]}' is not valid in region '{$region[1]}'. Registering for period [{$time_start} - {$time_end}].");

					$sql = "INSERT INTO pol_party_regions(party, region, bo_user, time_start, time_end) VALUES(%i, %i, NULL, %s, %s)";
					$sql = $this->db->formatQuery($sql, $my_party[0], $region[0], $time_start, $time_end);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					$this->message('post-sql', "Success. Party '{$my_party[1]}' is registered in region '{$region[1]}' for period [{$time_start} - {$time_end}].");
				}
			}
		}

		$this->message('end', 'Complete');
	}


	/** Ensure we have "Onbekend" politician in each party. */
	private function ensurePoliticians(&$politician_map, $party_map, $region_map, $time_start, $time_end) {
		$this->message('begin', 'Ensure all politicans exists and have valid functions in our regions.');
		$polids = array();
		foreach ($politician_map as $party => $my_pol) {
			if(!isset($party_map[$party]) || $party_map[$party][0] === null) throw new RuntimeException("Can't find party mapping for politician '{$my_pol[1]}', intern party: '{$party}'");

			if($my_pol[0] === null) { //create politician in that party
				$this->message('info', "Searching for politician '{$my_pol[1]}' in {$party_map[$party][1]}");

				//we have the guy that works for our party (has at least one linking function)
				$sql = "SELECT p.id FROM pol_politicians p INNER JOIN pol_politician_functions pf ON pf.politician = p.id WHERE last_name = %s AND pf.party = %i;";
				$sql = $this->db->formatQuery($sql, $my_pol[1], $party_map[$party][0]);
				$res = $this->db->query($sql);

				$pass = false;
				if($res->numRows() != 0) {
					$i = 0;
					while(($row = $res->fetchRow())) {
						$id = $row['id'];

						if(!isset($polids[$id])) {
							$polids[$id] = $party_map[$party][1];
							$politician_map[$party][0] = $id;
							$this->message('info', "Politician '{$my_pol[1]}' is found as {$politician_map[$party][0]} in party '{$party_map[$party][1]}'");
							$pass = true;
							break;
						} else $i += 1;
					}

					if(!$pass) $this->message('warning', "{$i} politicians named '{$my_pol[1]}' are found for party '{$party_map[$party][1]}' but they already work for other parties. This should not happen if you assign votes to 'Onbekend' politicians!");
				}

				if(!$pass) { //insert new politician
					$this->message('info', "Politician '{$my_pol[1]}' is not found for party '{$party_map[$party][1]}', creating new one.");

					$sql = "INSERT INTO pol_politicians(title, first_name, last_name, gender_is_male, email, name_sortkey, region_created)
												 VALUES(NULL,  NULL,       %s,        1,              NULL,  %s,           NULL);";

					$sql = $this->db->formatQuery($sql, $my_pol[1], $my_pol[1]);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");

					$sql = "SELECT currval('pol_politicians_id_seq'::regclass)";
					$val = $this->db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new politician id: {$sql}");
					$politician_map[$party][0] = $val;

					$this->message('post-sql', "Success. Politician '{$my_pol[1]}' is created for party '{$party_map[$party][1]}' and mapped to {$val}");
				}
			}

			$my_pol = $politician_map[$party];

			//check if politican is valid in our regions
			foreach ($region_map as $region) {
				if($region[0] === null) throw new RuntimeException("Region map is invalid for '{$region[1]}'. Prelude bug detected!");

				$sql = "SELECT id FROM pol_politician_functions WHERE politician = %i AND party = %i AND region = %i AND time_start <= %s AND time_end >= %s";
				$sql = $this->db->formatQuery($sql, $my_pol[0], $party_map[$party][0], $region[0], $time_start, $time_end);

				$res = $this->db->query($sql);
				if($res->numRows() != 0) {
					$this->message('info', "No change. Politician '{$my_pol[1]}' is valid in region '{$region[1]}' for [{$time_start} - {$time_end}]");
				} else {
					$this->message('info', "Politician '{$my_pol[1]}' is not valid in region '{$region[1]}'. Registering for period [{$time_start} - {$time_end}].");

					$sql = "INSERT INTO pol_politician_functions(politician, party, region, category, time_start, time_end, description)
							VALUES(%i, %i, %i, -1, %s, %s, NULL)";
					$sql = $this->db->formatQuery($sql, $my_pol[0], $party_map[$party][0], $region[0], $time_start, $time_end);

					$this->message('pre-sql', htmlentities($sql));
					$res = $this->db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					$this->message('post-sql', "Success. Politician '{$my_pol[1]}' is registered in region '{$region[1]}' for period [{$time_start} - {$time_end}].");
				}
			}
		}

		$this->message('end', 'Complete');
		
		
	}


	/** generate page */
	public function show2($smarty) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Inserting data from politix database voorstellen2006</title>
</head>

<body>
<h1>Importing data from politix database: voorstellen2006</h1>
<?php
		foreach ($this->messages as $rec) {
			$type = $rec[0];
			$msg = $rec[1];

			switch ($type) {
				case 'begin': echo "<h3 style='color: #555'>{$msg}</h3>\n"; break;
				case 'end': echo "<div style='color: #555; font-weight: bold'>{$msg}</div>\n"; break;
				case 'pre-sql': echo "<div style='font-family: monospace; color: #333; background-color: #efefef; margin-top: 3px;'><span style='color: orange;'>Executing:</span> {$msg}</div>\n"; break;
				case 'post-sql': echo "<div style='color: darkgreen; background-color: #efefef; margin-bottom: 3px;'>{$msg}</div>\n"; break;
				case 'info': echo "<div style='font-family: Verdana, sans-serif; font-size: 14px; margin-top: 10px;'>{$msg}</div>\n"; break;
				case 'global-succes': echo "<h1 style='width: 300px; margin-left: auto; margin-right: auto; color: green;'>{$msg}</h1>\n"; break;
				case 'sql-error': echo "<div><span style='color: red; font-weight: bold;'>Rollback on error: </span> {$msg}</div>\n"; break;
				case 'sql-error-query': echo "<div style='fond-family: monospace;'>{$msg}</div>\n"; break;
				case 'sql-error-detail': echo "<div style='font-family: font-family: Verdana, sans-serif; font-size: 16px; border: 1px solid red;'>{$msg}</div>\n"; break;
				case 'warning': echo "<div style='font-family: font-family: Verdana, sans-serif; font-size: 16px; color: red;'>{$msg}</div>\n"; break;

				default: echo "<div>{$msg}</div>";
			}
		}
?>
</body>
</html>
<?php

	}

	/** report message. */
	private function message($type, $msg) {
		$this->messages[] = array($type, $msg);
	}
}

?>
