<?php

require_once('SearchLexer.class.php');

class SearchParser_States {
	const START = 0;
	const IDENT = 1;
	const BIN_OP = 2;
	const NOT = 3;
	const PAR_OPEN = 4;

	public static function getName($state) {
		switch ($state) {
		case self::START: return 'START';
		case self::IDENT: return 'IDENT';
		case self::BIN_OP: return 'BIN_OP';
		case self::NOT: return 'NOT';
		case self::PAR_OPEN: return 'PAR_OPEN';		
		}
	}
}

class SearchParser {
	protected $state = 0;
	protected $par_count = 0;
	protected $idents = 0;
	protected $result;
	protected $query;

	private static $ops = array(
		'EN' => '&',
		'AND' => '&',
		'OF' => '|',
		'OR' => '|',
	);

	public function __construct($query) {
		$this->query = $query;
		$this->result = array();
	}

	public function parse() {
		$lex = new SearchLexer($this->query);
		while ($lex->yylex()) {
			$this->{'parse_'.strtolower(SearchParser_States::getName($this->state))}($lex);
		}
		if (!$this->idents) return '';

		$this->sanitize();
		return $this->formatResults();
	}

	protected function sanitize() {
		for ($i = count($this->result) - 1; $i >= 0; $i--) {
			$r = &$this->result[$i];
			if (SearchLexer_Tokens::IDENT == $r->token ||
					SearchLexer_Tokens::PAR_CLOSE == $r->token) {
				break;
			} else {
				if (SearchLexer_Tokens::PAR_OPEN == $r->token) $this->par_count--;
				array_pop($this->result);
			}
		}
		while ($this->par_count--) {
			$this->insert(SearchLexer_Tokens::PAR_CLOSE, ')');
		}
	}

	protected function formatResults() {
		$output = '';
		foreach ($this->result as $r) {
			$output .= $r->value;
			if (SearchLexer_Tokens::NOT != $r->token) $output .= ' ';
		}
		return $output;
	}

	private function parse_start($lex) {
		switch ($lex->token) {
		case SearchLexer_Tokens::PAR_OPEN:
			$this->par_open();
			break;
		case SearchLexer_Tokens::PAR_CLOSE:
			$this->par_close();
			break;
		case SearchLexer_Tokens::NOT:
			$this->not();
			break;
		case SearchLexer_Tokens::IDENT:
			$this->ident($lex->value);
		}
	}

	private function parse_ident($lex) {
		switch ($lex->token) {
		case SearchLexer_Tokens::PAR_OPEN:
			$this->implicit_and();
			$this->par_open();
			break;
		case SearchLexer_Tokens::PAR_CLOSE:
			$this->par_close();
			break;
		case SearchLexer_Tokens::NOT:
			$this->implicit_and();
			$this->not();
			break;
		case SearchLexer_Tokens::IDENT:
			$this->implicit_and();
			$this->ident($lex->value);
			break;
		case SearchLexer_Tokens::BIN_OP:
			$this->bin_op($lex->value);
		}
	}

	private function parse_not($lex) {
		switch ($lex->token) {
		case SearchLexer_Tokens::PAR_OPEN:
			$this->par_open();
			break;
		case SearchLexer_Tokens::IDENT:
			$this->ident($lex->value);
		}
	}

	private function parse_bin_op($lex) {
		switch ($lex->token) {
		case SearchLexer_Tokens::PAR_OPEN:
			$this->par_open();
			break;
		case SearchLexer_Tokens::NOT:
			$this->not();
			break;
		case SearchLexer_Tokens::IDENT:
			$this->ident($lex->value);
			break;
		}
	}

	private function parse_par_open($lex) {
		switch ($lex->token) {
		case SearchLexer_Tokens::PAR_OPEN:
			$this->par_open();
			break;
		case SearchLexer_Tokens::NOT:
			$this->not();
			break;
		case SearchLexer_Tokens::IDENT:
			$this->ident($lex->value);
		}
	}

	protected function par_open() {
		$this->par_count++;
		$this->insert(SearchLexer_Tokens::PAR_OPEN, '(');
		$this->state = SearchParser_States::PAR_OPEN;
	}

	protected function par_close() {
		if ($this->par_count > 0) {
			$this->par_count--;
			$this->insert(SearchLexer_Tokens::PAR_CLOSE, ')');
			$this->state = SearchParser_States::IDENT;
		}
	}

	protected function not() {
		$this->insert(SearchLexer_Tokens::NOT, '!');
		$this->state = SearchParser_States::NOT;
	}

	protected function bin_op($value) {
		$this->insert(SearchLexer_Tokens::BIN_OP, self::$ops[$value]);
		$this->state = SearchParser_States::BIN_OP;
	}

	protected function implicit_and() {
		$this->insert(SearchLexer_Tokens::BIN_OP, '&');
	}

	protected function ident($value) {
		$this->idents++;
		$this->insert(SearchLexer_Tokens::IDENT, $value);
		$this->state = SearchParser_States::IDENT;
	}

	protected function insert($token, $value) {
		$this->result[] = new SearchToken($token, $value);
	}
}

class SearchToken {
	public $token;
	public $value;

	public function __construct($token, $value) {
		$this->token = $token;
		$this->value = $value;
	}
}

?>