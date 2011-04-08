<?php

require_once('Council.class.php');
require_once('Raadsstuk.class.php');
require_once('Vote.class.php');
require_once('PartyVoteCache.class.php');
require_once('Xml.class.php');

class RaadPage {
	public function processGet($get) {
		try {
			$rs = new Raadsstuk($get['id']);
			$council = Council::getCouncilFromRaadsstuk($rs);
			$pv = new PartyVoteCache();
			$vote = new Vote();
			$xml = Xml::getDefault();
			echo Xml::getPrelude();
			echo $xml->getRoot('raad');
			echo $xml->fieldToXml('raadsstuk', $rs->id);
			echo $council->getView()->toXml($pv->loadVotesListAssociativeOnParty($rs->id), $vote->loadByRaadsstuk($rs->id), $xml);
			echo $xml->getTag('raad', true);
		} catch (Exception $e) {
			//todo
		}
	}
}

?>