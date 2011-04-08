<?php

class Pager {

	private $start;
	private $limit;
	private $total;
	protected $query_start = '?';
	protected $query_sep = '&amp;';
	protected $value_sep = '=';

	public function Pager($total, $start=0, $limit=10) {
		$this->total = $total;
		if ($start>=$this->total)
			$this->start = 0;
		else
			$this->start = $start;
		$this->limit = $limit;
	}

	function getCurrent() {
		return $this->start;
	}

	function setCurrent($start) {
		if ($start>=$this->total)
			$this->start = 0;
		else
			$this->start = $start;
	}

	function getNext() {
		if (($this->start + $this->limit) < $this->total)
			return $this->start + $this->limit;
		else
			return -1;
	}

	function getPrevious() {
		if (($this->start - $this->limit) >= 0)
			return $this->start - $this->limit;
		else
			return -1;
	}

	function getList() {
		$list = array();
		$i=0; // page start
		$j=1; // page number
		do {
			$list[] = array($i, $j);
			$i += $this->limit;
			$j++;
		} while ($i < $this->total);
		return $list;
	}

	function getReverseList() {
		$list = array();
		$i = $this->getLast(); // page start
		if ($i == -1) $i = 0;
		$j=$i/$this->limit + 1; // page number
		do {
			$list[] = array($i, $j);
			$i -= $this->limit;
			$j--;
		} while ($i >= 0);
		return $list;
	}

	function getLimit() {
		return $this->limit;
	}

	function getFirst() {
		if ($this->total < $this->limit) { // only one page
			return -1;
		}
		return 0;
	}

	function getLast() {
		if ($this->total < $this->limit) { // only one page
			return -1;
		}
		else if (($this->total % $this->limit) == 0) {
			return $this->total - $this->limit;
		}
		else {
			return $this->total - ($this->total % $this->limit);
		}
	}

	function getHTML($page, $startvar, $extraGet='', $params = null) {
		if (count($this->getList())<=1)
			return '';

		$_arrows = isset($params['arrows']) ? $params['arrows'] : true;

		$html = '';

		if ($extraGet!='') $extraGet.= $this->query_sep;

		if ($_arrows) {
			if ($this->getFirst()!=-1) {
				$html.= ' <a href="'.$page.$this->query_start.$extraGet.$startvar.$this->value_sep.$this->getFirst().'">&lt;&lt;</a> ';
			} else {
				$html.= ' <span class="nolink">&lt;&lt;</span> ';
			}

			if ($this->getPrevious()!=-1) {
				$html.= ' <a href="'.$page.$this->query_start.$extraGet.$startvar.$this->value_sep.$this->getPrevious().'">&lt;</a> ';
			} else {
				$html.= ' <span class="nolink">&lt;</span> ';
			}
		}

		foreach ($this->getList() as $pg) {
			if ($pg[0] == $this->getCurrent()) {
				$html.= ' <span class="nolink">'.$pg[1].'</span> ';
			} else {
				$html.= ' <a href="'.$page.$this->query_start.$extraGet.$startvar.$this->value_sep.$pg[0].'">'.$pg[1].'</a> ';
			}
		}

		if ($_arrows) {
			if ($this->getNext()!=-1) {
				$html.= ' <a href="'.$page.$this->query_start.$extraGet.$startvar.$this->value_sep.$this->getNext().'">&gt;</a> ';
			} else {
				$html.= ' <span class="nolink">&gt;</span> ';
			}

			if ($this->getLast()!=-1) {
				$html.= ' <a href="'.$page.$this->query_start.$extraGet.$startvar.$this->value_sep.$this->getLast().'">&gt;&gt;</a> ';
			} else {
				$html.= ' <span class="nolink">&gt;&gt;</span> ';
			}
		}

		return $html;
	}
}

?>