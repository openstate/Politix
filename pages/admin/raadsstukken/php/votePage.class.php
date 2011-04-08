<?php

require_once('Raadsstuk.class.php');
require_once('Region.class.php');
require_once('Party.class.php');
require_once('Vote.class.php');
require_once('Message.class.php');
require_once('GettextPOModule.class.php');
require_once('Council.class.php');

class VotePage {
	private $rs;
	private $votes;

	public function processGet($get) {
		try {
			$this->rs = new Raadsstuk($get['id']);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
		if (!$this->rs->showVotes()) Dispatcher::forbidden();

		$vote = new Vote();
		$this->votes = $vote->loadByRaadsstuk($this->rs->id); 
	}

	public function processPost($post) {
		$pofile = new GettextPOModule('vote_form.po');
		$voters = $this->rs->getVoters();
		try {
			$votePids = array();
			foreach ($post['politician'] as $pid => $vote) {
				if (ctype_digit($vote) && $voters[$pid]) {
					if ($voteObj = &$this->votes[$pid] == null)
						$voteObj = new Vote();
					
					$voteObj->politician = $pid;
					$voteObj->raadsstuk = $this->rs->id;
					$voteObj->vote = $vote;
					$voteObj->save();
					$votePids[] = (int) $pid;
				}
			}
			DBs::inst(DBs::SYSTEM)->query('DELETE FROM rs_votes WHERE raadsstuk = % %l', $this->rs->id,
				$votePids ? 'AND politician NOT IN ('.implode(', ', $votePids).')' : '');

			$this->rs->result = @$post['result'];
			$this->rs->save();
		} catch (Exception $e) {
			MessageQueue::addMessage(new Message(Message::ERROR, $pofile->getMsgStr('votes.error')));
			if (DEVELOPER) throw $e;
			return;
		}
		MessageQueue::addMessage(new Message(Message::SUCCESS, $pofile->getMsgStr('votes.success')));
		if (isset($post['submit_edit']))
			Dispatcher::header('/raadsstukken/edit/'.$this->rs->id);
	}

	public function show($smarty) {
		$party = new Party();
		$council = Council::getCouncilFromRaadsstuk($this->rs);
		$conc = $council->getView()->getMembersByPartyWithVotesAndNames($this->votes);
		//hide Onbekend
		foreach ($conc as $k => $con) {
			foreach ($con['politicians'] as $kp => $pol) {
				if($pol['def_party'] != null) unset($conc[$k]['politicians'][$kp]);
			}
			if(sizeof($conc[$k]['politicians']) == 0) unset($conc[$k]);
		}

			
		$smarty->assign('region', new Region($this->rs->region));
		$smarty->assign('council', $conc);
		$smarty->assign('raadsstuk', $this->rs);
		$smarty->assign('results', Raadsstuk::getResultArray());
		$smarty->display('votePage.html');
	}
}

?>
