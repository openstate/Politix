<?php


/** Patch set page */
class RaadsstukkenPatchPage {

	public function processGet($get) {
		$db = DBs::inst(DBs::SYSTEM);


		$tags = array (
  0 =>
  array (
    'name' => 'Cradle to cradle',
    'old-id' => '2209',
  ),
  1 =>
  array (
    'name' => 'Almere 2030+',
    'old-id' => '2210',
  ),
  2 =>
  array (
    'name' => 'Integraal Afspraken Kader (IAK)',
    'old-id' => '2212',
  ),
); //[sys_tags]

		$pol_functions = array (
  0 =>
  array (
    'politician' => '160',
    'party' => '1',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '203',
  ),
  1 =>
  array (
    'politician' => '175',
    'party' => '43',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '218',
  ),
  2 =>
  array (
    'politician' => '176',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '219',
  ),
  3 =>
  array (
    'politician' => '177',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-04-27 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '220',
  ),
  4 =>
  array (
    'politician' => '178',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '221',
  ),
  5 =>
  array (
    'politician' => '179',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '222',
  ),
  6 =>
  array (
    'politician' => '180',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '223',
  ),
  7 =>
  array (
    'politician' => '181',
    'party' => '44',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2006-03-16 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '224',
  ),
  8 =>
  array (
    'politician' => '296',
    'party' => '28',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2008-01-22 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '337',
  ),
  9 =>
  array (
    'politician' => '158',
    'party' => '51',
    'region' => '27',
    'category' => '-1',
    'time_start' => '2007-11-23 00:00:00',
    'time_end' => 'infinity',
    'description' => '',
    'old-id' => '387',
  ),
); //[pol_politician_functions]

		$raadsstukken = array (
  0 =>
  array (
    'region' => '27',
    'title' => 'Programmarekening 2007',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>In de programmarekening 2007 legt het college van burgemeester en wethouders verantwoording af over het rekeningsjaar 2007.</p><p>De raad wordt verzocht in te stemmen met de resultaatbestemming over 2007.</p>',
    'code' => '2008 RV 48',
    'type' => '1',
    'result' => '1',
    'submitter' => '1',
    'parent' => '',
    'show' => '0',
    'dependent' => false,
    'old-id' => '2082',
  ),
  1 =>
  array (
    'region' => '27',
    'title' => 'Plan van scholen Primair Onderwijs 2009-2012',
    'vote_date' => '2008-06-05 00:00:00',
    'summary' => '<p>Om voor bekostiging door het ministerie van Onderwijs, Cultuur en Wetenschap (OCW) in aanmerking te komen dient een nieuw te stichten openbare of bijzondere basisschool te worden opgenomen in het door de gemeente vast te stellen &quot;Plan van Scholen&quot;. Het Plan van Scholen bestrijkt drie achtereenvolgende schooljaren, volgend op het jaar van de vaststelling. De gemeenteraad stelt het Plan van Scholen vóór 1 augustus vast en stuurt dit binnen 2 weken ter goedkeuring naar OCW. De Minister besluit vóór 1 januari. </p>',
    'code' => '2008 RV 50',
    'type' => '1',
    'result' => '1',
    'submitter' => '1',
    'parent' => '',
    'show' => '0',
    'dependent' => false,
    'old-id' => '2074',
  ),
  2 =>
  array (
    'region' => '27',
    'title' => 'Verordeningen Persoonsgebonden Budget Begeleid Werken en Cliëntenparticipatie Wsw',
    'vote_date' => '2008-06-05 00:00:00',
    'summary' => '<p>Op 10 april 2008 heeft uw Raad ingestemd met de uitgangspunten die wij hebben geformuleerd voor de modernisering van de Wsw. Ook de Raden van de andere gemeenten die in de Gemeenschappelijke Regeling Tomingroep (GR) deelnemen, hebben ingestemd met de uitgangspunten.</p><p>Nadeze instemming heeft het college deze uitgangspunten uitgewerkt tot twee verordeningen, een voor het Persoonsgebonden Budget Begeleid Werken voor de Wsw, en een voor Cliëntenparticipatie binnen de Wsw. Met voorliggend voorstel wordt gevraagd beide verordeningen vast te stellen, zodat deze per 1 juli 2008 in werking kunnen treden. </p>',
    'code' => '2008 RV 51',
    'type' => '1',
    'result' => '1',
    'submitter' => '1',
    'parent' => '',
    'show' => '0',
    'dependent' => false,
    'old-id' => '2078',
  ),
  3 =>
  array (
    'region' => '27',
    'title' => 'Ontwikkelingsplan en grondexploitatie Almere Poort Olympiakwartier & Office Park',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Voor de verdere uitwerking en realisatie van Olympiakwartier en Officepark, zoals die in het structuurplan voor Poort, het bestemmingsplan en de Mastervisie zijn vastgelegd is het noodzakelijk een Ontwikkelingsplan op te stellen. Hierbij wordt het proces gevolgd zoals in de User manual is vastgelegd. Teneinde te komen tot een daadwerkelijke realisatie van de plannen moet het financiële kader: de Grondexploitatie worden vastgesteld.</p>',
    'code' => '2008 RV 53',
    'type' => '1',
    'result' => '1',
    'submitter' => '1',
    'parent' => '',
    'show' => '0',
    'dependent' => false,
    'old-id' => '2080',
  ),
  4 =>
  array (
    'region' => '27',
    'title' => 'Voorjaarsnota 2009-2012',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>In de Verordening op de Bedrijfsvoering is vastgelegd dat de gemeenteraad jaarlijks een Voorjaarsnota wordt aangeboden. </p><p>Bedragen worden beschikbaar gesteld door deze op te nemen in de begroting. De Voorjaarsnota bevat een actualisatie van de begroting 2008, alsmede een actualisatie van de meerjarenbegroting.</p><p>&nbsp;</p><p>De gemeenteraad wordt gevraagd de voorjaarsnota 2009-2012 vast te stellen.</p>',
    'code' => '2008 RV 49',
    'type' => '1',
    'result' => '1',
    'submitter' => '1',
    'parent' => '',
    'show' => '0',
    'dependent' => false,
    'old-id' => '2083',
  ),
  5 =>
  array (
    'region' => '27',
    'title' => 'Filmhuis Cinescoop stoppen',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Op basis van een doorstartplan van de stichting Filmhuis Die Blechtrommel heeft het college in april 2008 besloten het Filmhuis te subsidiëren voor € 150.000 per jaar. Leefbaar Almere is van oordeel dat het plan van stichting Filmhuis Die Blechtrommel meer het karakter heeft van een wervende tekst dan van een deugdelijk bedrijfsplan en dat er geen aanwijzingen zijn dat de capaciteiten, kansen en risico’s van de stichting gewijzigd zijn ten opzichte van de periode waarin de stichting bijna failliet ging. Leefbaar Almere vindt dat we een culturele voorziening als het filmhuis óf in voldoende mate moeten subsidiëren óf moeten schrappen van de lijst te subsidiëren cultuurvoorzieningen, maar niet moeten aanmodderen. Leefbaar Almere kiest voor stoppen met de subsidie voor het Filmhuis, omdat we andere voorzieningen – b.v. Casla, de Paviljoens, Cultuurcentrum Corrosia, de Glasbak - nu belangrijker vinden en bovendien financieel minder riskant. </p>',
    'code' => '2008 RG 100',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2095',
  ),
  6 =>
  array (
    'region' => '27',
    'title' => 'Filmhuis Cinescoop; gostbusters',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Gehoord de beraadslaging, </p><p>het volgende overwegend</p><p>Najaar 2007 is er op ons initiatief op de politieke markt gesproken met een filmhuis deskundige met vragen over de noodzaak van subsidiëring voor een Filmhuis, de huidige kansen voor groei en noodzakelijke investeringen <br />• Zowel de filmhuis deskundige als de stichting Filmhuis Die Blechtrommel schat dat minimaal € 150.000 per jaar nodig is om de voorziening op het huidige magere niveau te handhaven; ontwikkeling en uitbreiding van het bereik zit er dan niet in, want daarvoor zijn forse investeringen nodig<br />• In november 2007 (Begroting 2008) wilde het college er eigenlijk mee stoppen en kende een eenmalige afbouw subsidie toe van € 100.000<br />• In februari 2008 heeft de stichting Filmhuis Die Blechtrommel een plan ingediend voor een doorstart van het tot dan toe bedrijfsmatig mislukte Filmhuis<br />• April 2008 heeft het college blijkens de meerjarenbegroting Voorjaarsnota 2009-2012 besloten het Filmhuis te subsidiëren met € 150.000 per jaar</p><p>Van oordeel <br />1. dat het plan van stichting Filmhuis Die Blechtrommel meer het karakter heeft van een wervende tekst dan van een deugdelijk bedrijfsplan <br />2. dat er geen aanwijzingen zijn dat de capaciteiten, kansen en risico’s van de stichting gewijzigd zijn ten opzichte van de periode waarin de stichting bijna failliet ging<br />3. dat we een culturele voorziening als het filmhuis óf in voldoende mate moeten subsidiëren óf moeten schrappen van de lijst te subsidiëren cultuurvoorzieningen, maar niet moeten laten aanmodderen<br />4. dat wij kiezen voor stoppen met de subsidie voor het Filmhuis, omdat we andere voorzieningen – b.v. Casla, de Paviljoens, Cultuurcentrum Corrosia, de Glasbak - nu belangrijker vinden en bovendien financieel minder riskant</p>',
    'code' => '2008 RG 101',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2096',
  ),
  7 =>
  array (
    'region' => '27',
    'title' => 'Amateurkunstgebouwen',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>De kunstzinnige vorming in Almere geniet veel belangstelling en draagvlak. Er is onvoldoende (betaalbare) accommodatieruimte voor de beoefening van de amateurkunst. De samenbindende functie van cultuur binnen de gemeenschap levert een belangrijke bijdrage aan leefbaarheid en aantrekkingskracht op gebiedsniveau. Daarom verzoekt de Almere Partij het college te investeren in ruimten voor de amateurskunstbeoefening, een amateurkunstgebouw te realiseren in Almere Haven en hiervoor in de begroting van de Voorjaarsnota 2009 – 2012 “Vrije tijd” financiële ruimte te reserveren.</p>',
    'code' => '2008 RG 102',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2097',
  ),
  8 =>
  array (
    'region' => '27',
    'title' => 'Veiligheid en buurtregie',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>De ambities van het college voor het veilig houden van Almere kunnen terecht als hoog worden gekwalificeerd. In het kader van veiligheid, is extra toezicht gewenst in de diverse woonwijken, in het uitgaanscentrum en winkelgebied in het stadshart, waarmee het veiligheidsgevoel van de burger van Almere, zowel objectief als subjectief, zal toenemen. De indieners van deze motie verzoeken het College het beschikbare extra budget van 500.000 euro (begroting 2009) t.b.v. een integrale wijkaanpak in te zetten voor een verhoogde  inzet van wijkagenten en toezichthouders, waardoor, in de vorm van buurtregie, de gebiedsgebonden (politie)zorg in de diverse wijken zal verbeteren.</p>',
    'code' => '2008 RG 103',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2098',
  ),
  9 =>
  array (
    'region' => '27',
    'title' => 'Sportparken',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Sportbeoefening, al dan niet in georganiseerd verband, is een belangrijk kenmerk van Almere. Sportverenigingen zijn van groot belang voor de sociale samenhang, juist in een snel groeiende stad als Almere. Sportverenigingen moeten niet alleen mentaal maar ook fysiek midden in de samenleving staan. Het verplaatsen van sportparken naar de randen van de stad is niet wenselijk. Het college heeft aangegeven dat een onderzoek naar woningbouw op het Sportpark Klein Brandt de facto van de baan is. De indieners van deze motie roepen het college op uit te spreken dat sportparken niet naar de randen van de Stadsdelen  worden verplaatst en er grote terughoudendheid wordt betracht bij herontwikkeling van Sportparken.</p>',
    'code' => '2008 RG 104',
    'type' => '4',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2099',
  ),
  10 =>
  array (
    'region' => '27',
    'title' => 'Toekomstige beheerkosten nieuwe stad',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Vervanging en Groot Onderhoud van de Openbare Ruimte kent een structureel budgettekort. Volgens het Structuurplan Almere-Poort komt hier in de toekomst een tekort bij, omdat de beheerskosten van Almere-Poort hoger zijn dan de norm voor betaalbaar onderhoud in de toekomst. Het verhogen van die beheersnorm voor de nieuwe stad lost het probleem niet op, want uiteindelijk moet Vervanging en Groot Onderhoud gewoon betaald worden. De resultaten van de beheerstoets moeten leiden tot aanpassing van de stedenbouwkundige plannen, en niet andersom, namelijk dat stedenbouwkundige plannen leiden tot te hoge beheerskosten. </p>',
    'code' => '2008 RG 105',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2101',
  ),
  11 =>
  array (
    'region' => '27',
    'title' => 'Bewlonersparticipatie herontwikkeling Grote Markt',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>In de voorjaarsnota wordt het voornemen geuit om de Grote Markt om te vormen en in te richten als een hoogwaardig horecaplein. GroenLinks roept het college op om de herontwikkeling van het plein te starten met een ideeënmarkt en de diverse belanghebbenden (zoals inwoners, horeca, detailhandel en andere bedrijvigheid) van Almere in een vergaande vorm van participatie, namelijk als coproducent, te betrekken bij de herontwikkeling van de Grote Markt. </p>',
    'code' => '2008 RG 106',
    'type' => '4',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2102',
  ),
  12 =>
  array (
    'region' => '27',
    'title' => 'Betrokkenheid bewoners bij integrale wijkaanpak',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Het college wil volgens de voorjaarsnota graag partners betrekken bij de integrale wijkaanpak, maar vergeet daarbij de bewoners. We kunnen niet zonder bewoners, zij zijn het cement van de buurt.  GroenLinks roept het college op bewonersorganisaties een bedrag van 2000,- te geven voor het draaien van een bewonersorganisatie in de wijk (huren vergaderruimte, versturen post, etc.), ook nadat de steun vanuit De Schoor is gestopt. Het benodigde bedrag voor ondersteuning van bewonersorganisaties van maximaal 100.000,- te betalen uit het rijksbudget voor bewonersparticipatie danwel het budget voor integrale wijkaanpak.</p><p>&#160;</p>',
    'code' => '2008 RG 107',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2103',
  ),
  13 =>
  array (
    'region' => '27',
    'title' => 'Minder verkeersborden',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Deregulering kan ook geld opleveren! In een Zeeuws dorp is het gelukt. Alle (!) verkeersborden zijn afgeschaft. Slechts in één straat doen zich af en toe problemen voor. Nooit meer nieuwe borden plaatsen, nooit meer beschadigde borden vervangen. Het CDA verzoekt het College te bevorderen dat het aantal verkeersborden in de gemeente Almere tot een minimum wordt beperkt en over de daartoe te nemen maatregelen te rapporteren aan de raad.</p>',
    'code' => '2008 RG 109',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2104',
  ),
  14 =>
  array (
    'region' => '27',
    'title' => 'Buurthuizen',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Het College legt de nadruk op het buurtgericht werken en verschillende wijken zijn aan (her)ontwikkeling toe. De sociaal-maatschappelijke functie van buurthuizen geeft een belangrijke bijdrage aan de leefomgeving. Deze ontmoetingsplaatsen geven mogelijkheden tot het ondernemen van activiteiten voor jongeren en ouderen. Dit betekent een positieve impuls voor de sociale cohesie in Almere.</p><p>Verzoekt het college de (her)opening van buurthuizen in de diverse wijken, in samenwerking met De Schoor, te realiseren en in de Voorjaarsnota 2009 – 2012 structureel financiële ruimte te reserveren voor de ontwikkeling van buurthuizen.</p>',
    'code' => '2008 RG 110',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2105',
  ),
  15 =>
  array (
    'region' => '27',
    'title' => 'Planexploitatie Poort',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Almere Poort heeft nu een negatieve grondexploitatie van uiteindelijk € 11,3 miljoen. Dit betekent dat er uiteindelijk in de bestaande stad minder geïnvesteerd kan worden om de investeringen in de nieuwe stad te kunnen betalen. Het andersom zou moeten zijn. Negatieve grondexploitaties lijken minder opvallend negatief als je ze maar uitsmeert over vele decennia. De momenten van investeringen en die van de opbrengsten moeten niet al te ver uit elkaar liggen ten dienste van de overzichtelijkheid en ten dienste van een politieke afweging. </p><p>Leefbaar Almere verzoekt het college de negatieve grondexploitatie van Almere Poort geleidelijk om te zetten in een positieve grondexploitatie en zo min mogelijk gebruik te maken van de methode ‘tegenvallers uitsmeren naar de verre toekomst’.</p>',
    'code' => '2008 RG 113',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2106',
  ),
  16 =>
  array (
    'region' => '27',
    'title' => 'Studentenhuisvesting',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>In afwachting van de begroting 2009 en de daaraan voorafgaande discussie is de fractie van de SP van mening dat door groots inzetten van het aantrekken van hoger onderwijs (1 miljoen euro) ook specifieker aandacht gegeven moet worden aan de hieruit voortvloeiende vraag naar studentenhuisvesting in Almere. Aandacht hiervoor in de voorjaarsnota is voor de SP een kwestie van verstandig vooruit denken. </p><p>Voorstel: Aan paragraaf 2.2.van de voorjaarsnota; bij “actualisatie en perspectief“een 4e punt toe te voegen waarin beleid en financiële verantwoording m.b.t. studentenhuisvesting nader worden uitgewerkt.</p>',
    'code' => '2008 RG 83',
    'type' => '3',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2084',
  ),
  17 =>
  array (
    'region' => '27',
    'title' => 'Toezicht veiligheid versus duurzaamheidslaboratorium',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Ondergetekenden stellen het volgende amendement voor:</p><p>Beslispunt 1: ‘De voorjaarsnota 2009-2012 vaststellen’ wordt vervangen door: de voorjaarsnota 2009-2012 vaststellen met de volgende wijziging: In het kader van toezicht veiligheid ER doel 4.7, dient extra boven op het bedrag van 500.000 euro in 2009 355.000 euro en in 2010 215.000 euro opgevoerd te worden. De dekking hieruit kan worden gevonden in het laten vervallen van het duurzaamheidlaboratorium in tabel 2-11. </p>',
    'code' => '2008 RG 85',
    'type' => '3',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2085',
  ),
  18 =>
  array (
    'region' => '27',
    'title' => 'Ondersteuning raad bij IAK',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Het opstellen van het integraal afsprakenkader (IAK) is een van de belangrijkste opgaven voor Almere in de komende twee jaar.<br />Om de behandeling van voorstellen goed voor te bereiden in de beperkte tijd van de raadsleden vraagt dit om een excellente ondersteuning van de raad. Daartoe zal bij de griffie een tijdelijk medewerker worden aangesteld, die voor de bijzondere ondersteuning van de raad bij project IAK zal zorg dragen. </p><p>Beslispunt 1.‘De voorjaarsnota 2009-2012 vaststellen.’ wordt vervangen door: `De voorjaarsnota 2009-2012 vaststellen met de volgende wijziging:<br />a. Het bedrag eenmalig nieuw beleid voorstellen, te wijzigen van € 15.393.000 in € 15.553.000. <br />b. Ten behoeve van de ondersteuning raad bij ontwikkeling integraal afspraken kader Almere c.a..<br />c. te dekken uit de nog beschikbare ruimte eenmalig nieuw beleid’ </p>',
    'code' => '2008 RG 86',
    'type' => '3',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2086',
  ),
  19 =>
  array (
    'region' => '27',
    'title' => 'Bibliotheek Poort uit GIP verwijderen',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>De VVD is van mening dat een fysieke locatie voor een bibliotheek in Poort niet langer gewenst is door het dalende aantal uitgeleende boeken van bibliotheken, de vergaande digitalisering van de samenleving en in Almere Stad komt een zeer moderne bibliotheek waar ook inwoners uit Poort gebruik van kunnen maken. Daar tegenover staat dat er nog geen middelen zijn om noodzakelijke bevolkingsvolgende sportvoorzieningen in Poort aan te leggen. De VVD legt de prioriteit bij de sportvoorzieningen. </p><p><br />Ondergetekende stelt het volgende amendement voor:</p><p>Beslispunt 1.‘De voorjaarsnota 2009-2012 vaststellen.’ wordt vervangen door: `De voorjaarsnota 2009-2012 vaststellen met de volgende wijziging:<br />Bij de actualisatie van de harde investeringen in het Gemeentelijk investeringsplan de investering voor een bibliotheek in Almere Poort à € 2 miljoen te laten vervallen en deze middelen te reserveren voor het Sportpark West in Almere Poort.</p>',
    'code' => '2008 RG 87',
    'type' => '3',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2087',
  ),
  20 =>
  array (
    'region' => '27',
    'title' => 'Imagocampagne',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Almeerders zijn elk jaar meer tevreden over hun stad. Zij zijn de goede ambassadeurs die het imago van Almere kunnen helpen vergroten. Een stad met goede culturele voorzieningen draagt aanzienlijk bij aan versterking van het imago. Het voorgestelde bedrag kan beter besteed worden aan investeringen in culturele voorzieningen, zoals Almere 2018 cultuurhoofdstad. </p><p>Voorstel: In de Voorjaarsnota op pag. 41, punt 5 over de investering in de imagocampagne te schrappen.</p>',
    'code' => '2008 RG 88',
    'type' => '3',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2088',
  ),
  21 =>
  array (
    'region' => '27',
    'title' => 'Opvang Almeerse dakloze psychiatrische patiënten',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>De raad en het college maken zich zorgen over de opvang en/of nazorg c.q. begeleiding van dakloze psychiatrische patiënten, in het bijzonder patiënten met een dubbele diagnostiek (politieke markt 13 maart 2008).<br />Het betreft op jaarbasis ongeveer vijf dakloze patiënten. Verzoekt het college vóór de begroting een plan van aanpak c.q. raadsvoorstel te presenteren waarin op korte termijn een (tijdelijke) voorziening wordt gerealiseerd, zodat inwoners van Almere die psychiatrische zorg en begeleiding behoeven niet langer op straat aan hun lot worden overgelaten.</p><p>&#160;</p><p>&#160;</p>',
    'code' => '2008 RG 90',
    'type' => '4',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2089',
  ),
  22 =>
  array (
    'region' => '27',
    'title' => 'Onderzoek gebruikersruimte verslaafden',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Het is onwenselijk dat Almere verslaafden gaat faciliteren. Door drugsgebruik te reguleren wordt een verkeerd signaal afgegeven. Bij de totstandkoming van het huidige coffeeshopbeleid is toegezegd dat hierdoor wering van harddrugs in de stad mogelijk was en het nu willen realiseren van een gebruikersruimte taat hier tegen in. De VVD wil het verslavingsbeleid richten op ontmoediging, terugdringen en handhaving en wil geen gebruikersruimte voor verslaafden in Almere realiseren en stelt voor een haalbaarheidsonderzoek hiernaar te schrappen.</p>',
    'code' => '2008 RG 93',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2090',
  ),
  23 =>
  array (
    'region' => '27',
    'title' => 'Stedelijk Kompas Flevoland',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Overwegende dat wij als gemeente Almere reeds 4 jaar 1,5 miljoen euro tekortkomen voor de maatschappelijke opvang, willen wij met deze motie het college ondersteunen in hun acties naar kabinet en tweede kamer toe om dit (laatste) T-min-probleem op te lossen.<br />Roept het Kabinet en de Tweede Kamer op om met spoed te besluiten tot een gelijkwaardige verdeling van de gelden voor maatschappelijke opvang en niet alleen de G4 hierin te ‘bevoordelen’. </p><p><br /> </p>',
    'code' => '2008 RG 94',
    'type' => '4',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2091',
  ),
  24 =>
  array (
    'region' => '27',
    'title' => 'Subsidie adviesorgaan senioren',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>Het college van mening is dat door invoering van de WMO het subsidiëren van het Adviesorgaan Senioren geen toegevoegde waarde meer zou hebben. De subsidiëring van het Adviesorgaan Senioren gemeente Almere daarom met ingang van 2009 wordt beëindigd (zie ook: blz. 24 van de begroting 2008). Het Adviesorgaan Senioren draagt bij uitstek zorg voor een onafhankelijke advisering, op basis van deskundigheid en netwerk. Deze motie draagt het college op bij de verdere voorbereiding van de begroting 2009 de subsidie voor het Advies Orgaan Senioren (à 16.000 euro) niet te beëindigen.<br /></p><p></p><p>&#160;</p>',
    'code' => '2008 RG 95',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2092',
  ),
  25 =>
  array (
    'region' => '27',
    'title' => 'Regeling bibliotheekabonnement',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>De bibliotheek in Almere zou een gratis of gereduceerd abonnement moeten aanbieden voor minima en studenten. Uit onderzoek is gebleken dat lang niet iedereen 35 euro voor een jaarabonnement kan opbrengen. Uit oogpunt van educatie, maatschappelijke participatie en ontspanning moet het mogelijk zijn dat in principe iedereen gebruik kan maken van de bibliotheek in Almere. De Almere Partij verzoekt het college dit voorstel inzake het gratis, ofwel met reductie, verstrekken van een bibliotheekabonnement, z.s.m. te bewerkstelligen.</p><p>&#160;</p>',
    'code' => '2008 RG 96',
    'type' => '4',
    'result' => '2',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2093',
  ),
  26 =>
  array (
    'region' => '27',
    'title' => 'Werkgelegenheid in Almere',
    'vote_date' => '2008-06-12 00:00:00',
    'summary' => '<p>In het Integraal Afspraken Kader is neergelegd, dat er bij de schaalsprong van Almere 100.000 arbeidsplaatsen bij zullen komen. In de Voorjaarsnota wordt er met geen woord gerept over arbeidsplaatsen, werkgelegenheid en ondernemersklimaat. D66 roept het college op om bij de begrotingsbehandeling te komen met uitgebreide voorstellen, om de ambities neergelegd in het Werkplan van het college en het Integraal Afspraken Kader waar te maken.</p><p>&#160;</p>',
    'code' => '2008 RG 99',
    'type' => '4',
    'result' => '1',
    'submitter' => '3',
    'parent' => '2083',
    'show' => '0',
    'dependent' => true,
    'old-id' => '2094',
  ),
); //[rs_raadsstukken]

		$votes_data = array (
  0 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73792',
  ),
  1 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73793',
  ),
  2 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73794',
  ),
  3 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73795',
  ),
  4 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73796',
  ),
  5 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73797',
  ),
  6 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73798',
  ),
  7 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73799',
  ),
  8 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73800',
  ),
  9 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2074',
    'vote' => '3',
    'old-id' => '73801',
  ),
  10 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73802',
  ),
  11 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73803',
  ),
  12 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73804',
  ),
  13 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73805',
  ),
  14 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73806',
  ),
  15 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73807',
  ),
  16 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73808',
  ),
  17 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73809',
  ),
  18 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2074',
    'vote' => '3',
    'old-id' => '73810',
  ),
  19 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73811',
  ),
  20 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73812',
  ),
  21 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73813',
  ),
  22 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73814',
  ),
  23 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73815',
  ),
  24 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73816',
  ),
  25 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73817',
  ),
  26 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73818',
  ),
  27 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73819',
  ),
  28 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73820',
  ),
  29 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73821',
  ),
  30 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73822',
  ),
  31 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2074',
    'vote' => '3',
    'old-id' => '73823',
  ),
  32 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73824',
  ),
  33 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73825',
  ),
  34 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73826',
  ),
  35 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73827',
  ),
  36 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73828',
  ),
  37 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73829',
  ),
  38 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2074',
    'vote' => '0',
    'old-id' => '73830',
  ),
  39 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73831',
  ),
  40 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73832',
  ),
  41 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73833',
  ),
  42 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73834',
  ),
  43 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73835',
  ),
  44 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73836',
  ),
  45 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73837',
  ),
  46 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73838',
  ),
  47 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73839',
  ),
  48 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2078',
    'vote' => '3',
    'old-id' => '73840',
  ),
  49 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73841',
  ),
  50 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73842',
  ),
  51 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73843',
  ),
  52 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73844',
  ),
  53 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73845',
  ),
  54 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73846',
  ),
  55 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73847',
  ),
  56 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73848',
  ),
  57 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2078',
    'vote' => '3',
    'old-id' => '73849',
  ),
  58 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73850',
  ),
  59 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73851',
  ),
  60 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73852',
  ),
  61 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73853',
  ),
  62 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73854',
  ),
  63 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73855',
  ),
  64 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73856',
  ),
  65 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73857',
  ),
  66 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73858',
  ),
  67 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73859',
  ),
  68 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73860',
  ),
  69 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73861',
  ),
  70 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2078',
    'vote' => '3',
    'old-id' => '73862',
  ),
  71 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73863',
  ),
  72 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73864',
  ),
  73 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73865',
  ),
  74 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73866',
  ),
  75 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73867',
  ),
  76 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73868',
  ),
  77 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2078',
    'vote' => '0',
    'old-id' => '73869',
  ),
  78 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73909',
  ),
  79 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73910',
  ),
  80 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73911',
  ),
  81 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73912',
  ),
  82 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73913',
  ),
  83 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73914',
  ),
  84 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73915',
  ),
  85 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73916',
  ),
  86 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73917',
  ),
  87 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2080',
    'vote' => '1',
    'old-id' => '73918',
  ),
  88 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2080',
    'vote' => '1',
    'old-id' => '73919',
  ),
  89 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2080',
    'vote' => '1',
    'old-id' => '73920',
  ),
  90 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73921',
  ),
  91 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73922',
  ),
  92 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73923',
  ),
  93 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73924',
  ),
  94 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73925',
  ),
  95 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73926',
  ),
  96 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2080',
    'vote' => '3',
    'old-id' => '73927',
  ),
  97 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73928',
  ),
  98 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73929',
  ),
  99 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73930',
  ),
  100 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73931',
  ),
  101 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73932',
  ),
  102 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73933',
  ),
  103 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2080',
    'vote' => '3',
    'old-id' => '73934',
  ),
  104 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73935',
  ),
  105 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73936',
  ),
  106 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2080',
    'vote' => '3',
    'old-id' => '73937',
  ),
  107 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73938',
  ),
  108 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73939',
  ),
  109 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73940',
  ),
  110 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73941',
  ),
  111 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73942',
  ),
  112 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73943',
  ),
  113 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73944',
  ),
  114 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73945',
  ),
  115 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73946',
  ),
  116 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2080',
    'vote' => '0',
    'old-id' => '73947',
  ),
  117 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73987',
  ),
  118 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73988',
  ),
  119 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73989',
  ),
  120 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73990',
  ),
  121 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73991',
  ),
  122 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73992',
  ),
  123 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73993',
  ),
  124 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73994',
  ),
  125 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73995',
  ),
  126 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73996',
  ),
  127 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73997',
  ),
  128 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73998',
  ),
  129 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '73999',
  ),
  130 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74000',
  ),
  131 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74001',
  ),
  132 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74002',
  ),
  133 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74003',
  ),
  134 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74004',
  ),
  135 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2082',
    'vote' => '3',
    'old-id' => '74005',
  ),
  136 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74006',
  ),
  137 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74007',
  ),
  138 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74008',
  ),
  139 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74009',
  ),
  140 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74010',
  ),
  141 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74011',
  ),
  142 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2082',
    'vote' => '3',
    'old-id' => '74012',
  ),
  143 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74013',
  ),
  144 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74014',
  ),
  145 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2082',
    'vote' => '3',
    'old-id' => '74015',
  ),
  146 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2082',
    'vote' => '1',
    'old-id' => '74016',
  ),
  147 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2082',
    'vote' => '1',
    'old-id' => '74017',
  ),
  148 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2082',
    'vote' => '1',
    'old-id' => '74018',
  ),
  149 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74019',
  ),
  150 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74020',
  ),
  151 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74021',
  ),
  152 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74022',
  ),
  153 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74023',
  ),
  154 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74024',
  ),
  155 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2082',
    'vote' => '0',
    'old-id' => '74025',
  ),
  156 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74026',
  ),
  157 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74027',
  ),
  158 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74028',
  ),
  159 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74029',
  ),
  160 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74030',
  ),
  161 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74031',
  ),
  162 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74032',
  ),
  163 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74033',
  ),
  164 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74034',
  ),
  165 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74035',
  ),
  166 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74036',
  ),
  167 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74037',
  ),
  168 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74038',
  ),
  169 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74039',
  ),
  170 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74040',
  ),
  171 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74041',
  ),
  172 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74042',
  ),
  173 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74043',
  ),
  174 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2083',
    'vote' => '3',
    'old-id' => '74044',
  ),
  175 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74045',
  ),
  176 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74046',
  ),
  177 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74047',
  ),
  178 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74048',
  ),
  179 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74049',
  ),
  180 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74050',
  ),
  181 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2083',
    'vote' => '3',
    'old-id' => '74051',
  ),
  182 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74052',
  ),
  183 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74053',
  ),
  184 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2083',
    'vote' => '3',
    'old-id' => '74054',
  ),
  185 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74055',
  ),
  186 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74056',
  ),
  187 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2083',
    'vote' => '1',
    'old-id' => '74057',
  ),
  188 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74058',
  ),
  189 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74059',
  ),
  190 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74060',
  ),
  191 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74061',
  ),
  192 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74062',
  ),
  193 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74063',
  ),
  194 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2083',
    'vote' => '0',
    'old-id' => '74064',
  ),
  195 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74065',
  ),
  196 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74066',
  ),
  197 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74067',
  ),
  198 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74068',
  ),
  199 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74069',
  ),
  200 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74070',
  ),
  201 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74071',
  ),
  202 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74072',
  ),
  203 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74073',
  ),
  204 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74074',
  ),
  205 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74075',
  ),
  206 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74076',
  ),
  207 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74077',
  ),
  208 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74078',
  ),
  209 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74079',
  ),
  210 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74080',
  ),
  211 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74081',
  ),
  212 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74082',
  ),
  213 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2084',
    'vote' => '3',
    'old-id' => '74083',
  ),
  214 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74084',
  ),
  215 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74085',
  ),
  216 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74086',
  ),
  217 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74087',
  ),
  218 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74088',
  ),
  219 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74089',
  ),
  220 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2084',
    'vote' => '3',
    'old-id' => '74090',
  ),
  221 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74091',
  ),
  222 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74092',
  ),
  223 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2084',
    'vote' => '3',
    'old-id' => '74093',
  ),
  224 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74094',
  ),
  225 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74095',
  ),
  226 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2084',
    'vote' => '0',
    'old-id' => '74096',
  ),
  227 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74097',
  ),
  228 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74098',
  ),
  229 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74099',
  ),
  230 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74100',
  ),
  231 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74101',
  ),
  232 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74102',
  ),
  233 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2084',
    'vote' => '1',
    'old-id' => '74103',
  ),
  234 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74104',
  ),
  235 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74105',
  ),
  236 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74106',
  ),
  237 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74107',
  ),
  238 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74108',
  ),
  239 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74109',
  ),
  240 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74110',
  ),
  241 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74111',
  ),
  242 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74112',
  ),
  243 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74113',
  ),
  244 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74114',
  ),
  245 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74115',
  ),
  246 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74116',
  ),
  247 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74117',
  ),
  248 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74118',
  ),
  249 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74119',
  ),
  250 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74120',
  ),
  251 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74121',
  ),
  252 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2085',
    'vote' => '3',
    'old-id' => '74122',
  ),
  253 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74123',
  ),
  254 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74124',
  ),
  255 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74125',
  ),
  256 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74126',
  ),
  257 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74127',
  ),
  258 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74128',
  ),
  259 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2085',
    'vote' => '3',
    'old-id' => '74129',
  ),
  260 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74130',
  ),
  261 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74131',
  ),
  262 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2085',
    'vote' => '3',
    'old-id' => '74132',
  ),
  263 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74133',
  ),
  264 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74134',
  ),
  265 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74135',
  ),
  266 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2085',
    'vote' => '1',
    'old-id' => '74136',
  ),
  267 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74137',
  ),
  268 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74138',
  ),
  269 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74139',
  ),
  270 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74140',
  ),
  271 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74141',
  ),
  272 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2085',
    'vote' => '0',
    'old-id' => '74142',
  ),
  273 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74143',
  ),
  274 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74144',
  ),
  275 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74145',
  ),
  276 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74146',
  ),
  277 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74147',
  ),
  278 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74148',
  ),
  279 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74149',
  ),
  280 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74150',
  ),
  281 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74151',
  ),
  282 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74152',
  ),
  283 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74153',
  ),
  284 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74154',
  ),
  285 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74155',
  ),
  286 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74156',
  ),
  287 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74157',
  ),
  288 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74158',
  ),
  289 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74159',
  ),
  290 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74160',
  ),
  291 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2086',
    'vote' => '3',
    'old-id' => '74161',
  ),
  292 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74162',
  ),
  293 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74163',
  ),
  294 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74164',
  ),
  295 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74165',
  ),
  296 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74166',
  ),
  297 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74167',
  ),
  298 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2086',
    'vote' => '3',
    'old-id' => '74168',
  ),
  299 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74169',
  ),
  300 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74170',
  ),
  301 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2086',
    'vote' => '3',
    'old-id' => '74171',
  ),
  302 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74172',
  ),
  303 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74173',
  ),
  304 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74174',
  ),
  305 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74175',
  ),
  306 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74176',
  ),
  307 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74177',
  ),
  308 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74178',
  ),
  309 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74179',
  ),
  310 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74180',
  ),
  311 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2086',
    'vote' => '0',
    'old-id' => '74181',
  ),
  312 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74182',
  ),
  313 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74183',
  ),
  314 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74184',
  ),
  315 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74185',
  ),
  316 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74186',
  ),
  317 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74187',
  ),
  318 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74188',
  ),
  319 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74189',
  ),
  320 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74190',
  ),
  321 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74191',
  ),
  322 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74192',
  ),
  323 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74193',
  ),
  324 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74194',
  ),
  325 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74195',
  ),
  326 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74196',
  ),
  327 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74197',
  ),
  328 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74198',
  ),
  329 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74199',
  ),
  330 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2087',
    'vote' => '3',
    'old-id' => '74200',
  ),
  331 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74201',
  ),
  332 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74202',
  ),
  333 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74203',
  ),
  334 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74204',
  ),
  335 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74205',
  ),
  336 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74206',
  ),
  337 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2087',
    'vote' => '3',
    'old-id' => '74207',
  ),
  338 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74208',
  ),
  339 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74209',
  ),
  340 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2087',
    'vote' => '3',
    'old-id' => '74210',
  ),
  341 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74211',
  ),
  342 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74212',
  ),
  343 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74213',
  ),
  344 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2087',
    'vote' => '1',
    'old-id' => '74214',
  ),
  345 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74215',
  ),
  346 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74216',
  ),
  347 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74217',
  ),
  348 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74218',
  ),
  349 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74219',
  ),
  350 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2087',
    'vote' => '0',
    'old-id' => '74220',
  ),
  351 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74221',
  ),
  352 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74222',
  ),
  353 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74223',
  ),
  354 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74224',
  ),
  355 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74225',
  ),
  356 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74226',
  ),
  357 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74227',
  ),
  358 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74228',
  ),
  359 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74229',
  ),
  360 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74230',
  ),
  361 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74231',
  ),
  362 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74232',
  ),
  363 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74233',
  ),
  364 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74234',
  ),
  365 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74235',
  ),
  366 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74236',
  ),
  367 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74237',
  ),
  368 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74238',
  ),
  369 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2088',
    'vote' => '3',
    'old-id' => '74239',
  ),
  370 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74240',
  ),
  371 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74241',
  ),
  372 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74242',
  ),
  373 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74243',
  ),
  374 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74244',
  ),
  375 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74245',
  ),
  376 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2088',
    'vote' => '3',
    'old-id' => '74246',
  ),
  377 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74247',
  ),
  378 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74248',
  ),
  379 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2088',
    'vote' => '3',
    'old-id' => '74249',
  ),
  380 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74250',
  ),
  381 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74251',
  ),
  382 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2088',
    'vote' => '0',
    'old-id' => '74252',
  ),
  383 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74253',
  ),
  384 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74254',
  ),
  385 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74255',
  ),
  386 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74256',
  ),
  387 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74257',
  ),
  388 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74258',
  ),
  389 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2088',
    'vote' => '1',
    'old-id' => '74259',
  ),
  390 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74260',
  ),
  391 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74261',
  ),
  392 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74262',
  ),
  393 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74263',
  ),
  394 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74264',
  ),
  395 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74265',
  ),
  396 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74266',
  ),
  397 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74267',
  ),
  398 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74268',
  ),
  399 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74269',
  ),
  400 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74270',
  ),
  401 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74271',
  ),
  402 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74272',
  ),
  403 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74273',
  ),
  404 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74274',
  ),
  405 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74275',
  ),
  406 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74276',
  ),
  407 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74277',
  ),
  408 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2089',
    'vote' => '3',
    'old-id' => '74278',
  ),
  409 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74279',
  ),
  410 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74280',
  ),
  411 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74281',
  ),
  412 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74282',
  ),
  413 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74283',
  ),
  414 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74284',
  ),
  415 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2089',
    'vote' => '3',
    'old-id' => '74285',
  ),
  416 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74286',
  ),
  417 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74287',
  ),
  418 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2089',
    'vote' => '3',
    'old-id' => '74288',
  ),
  419 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74289',
  ),
  420 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74290',
  ),
  421 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74291',
  ),
  422 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2089',
    'vote' => '0',
    'old-id' => '74292',
  ),
  423 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74293',
  ),
  424 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74294',
  ),
  425 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74295',
  ),
  426 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74296',
  ),
  427 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74297',
  ),
  428 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2089',
    'vote' => '1',
    'old-id' => '74298',
  ),
  429 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74299',
  ),
  430 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74300',
  ),
  431 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74301',
  ),
  432 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74302',
  ),
  433 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74303',
  ),
  434 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74304',
  ),
  435 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74305',
  ),
  436 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74306',
  ),
  437 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74307',
  ),
  438 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74308',
  ),
  439 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74309',
  ),
  440 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74310',
  ),
  441 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74311',
  ),
  442 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74312',
  ),
  443 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74313',
  ),
  444 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74314',
  ),
  445 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74315',
  ),
  446 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74316',
  ),
  447 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2090',
    'vote' => '3',
    'old-id' => '74317',
  ),
  448 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74318',
  ),
  449 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74319',
  ),
  450 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74320',
  ),
  451 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74321',
  ),
  452 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74322',
  ),
  453 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74323',
  ),
  454 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2090',
    'vote' => '3',
    'old-id' => '74324',
  ),
  455 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74325',
  ),
  456 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74326',
  ),
  457 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2090',
    'vote' => '3',
    'old-id' => '74327',
  ),
  458 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74328',
  ),
  459 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74329',
  ),
  460 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74330',
  ),
  461 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2090',
    'vote' => '1',
    'old-id' => '74331',
  ),
  462 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74332',
  ),
  463 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74333',
  ),
  464 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74334',
  ),
  465 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74335',
  ),
  466 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74336',
  ),
  467 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2090',
    'vote' => '0',
    'old-id' => '74337',
  ),
  468 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74338',
  ),
  469 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74339',
  ),
  470 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74340',
  ),
  471 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74341',
  ),
  472 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74342',
  ),
  473 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74343',
  ),
  474 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74344',
  ),
  475 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74345',
  ),
  476 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74346',
  ),
  477 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74347',
  ),
  478 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74348',
  ),
  479 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74349',
  ),
  480 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74350',
  ),
  481 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74351',
  ),
  482 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74352',
  ),
  483 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74353',
  ),
  484 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74354',
  ),
  485 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74355',
  ),
  486 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2091',
    'vote' => '3',
    'old-id' => '74356',
  ),
  487 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74357',
  ),
  488 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74358',
  ),
  489 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74359',
  ),
  490 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74360',
  ),
  491 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74361',
  ),
  492 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74362',
  ),
  493 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2091',
    'vote' => '3',
    'old-id' => '74363',
  ),
  494 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74364',
  ),
  495 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74365',
  ),
  496 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2091',
    'vote' => '3',
    'old-id' => '74366',
  ),
  497 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74367',
  ),
  498 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74368',
  ),
  499 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74369',
  ),
  500 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2091',
    'vote' => '0',
    'old-id' => '74370',
  ),
  501 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74371',
  ),
  502 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74372',
  ),
  503 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74373',
  ),
  504 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74374',
  ),
  505 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74375',
  ),
  506 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2091',
    'vote' => '1',
    'old-id' => '74376',
  ),
  507 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2092',
    'vote' => '0',
    'old-id' => '74377',
  ),
  508 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2092',
    'vote' => '0',
    'old-id' => '74378',
  ),
  509 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74379',
  ),
  510 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74380',
  ),
  511 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74381',
  ),
  512 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74382',
  ),
  513 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74383',
  ),
  514 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74384',
  ),
  515 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2092',
    'vote' => '0',
    'old-id' => '74385',
  ),
  516 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74386',
  ),
  517 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74387',
  ),
  518 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74388',
  ),
  519 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74389',
  ),
  520 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74390',
  ),
  521 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74391',
  ),
  522 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74392',
  ),
  523 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74393',
  ),
  524 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74394',
  ),
  525 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2092',
    'vote' => '3',
    'old-id' => '74395',
  ),
  526 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74396',
  ),
  527 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74397',
  ),
  528 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74398',
  ),
  529 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74399',
  ),
  530 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74400',
  ),
  531 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74401',
  ),
  532 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2092',
    'vote' => '3',
    'old-id' => '74402',
  ),
  533 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74403',
  ),
  534 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74404',
  ),
  535 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2092',
    'vote' => '3',
    'old-id' => '74405',
  ),
  536 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74406',
  ),
  537 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74407',
  ),
  538 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74408',
  ),
  539 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74409',
  ),
  540 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74410',
  ),
  541 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74411',
  ),
  542 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74412',
  ),
  543 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74413',
  ),
  544 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74414',
  ),
  545 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2092',
    'vote' => '1',
    'old-id' => '74415',
  ),
  546 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2093',
    'vote' => '0',
    'old-id' => '74416',
  ),
  547 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2093',
    'vote' => '0',
    'old-id' => '74417',
  ),
  548 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74418',
  ),
  549 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74419',
  ),
  550 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74420',
  ),
  551 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74421',
  ),
  552 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74422',
  ),
  553 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74423',
  ),
  554 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74424',
  ),
  555 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74425',
  ),
  556 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74426',
  ),
  557 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74427',
  ),
  558 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74428',
  ),
  559 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74429',
  ),
  560 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74430',
  ),
  561 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74431',
  ),
  562 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74432',
  ),
  563 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74433',
  ),
  564 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2093',
    'vote' => '3',
    'old-id' => '74434',
  ),
  565 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74435',
  ),
  566 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74436',
  ),
  567 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74437',
  ),
  568 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74438',
  ),
  569 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74439',
  ),
  570 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74440',
  ),
  571 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2093',
    'vote' => '3',
    'old-id' => '74441',
  ),
  572 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74442',
  ),
  573 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74443',
  ),
  574 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2093',
    'vote' => '3',
    'old-id' => '74444',
  ),
  575 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2093',
    'vote' => '0',
    'old-id' => '74445',
  ),
  576 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2093',
    'vote' => '0',
    'old-id' => '74446',
  ),
  577 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2093',
    'vote' => '0',
    'old-id' => '74447',
  ),
  578 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74448',
  ),
  579 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74449',
  ),
  580 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74450',
  ),
  581 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74451',
  ),
  582 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74452',
  ),
  583 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74453',
  ),
  584 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2093',
    'vote' => '1',
    'old-id' => '74454',
  ),
  585 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74455',
  ),
  586 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74456',
  ),
  587 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74457',
  ),
  588 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74458',
  ),
  589 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74459',
  ),
  590 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74460',
  ),
  591 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74461',
  ),
  592 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74462',
  ),
  593 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74463',
  ),
  594 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74464',
  ),
  595 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74465',
  ),
  596 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74466',
  ),
  597 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74467',
  ),
  598 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74468',
  ),
  599 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74469',
  ),
  600 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2094',
    'vote' => '1',
    'old-id' => '74470',
  ),
  601 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74471',
  ),
  602 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74472',
  ),
  603 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2094',
    'vote' => '3',
    'old-id' => '74473',
  ),
  604 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74474',
  ),
  605 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74475',
  ),
  606 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74476',
  ),
  607 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74477',
  ),
  608 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74478',
  ),
  609 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74479',
  ),
  610 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2094',
    'vote' => '3',
    'old-id' => '74480',
  ),
  611 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74481',
  ),
  612 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74482',
  ),
  613 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2094',
    'vote' => '3',
    'old-id' => '74483',
  ),
  614 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74484',
  ),
  615 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74485',
  ),
  616 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74486',
  ),
  617 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74487',
  ),
  618 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74488',
  ),
  619 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74489',
  ),
  620 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74490',
  ),
  621 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74491',
  ),
  622 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74492',
  ),
  623 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2094',
    'vote' => '0',
    'old-id' => '74493',
  ),
  624 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74494',
  ),
  625 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74495',
  ),
  626 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74496',
  ),
  627 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74497',
  ),
  628 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74498',
  ),
  629 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74499',
  ),
  630 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74500',
  ),
  631 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74501',
  ),
  632 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74502',
  ),
  633 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74503',
  ),
  634 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74504',
  ),
  635 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74505',
  ),
  636 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74506',
  ),
  637 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74507',
  ),
  638 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74508',
  ),
  639 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2095',
    'vote' => '0',
    'old-id' => '74509',
  ),
  640 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74510',
  ),
  641 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74511',
  ),
  642 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2095',
    'vote' => '3',
    'old-id' => '74512',
  ),
  643 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74513',
  ),
  644 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74514',
  ),
  645 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74515',
  ),
  646 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74516',
  ),
  647 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74517',
  ),
  648 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74518',
  ),
  649 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2095',
    'vote' => '3',
    'old-id' => '74519',
  ),
  650 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74520',
  ),
  651 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74521',
  ),
  652 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2095',
    'vote' => '3',
    'old-id' => '74522',
  ),
  653 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74523',
  ),
  654 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74524',
  ),
  655 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74525',
  ),
  656 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74526',
  ),
  657 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74527',
  ),
  658 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74528',
  ),
  659 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74529',
  ),
  660 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74530',
  ),
  661 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74531',
  ),
  662 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2095',
    'vote' => '1',
    'old-id' => '74532',
  ),
  663 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74533',
  ),
  664 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74534',
  ),
  665 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74535',
  ),
  666 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74536',
  ),
  667 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74537',
  ),
  668 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74538',
  ),
  669 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74539',
  ),
  670 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74540',
  ),
  671 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74541',
  ),
  672 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74542',
  ),
  673 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74543',
  ),
  674 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74544',
  ),
  675 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74545',
  ),
  676 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74546',
  ),
  677 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74547',
  ),
  678 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2096',
    'vote' => '0',
    'old-id' => '74548',
  ),
  679 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74549',
  ),
  680 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74550',
  ),
  681 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2096',
    'vote' => '3',
    'old-id' => '74551',
  ),
  682 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74552',
  ),
  683 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74553',
  ),
  684 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74554',
  ),
  685 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74555',
  ),
  686 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74556',
  ),
  687 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74557',
  ),
  688 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2096',
    'vote' => '3',
    'old-id' => '74558',
  ),
  689 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74559',
  ),
  690 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74560',
  ),
  691 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2096',
    'vote' => '3',
    'old-id' => '74561',
  ),
  692 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74562',
  ),
  693 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74563',
  ),
  694 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74564',
  ),
  695 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74565',
  ),
  696 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74566',
  ),
  697 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74567',
  ),
  698 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74568',
  ),
  699 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74569',
  ),
  700 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74570',
  ),
  701 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2096',
    'vote' => '1',
    'old-id' => '74571',
  ),
  702 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74572',
  ),
  703 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74573',
  ),
  704 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74574',
  ),
  705 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74575',
  ),
  706 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74576',
  ),
  707 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74577',
  ),
  708 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74578',
  ),
  709 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74579',
  ),
  710 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74580',
  ),
  711 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74581',
  ),
  712 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74582',
  ),
  713 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74583',
  ),
  714 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74584',
  ),
  715 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74585',
  ),
  716 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74586',
  ),
  717 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74587',
  ),
  718 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74588',
  ),
  719 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74589',
  ),
  720 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2097',
    'vote' => '3',
    'old-id' => '74590',
  ),
  721 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74591',
  ),
  722 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74592',
  ),
  723 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74593',
  ),
  724 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74594',
  ),
  725 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74595',
  ),
  726 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74596',
  ),
  727 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2097',
    'vote' => '3',
    'old-id' => '74597',
  ),
  728 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74598',
  ),
  729 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74599',
  ),
  730 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2097',
    'vote' => '3',
    'old-id' => '74600',
  ),
  731 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74601',
  ),
  732 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74602',
  ),
  733 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2097',
    'vote' => '0',
    'old-id' => '74603',
  ),
  734 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74604',
  ),
  735 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74605',
  ),
  736 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74606',
  ),
  737 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74607',
  ),
  738 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74608',
  ),
  739 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74609',
  ),
  740 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2097',
    'vote' => '1',
    'old-id' => '74610',
  ),
  741 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74611',
  ),
  742 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74612',
  ),
  743 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74613',
  ),
  744 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74614',
  ),
  745 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74615',
  ),
  746 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74616',
  ),
  747 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74617',
  ),
  748 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74618',
  ),
  749 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74619',
  ),
  750 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74620',
  ),
  751 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74621',
  ),
  752 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74622',
  ),
  753 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74623',
  ),
  754 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74624',
  ),
  755 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74625',
  ),
  756 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74626',
  ),
  757 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74627',
  ),
  758 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74628',
  ),
  759 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2098',
    'vote' => '3',
    'old-id' => '74629',
  ),
  760 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74630',
  ),
  761 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74631',
  ),
  762 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74632',
  ),
  763 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74633',
  ),
  764 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74634',
  ),
  765 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74635',
  ),
  766 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2098',
    'vote' => '3',
    'old-id' => '74636',
  ),
  767 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74637',
  ),
  768 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2098',
    'vote' => '3',
    'old-id' => '74638',
  ),
  769 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2098',
    'vote' => '3',
    'old-id' => '74639',
  ),
  770 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74640',
  ),
  771 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74641',
  ),
  772 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2098',
    'vote' => '0',
    'old-id' => '74642',
  ),
  773 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74643',
  ),
  774 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74644',
  ),
  775 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74645',
  ),
  776 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74646',
  ),
  777 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74647',
  ),
  778 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74648',
  ),
  779 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2098',
    'vote' => '1',
    'old-id' => '74649',
  ),
  780 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74650',
  ),
  781 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74651',
  ),
  782 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74652',
  ),
  783 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74653',
  ),
  784 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74654',
  ),
  785 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2099',
    'vote' => '1',
    'old-id' => '74655',
  ),
  786 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2099',
    'vote' => '1',
    'old-id' => '74656',
  ),
  787 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74657',
  ),
  788 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2099',
    'vote' => '1',
    'old-id' => '74658',
  ),
  789 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74659',
  ),
  790 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74660',
  ),
  791 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74661',
  ),
  792 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74662',
  ),
  793 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74663',
  ),
  794 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74664',
  ),
  795 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74665',
  ),
  796 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74666',
  ),
  797 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74667',
  ),
  798 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2099',
    'vote' => '3',
    'old-id' => '74668',
  ),
  799 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74669',
  ),
  800 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74670',
  ),
  801 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74671',
  ),
  802 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74672',
  ),
  803 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74673',
  ),
  804 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74674',
  ),
  805 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2099',
    'vote' => '3',
    'old-id' => '74675',
  ),
  806 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74676',
  ),
  807 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74677',
  ),
  808 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2099',
    'vote' => '3',
    'old-id' => '74678',
  ),
  809 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74679',
  ),
  810 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74680',
  ),
  811 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74681',
  ),
  812 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74682',
  ),
  813 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74683',
  ),
  814 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74684',
  ),
  815 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74685',
  ),
  816 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74686',
  ),
  817 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74687',
  ),
  818 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2099',
    'vote' => '0',
    'old-id' => '74688',
  ),
  819 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74689',
  ),
  820 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74690',
  ),
  821 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74691',
  ),
  822 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74692',
  ),
  823 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74693',
  ),
  824 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74694',
  ),
  825 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74695',
  ),
  826 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74696',
  ),
  827 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74697',
  ),
  828 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74698',
  ),
  829 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74699',
  ),
  830 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74700',
  ),
  831 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74701',
  ),
  832 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74702',
  ),
  833 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74703',
  ),
  834 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74704',
  ),
  835 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74705',
  ),
  836 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74706',
  ),
  837 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2101',
    'vote' => '3',
    'old-id' => '74707',
  ),
  838 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74708',
  ),
  839 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74709',
  ),
  840 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74710',
  ),
  841 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74711',
  ),
  842 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74712',
  ),
  843 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74713',
  ),
  844 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2101',
    'vote' => '3',
    'old-id' => '74714',
  ),
  845 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74715',
  ),
  846 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74716',
  ),
  847 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2101',
    'vote' => '3',
    'old-id' => '74717',
  ),
  848 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74718',
  ),
  849 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74719',
  ),
  850 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2101',
    'vote' => '0',
    'old-id' => '74720',
  ),
  851 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74721',
  ),
  852 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74722',
  ),
  853 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74723',
  ),
  854 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74724',
  ),
  855 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74725',
  ),
  856 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74726',
  ),
  857 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2101',
    'vote' => '1',
    'old-id' => '74727',
  ),
  858 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74728',
  ),
  859 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74729',
  ),
  860 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74730',
  ),
  861 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74731',
  ),
  862 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74732',
  ),
  863 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74733',
  ),
  864 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74734',
  ),
  865 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74735',
  ),
  866 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74736',
  ),
  867 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74737',
  ),
  868 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74738',
  ),
  869 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74739',
  ),
  870 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74740',
  ),
  871 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74741',
  ),
  872 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74742',
  ),
  873 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74743',
  ),
  874 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74744',
  ),
  875 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74745',
  ),
  876 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2102',
    'vote' => '3',
    'old-id' => '74746',
  ),
  877 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74747',
  ),
  878 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74748',
  ),
  879 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74749',
  ),
  880 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74750',
  ),
  881 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74751',
  ),
  882 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74752',
  ),
  883 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2102',
    'vote' => '3',
    'old-id' => '74753',
  ),
  884 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74754',
  ),
  885 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74755',
  ),
  886 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2102',
    'vote' => '3',
    'old-id' => '74756',
  ),
  887 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74757',
  ),
  888 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74758',
  ),
  889 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74759',
  ),
  890 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2102',
    'vote' => '0',
    'old-id' => '74760',
  ),
  891 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74761',
  ),
  892 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74762',
  ),
  893 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74763',
  ),
  894 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74764',
  ),
  895 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74765',
  ),
  896 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2102',
    'vote' => '1',
    'old-id' => '74766',
  ),
  897 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74767',
  ),
  898 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74768',
  ),
  899 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74769',
  ),
  900 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74770',
  ),
  901 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74771',
  ),
  902 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74772',
  ),
  903 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74773',
  ),
  904 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74774',
  ),
  905 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74775',
  ),
  906 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74776',
  ),
  907 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74777',
  ),
  908 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74778',
  ),
  909 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74779',
  ),
  910 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74780',
  ),
  911 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74781',
  ),
  912 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74782',
  ),
  913 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74783',
  ),
  914 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74784',
  ),
  915 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2103',
    'vote' => '3',
    'old-id' => '74785',
  ),
  916 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74786',
  ),
  917 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74787',
  ),
  918 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74788',
  ),
  919 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74789',
  ),
  920 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74790',
  ),
  921 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74791',
  ),
  922 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2103',
    'vote' => '3',
    'old-id' => '74792',
  ),
  923 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74793',
  ),
  924 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74794',
  ),
  925 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2103',
    'vote' => '3',
    'old-id' => '74795',
  ),
  926 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74796',
  ),
  927 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74797',
  ),
  928 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74798',
  ),
  929 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2103',
    'vote' => '0',
    'old-id' => '74799',
  ),
  930 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74800',
  ),
  931 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74801',
  ),
  932 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74802',
  ),
  933 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74803',
  ),
  934 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74804',
  ),
  935 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2103',
    'vote' => '1',
    'old-id' => '74805',
  ),
  936 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74806',
  ),
  937 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74807',
  ),
  938 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74808',
  ),
  939 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74809',
  ),
  940 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74810',
  ),
  941 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74811',
  ),
  942 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74812',
  ),
  943 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74813',
  ),
  944 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74814',
  ),
  945 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74815',
  ),
  946 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74816',
  ),
  947 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74817',
  ),
  948 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74818',
  ),
  949 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74819',
  ),
  950 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74820',
  ),
  951 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74821',
  ),
  952 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74822',
  ),
  953 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74823',
  ),
  954 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2104',
    'vote' => '3',
    'old-id' => '74824',
  ),
  955 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74825',
  ),
  956 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74826',
  ),
  957 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74827',
  ),
  958 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74828',
  ),
  959 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74829',
  ),
  960 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74830',
  ),
  961 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2104',
    'vote' => '3',
    'old-id' => '74831',
  ),
  962 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74832',
  ),
  963 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74833',
  ),
  964 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2104',
    'vote' => '3',
    'old-id' => '74834',
  ),
  965 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74835',
  ),
  966 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74836',
  ),
  967 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74837',
  ),
  968 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2104',
    'vote' => '1',
    'old-id' => '74838',
  ),
  969 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74839',
  ),
  970 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74840',
  ),
  971 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74841',
  ),
  972 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74842',
  ),
  973 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74843',
  ),
  974 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2104',
    'vote' => '0',
    'old-id' => '74844',
  ),
  975 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74845',
  ),
  976 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74846',
  ),
  977 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74847',
  ),
  978 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74848',
  ),
  979 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74849',
  ),
  980 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74850',
  ),
  981 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74851',
  ),
  982 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74852',
  ),
  983 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74853',
  ),
  984 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74854',
  ),
  985 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74855',
  ),
  986 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74856',
  ),
  987 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74857',
  ),
  988 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74858',
  ),
  989 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74859',
  ),
  990 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74860',
  ),
  991 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74861',
  ),
  992 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74862',
  ),
  993 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2105',
    'vote' => '3',
    'old-id' => '74863',
  ),
  994 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74864',
  ),
  995 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74865',
  ),
  996 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74866',
  ),
  997 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74867',
  ),
  998 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74868',
  ),
  999 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74869',
  ),
  1000 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2105',
    'vote' => '3',
    'old-id' => '74870',
  ),
  1001 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74871',
  ),
  1002 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74872',
  ),
  1003 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2105',
    'vote' => '3',
    'old-id' => '74873',
  ),
  1004 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74874',
  ),
  1005 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74875',
  ),
  1006 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74876',
  ),
  1007 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2105',
    'vote' => '0',
    'old-id' => '74877',
  ),
  1008 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74878',
  ),
  1009 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74879',
  ),
  1010 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74880',
  ),
  1011 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74881',
  ),
  1012 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74882',
  ),
  1013 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2105',
    'vote' => '1',
    'old-id' => '74883',
  ),
  1014 =>
  array (
    'politician' => '144',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74884',
  ),
  1015 =>
  array (
    'politician' => '296',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74885',
  ),
  1016 =>
  array (
    'politician' => '145',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74886',
  ),
  1017 =>
  array (
    'politician' => '146',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74887',
  ),
  1018 =>
  array (
    'politician' => '147',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74888',
  ),
  1019 =>
  array (
    'politician' => '148',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74889',
  ),
  1020 =>
  array (
    'politician' => '149',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74890',
  ),
  1021 =>
  array (
    'politician' => '150',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74891',
  ),
  1022 =>
  array (
    'politician' => '158',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74892',
  ),
  1023 =>
  array (
    'politician' => '151',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74893',
  ),
  1024 =>
  array (
    'politician' => '153',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74894',
  ),
  1025 =>
  array (
    'politician' => '152',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74895',
  ),
  1026 =>
  array (
    'politician' => '157',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74896',
  ),
  1027 =>
  array (
    'politician' => '155',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74897',
  ),
  1028 =>
  array (
    'politician' => '156',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74898',
  ),
  1029 =>
  array (
    'politician' => '154',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74899',
  ),
  1030 =>
  array (
    'politician' => '163',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74900',
  ),
  1031 =>
  array (
    'politician' => '164',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74901',
  ),
  1032 =>
  array (
    'politician' => '160',
    'raadsstuk' => '2106',
    'vote' => '3',
    'old-id' => '74902',
  ),
  1033 =>
  array (
    'politician' => '169',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74903',
  ),
  1034 =>
  array (
    'politician' => '159',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74904',
  ),
  1035 =>
  array (
    'politician' => '165',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74905',
  ),
  1036 =>
  array (
    'politician' => '170',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74906',
  ),
  1037 =>
  array (
    'politician' => '167',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74907',
  ),
  1038 =>
  array (
    'politician' => '162',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74908',
  ),
  1039 =>
  array (
    'politician' => '161',
    'raadsstuk' => '2106',
    'vote' => '3',
    'old-id' => '74909',
  ),
  1040 =>
  array (
    'politician' => '168',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74910',
  ),
  1041 =>
  array (
    'politician' => '166',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74911',
  ),
  1042 =>
  array (
    'politician' => '171',
    'raadsstuk' => '2106',
    'vote' => '3',
    'old-id' => '74912',
  ),
  1043 =>
  array (
    'politician' => '174',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74913',
  ),
  1044 =>
  array (
    'politician' => '172',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74914',
  ),
  1045 =>
  array (
    'politician' => '173',
    'raadsstuk' => '2106',
    'vote' => '0',
    'old-id' => '74915',
  ),
  1046 =>
  array (
    'politician' => '175',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74916',
  ),
  1047 =>
  array (
    'politician' => '178',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74917',
  ),
  1048 =>
  array (
    'politician' => '180',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74918',
  ),
  1049 =>
  array (
    'politician' => '177',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74919',
  ),
  1050 =>
  array (
    'politician' => '181',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74920',
  ),
  1051 =>
  array (
    'politician' => '176',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74921',
  ),
  1052 =>
  array (
    'politician' => '179',
    'raadsstuk' => '2106',
    'vote' => '1',
    'old-id' => '74922',
  ),
); //[rs_votes]

		$tags_raadsstuk = array (
  0 =>
  array (
    'id' => '3838',
    'raadsstuk' => '2085',
    'tag' => '2209',
  ),
  1 =>
  array (
    'id' => '3839',
    'raadsstuk' => '2085',
    'tag' => '1911',
  ),
  2 =>
  array (
    'id' => '3840',
    'raadsstuk' => '2086',
    'tag' => '2209',
  ),
  3 =>
  array (
    'id' => '3841',
    'raadsstuk' => '2086',
    'tag' => '1911',
  ),
  4 =>
  array (
    'id' => '3842',
    'raadsstuk' => '2086',
    'tag' => '10',
  ),
  5 =>
  array (
    'id' => '3843',
    'raadsstuk' => '2086',
    'tag' => '1650',
  ),
  6 =>
  array (
    'id' => '3844',
    'raadsstuk' => '2086',
    'tag' => '2210',
  ),
  7 =>
  array (
    'id' => '3845',
    'raadsstuk' => '2087',
    'tag' => '13',
  ),
  8 =>
  array (
    'id' => '3849',
    'raadsstuk' => '2094',
    'tag' => '2212',
  ),
);

		$submitters_raadsstuk = array (
  0 =>
  array (
    'id' => '8994',
    'raadsstuk' => '2095',
    'politician' => '155',
  ),
  1 =>
  array (
    'id' => '8999',
    'raadsstuk' => '2096',
    'politician' => '155',
  ),
  2 =>
  array (
    'id' => '9000',
    'raadsstuk' => '2097',
    'politician' => '296',
  ),
  3 =>
  array (
    'id' => '9001',
    'raadsstuk' => '2098',
    'politician' => '296',
  ),
  4 =>
  array (
    'id' => '9002',
    'raadsstuk' => '2099',
    'politician' => '156',
  ),
  5 =>
  array (
    'id' => '8972',
    'raadsstuk' => '2084',
    'politician' => '174',
  ),
  6 =>
  array (
    'id' => '9003',
    'raadsstuk' => '2101',
    'politician' => '155',
  ),
  7 =>
  array (
    'id' => '9004',
    'raadsstuk' => '2102',
    'politician' => '152',
  ),
  8 =>
  array (
    'id' => '9005',
    'raadsstuk' => '2103',
    'politician' => '152',
  ),
  9 =>
  array (
    'id' => '8976',
    'raadsstuk' => '2085',
    'politician' => '174',
  ),
  10 =>
  array (
    'id' => '9006',
    'raadsstuk' => '2104',
    'politician' => '145',
  ),
  11 =>
  array (
    'id' => '8977',
    'raadsstuk' => '2086',
    'politician' => '164',
  ),
  12 =>
  array (
    'id' => '9007',
    'raadsstuk' => '2105',
    'politician' => '144',
  ),
  13 =>
  array (
    'id' => '9008',
    'raadsstuk' => '2106',
    'politician' => '155',
  ),
  14 =>
  array (
    'id' => '8979',
    'raadsstuk' => '2087',
    'politician' => '179',
  ),
  15 =>
  array (
    'id' => '8981',
    'raadsstuk' => '2088',
    'politician' => '152',
  ),
  16 =>
  array (
    'id' => '8983',
    'raadsstuk' => '2089',
    'politician' => '154',
  ),
  17 =>
  array (
    'id' => '8984',
    'raadsstuk' => '2090',
    'politician' => '179',
  ),
  18 =>
  array (
    'id' => '8985',
    'raadsstuk' => '2091',
    'politician' => '174',
  ),
  19 =>
  array (
    'id' => '8986',
    'raadsstuk' => '2092',
    'politician' => '144',
  ),
  20 =>
  array (
    'id' => '8987',
    'raadsstuk' => '2093',
    'politician' => '296',
  ),
  21 =>
  array (
    'id' => '8988',
    'raadsstuk' => '2094',
    'politician' => '150',
  ),
);

		$categories_raadsstuk = array (
  0 =>
  array (
    'id' => '7413',
    'raadsstuk' => '2074',
    'category' => '10',
  ),
  1 =>
  array (
    'id' => '7500',
    'raadsstuk' => '2085',
    'category' => '1',
  ),
  2 =>
  array (
    'id' => '7501',
    'raadsstuk' => '2085',
    'category' => '8',
  ),
  3 =>
  array (
    'id' => '7458',
    'raadsstuk' => '2082',
    'category' => '18',
  ),
  4 =>
  array (
    'id' => '7502',
    'raadsstuk' => '2086',
    'category' => '8',
  ),
  5 =>
  array (
    'id' => '7505',
    'raadsstuk' => '2087',
    'category' => '11',
  ),
  6 =>
  array (
    'id' => '7506',
    'raadsstuk' => '2087',
    'category' => '12',
  ),
  7 =>
  array (
    'id' => '7537',
    'raadsstuk' => '2095',
    'category' => '12',
  ),
  8 =>
  array (
    'id' => '7509',
    'raadsstuk' => '2088',
    'category' => '9',
  ),
  9 =>
  array (
    'id' => '7510',
    'raadsstuk' => '2088',
    'category' => '13',
  ),
  10 =>
  array (
    'id' => '7512',
    'raadsstuk' => '2089',
    'category' => '5',
  ),
  11 =>
  array (
    'id' => '7544',
    'raadsstuk' => '2097',
    'category' => '12',
  ),
  12 =>
  array (
    'id' => '7513',
    'raadsstuk' => '2090',
    'category' => '5',
  ),
  13 =>
  array (
    'id' => '7514',
    'raadsstuk' => '2091',
    'category' => '18',
  ),
  14 =>
  array (
    'id' => '7515',
    'raadsstuk' => '2091',
    'category' => '5',
  ),
  15 =>
  array (
    'id' => '7547',
    'raadsstuk' => '2098',
    'category' => '14',
  ),
  16 =>
  array (
    'id' => '7548',
    'raadsstuk' => '2099',
    'category' => '8',
  ),
  17 =>
  array (
    'id' => '7549',
    'raadsstuk' => '2099',
    'category' => '11',
  ),
  18 =>
  array (
    'id' => '7478',
    'raadsstuk' => '2083',
    'category' => '18',
  ),
  19 =>
  array (
    'id' => '7517',
    'raadsstuk' => '2092',
    'category' => '5',
  ),
  20 =>
  array (
    'id' => '7550',
    'raadsstuk' => '2101',
    'category' => '8',
  ),
  21 =>
  array (
    'id' => '7551',
    'raadsstuk' => '2101',
    'category' => '2',
  ),
  22 =>
  array (
    'id' => '7552',
    'raadsstuk' => '2101',
    'category' => '18',
  ),
  23 =>
  array (
    'id' => '7553',
    'raadsstuk' => '2102',
    'category' => '8',
  ),
  24 =>
  array (
    'id' => '7519',
    'raadsstuk' => '2093',
    'category' => '12',
  ),
  25 =>
  array (
    'id' => '7554',
    'raadsstuk' => '2103',
    'category' => '2',
  ),
  26 =>
  array (
    'id' => '7520',
    'raadsstuk' => '2094',
    'category' => '3',
  ),
  27 =>
  array (
    'id' => '7555',
    'raadsstuk' => '2104',
    'category' => '7',
  ),
  28 =>
  array (
    'id' => '7556',
    'raadsstuk' => '2104',
    'category' => '17',
  ),
  29 =>
  array (
    'id' => '7557',
    'raadsstuk' => '2105',
    'category' => '5',
  ),
  30 =>
  array (
    'id' => '7442',
    'raadsstuk' => '2080',
    'category' => '1',
  ),
  31 =>
  array (
    'id' => '7443',
    'raadsstuk' => '2080',
    'category' => '8',
  ),
  32 =>
  array (
    'id' => '7558',
    'raadsstuk' => '2106',
    'category' => '8',
  ),
  33 =>
  array (
    'id' => '7559',
    'raadsstuk' => '2106',
    'category' => '18',
  ),
  34 =>
  array (
    'id' => '7486',
    'raadsstuk' => '2084',
    'category' => '1',
  ),
  35 =>
  array (
    'id' => '7487',
    'raadsstuk' => '2084',
    'category' => '10',
  ),
);



		$tagids = array();
		$polids = array();
		$raadids = array();

		try {
			$db->query('START TRANSACTION;');

			if(sizeof($tags) > 0) {
				echo "<h3>Inserting tags</h3>";

				foreach ($tags as $tg) {
					$sql = "INSERT INTO sys_tags(name) VALUES(%s);";
					$sql = $db->formatQuery($sql, $tg['name']);


					echo "<span style='color: orange;'>Executing(insert tag):</span> ".htmlentities($sql)."<br>\n";
					$res = $db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					echo "<b style='color: green'>Success!</b>\n<br>";

					$sql = "SELECT currval('sys_tags_id_seq'::regclass)";
					$val = $db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new tag id: {$sql}");
					$tagids[$tg['old-id']] = $val;
					echo "<span style='color: darkgreen'>Mapping:</span> {$tg['old-id']} to {$val}\n<br>";
				}
			}

			if(sizeof($pol_functions) > 0) {
				echo "<h3>Inserting politician functions</h3>";

				foreach ($pol_functions as $pol) {
					$sql = "INSERT INTO pol_politician_functions(politician, party, region, category, time_start, time_end, description) VALUES(%i, %i, %i, %i, %s, %s, %)";
					$sql = $db->formatQuery($sql, $pol['politician'], $pol['party'], $pol['region'], $pol['category'], $pol['time_start'], $pol['time_end'], $pol['description']);

					echo "<span style='color: orange;'>Executing(insert pol.func):</span> ".htmlentities($sql)."<br>\n";
					$res = $db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					echo "<b style='color: green'>Success!</b>\n<br>";

					$sql = "SELECT currval('pol_politician_functions_id_seq'::regclass)";
					$val = $db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new pol.func id: {$sql}");
					$polids[$pol['old-id']] = $val;
					echo "<span style='color: darkgreen'>Mapping:</span> {$pol['old-id']} to {$val}\n<br>";
				}
			}


			echo "<h3>Inserting raadsstukken</h3>";
			foreach($raadsstukken as $row) {
				if($row['dependent'] && !isset($raadids[$row['parent']])) throw new RuntimeException("Wrong order, parent raadsstuk is not yet inserted! Title: {$row['title']}");

				$sql = "INSERT INTO rs_raadsstukken(region, title, vote_date, summary, code, type, result, submitter, parent, show) VALUES(%i, %s, %s, %s, %s, %i, %i, %i, %, %i);";
				$sql = $db->formatQuery($sql, $row['region'], $row['title'], $row['vote_date'],
							 				  $row['summary'], $row['code'], $row['type'],
									   		  $row['result'], $row['submitter'], ($row['dependent']? $raadids[$row['parent']]: null), $row['show']
								   		);

				echo "<span style='color: orange;'>Executing(insert raadsstuk):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";

				//store ID for deps
				$sql = "SELECT currval('rs_raadsstukken_id_seq'::regclass)";
				$val = $db->query($sql)->fetchCell();
				if("{$val}" == '') throw new RuntimeException("Can't fetch new raaddsstuk id: {$sql}");
				$raadids[$row['old-id']] = $val;
				echo "<span style='color: darkgreen'>Mapping:</span> {$row['old-id']} to {$val}\n<br>";
			}


			//inserting votes
			echo "<h3>Inserting votes</h3>";
			foreach ($votes_data as $vote) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_votes(politician, raadsstuk, vote) VALUES(%i, %i, %i);";
				$sql = $db->formatQuery($sql, $vote['politician'], $raadids[$vote['raadsstuk']], $vote['vote']);

				echo "<span style='color: orange;'>Executing(insert vote):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}


			//inserting tags
			echo "<h3>Inserting Tag links</h3>";
			foreach ($tags_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_tags(raadsstuk, tag) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], isset($tagids[$row['tag']])? $tagids[$row['tag']]: $row['tag']);

				echo "<span style='color: orange;'>Executing(insert tag link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}


			echo "<h3>Inserting Submitters links</h3>";
			foreach ($submitters_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_submitters(raadsstuk, politician) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], $row['politician']);

				echo "<span style='color: orange;'>Executing(insert sub.link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}

			echo "<h3>Inserting Categories links</h3>";
			foreach ($categories_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_categories(raadsstuk, category) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], $row['category']);

				echo "<span style='color: orange;'>Executing(insert sub.link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}

			$db->query('ROLLBACK');
			echo "<h1 style='width: 300px; margin-left: auto; margin-right: auto; color: green;'>Success</h1>";

		} catch(Exception $e) {
			echo "<b style='color: red'>Rollback on error:</b> ".$e->getMessage();
			if($e instanceof DatabaseException) {
				echo  "<div>".($e->getSQL())."</div>";
				echo  "<div>".($e->getError())."</div>";
			}
			$db->query("ROLLBACK;");
		}
	}
}



?>