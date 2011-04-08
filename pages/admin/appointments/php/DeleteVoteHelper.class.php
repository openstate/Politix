<?php

require_once('DBs.class.php');

class DeleteVoteHelper {
	public static function deleteOldVotes($politicianId) {
		DBs::inst(DBs::SYSTEM)->query('delete from rs_votes where id in (select v.id from rs_votes v join rs_raadsstukken r on r.id = v.raadsstuk join pol_politician_functions pf on v.politician = pf.politician where v.politician = % and r.vote_date > pf.time_end)', $politicianId);
	}
}

?>