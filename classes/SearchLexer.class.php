<?php
class SearchLexer_Tokens {
	const PAR_OPEN = 0;
	const PAR_CLOSE = 1;
	const NOT = 2;
	const BIN_OP = 3;
	const IDENT = 4;

	public static function getName($token) {
		switch($token) {
		case self::PAR_OPEN: return 'PAR_OPEN';
		case self::PAR_CLOSE: return 'PAR_CLOSE';
		case self::NOT: return 'NOT';
		case self::BIN_OP: return 'BIN_OP';
		case self::IDENT: return 'IDENT';
		}
	}
}

class SearchLexer {
	private $data;
	public $token;
	public $value;
	private $line;
	private $count;

	function __construct($data)
	{
		$this->data  = $data;
		$this->count = 0;
		$this->line  = 1;
	}


    private $_yy_state = 1;
    private $_yy_stack = array();

    function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    function yybegin($state)
    {
        $this->_yy_state = $state;
    }




    function yylex1()
    {
        if ($this->count >= strlen($this->data)) {
            return false; // end of input
        }
    	do {
	    	$rules = array(
    			'/^[ \t\n]+/',
    			'/^\\(/',
    			'/^\\)/',
    			'/^-/',
    			'/^(?:OF|EN|OR|AND)/',
    			'/^[a-zA-Z0-9][a-zA-Z0-9-]*/',
    			'/^./',
	    	);
	    	$match = false;
	    	foreach ($rules as $index => $rule) {
	    		if (preg_match($rule, substr($this->data, $this->count), $yymatches)) {
	            	if ($match) {
	            	    if (strlen($yymatches[0]) > strlen($match[0][0])) {
	            	    	$match = array($yymatches, $index); // matches, token
	            	    }
	            	} else {
	            		$match = array($yymatches, $index);
	            	}
	            }
	    	}
	    	if (!$match) {
	            throw new Exception('Unexpected input at line' . $this->line .
	                ': ' . $this->data[$this->count]);
	    	}
	    	$this->token = $match[1];
	    	$this->value = $match[0][0];
	    	$yysubmatches = $match[0];
	    	array_shift($yysubmatches);
	    	if (!$yysubmatches) {
	    		$yysubmatches = array();
	    	}
	        $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
	        if ($r === null) {
	            $this->count += strlen($this->value);
	            $this->line += substr_count($this->value, "\n");
	            // accept this token
	            return true;
	        } elseif ($r === true) {
	            // we have changed state
	            // process this token in the new state
	            return $this->yylex();
	        } elseif ($r === false) {
	            $this->count += strlen($this->value);
	            $this->line += substr_count($this->value, "\n");
	            if ($this->count >= strlen($this->data)) {
	                return false; // end of input
	            }
	            // skip this token
	            continue;
	        } else {
	            $yy_yymore_patterns = array_slice($rules, $this->token, true);
	            // yymore is needed
	            do {
	                if (!isset($yy_yymore_patterns[$this->token])) {
	                    throw new Exception('cannot do yymore for the last token');
	                }
			    	$match = false;
	                foreach ($yy_yymore_patterns[$this->token] as $index => $rule) {
	                	if (preg_match('/' . $rule . '/',
	                      	  substr($this->data, $this->count), $yymatches)) {
	                    	$yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
			            	if ($match) {
			            	    if (strlen($yymatches[0]) > strlen($match[0][0])) {
			            	    	$match = array($yymatches, $index); // matches, token
			            	    }
			            	} else {
			            		$match = array($yymatches, $index);
			            	}
			            }
			    	}
			    	if (!$match) {
			            throw new Exception('Unexpected input at line' . $this->line .
			                ': ' . $this->data[$this->count]);
			    	}
			    	$this->token = $match[1];
			    	$this->value = $match[0][0];
			    	$yysubmatches = $match[0];
			    	array_shift($yysubmatches);
			    	if (!$yysubmatches) {
			    		$yysubmatches = array();
			    	}
	                $this->line = substr_count($this->value, "\n");
	                $r = $this->{'yy_r1_' . $this->token}();
	            } while ($r !== null || !$r);
		        if ($r === true) {
		            // we have changed state
		            // process this token in the new state
		            return $this->yylex();
		        } else {
	                // accept
	                $this->count += strlen($this->value);
	                $this->line += substr_count($this->value, "\n");
	                return true;
		        }
	        }
        } while (true);

    } // end function

    function yy_r1_0($yy_subpatterns)
    {

	return false;
    }
    function yy_r1_1($yy_subpatterns)
    {

	$this->token = SearchLexer_Tokens::PAR_OPEN;
    }
    function yy_r1_2($yy_subpatterns)
    {

	$this->token = SearchLexer_Tokens::PAR_CLOSE;
    }
    function yy_r1_3($yy_subpatterns)
    {

	$this->token = SearchLexer_Tokens::NOT;
    }
    function yy_r1_4($yy_subpatterns)
    {

	$this->token = SearchLexer_Tokens::BIN_OP;
    }
    function yy_r1_5($yy_subpatterns)
    {

	$this->token = SearchLexer_Tokens::IDENT;
    }
    function yy_r1_6($yy_subpatterns)
    {

	return false;
    }

}