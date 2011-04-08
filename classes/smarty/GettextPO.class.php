<?php

class GettextPO {
	private $filename;
	private $entries = array();
	private $nplural = 2;
	private $plural = 'plural = (n!=1)';
	public  $hasPlurals = false;

	public function __construct($filename) {
		$this->filename = $filename;
		$this->readpo(file($filename));
	}

	protected function readpo(array $pofile) {
		$idx = 0;
		$intEnc = mb_internal_encoding();
		$contentType = false;
		while ($idx<count($pofile)) {
			if ($pofile[$idx][0]!='#' && trim($pofile[$idx])!='') {
				// New entry start
				$entry = array('plural' => false);
				do {
					// Init entry
					$line = $pofile[$idx];
					$type = substr($line, 0, strpos($line, ' '));
					if (!preg_match('/^msgid|msgid_plural|msgstr(\[([0-9]+)\])?/', $type, $match))
						throw new Exception('Unknown entry type '.$type.' in '.$this->filename.' at line '.($idx+1));
					$line = trim(substr($line, strpos($line, ' ')));

					// Read multiline string
					$s = '';
					do {
						$line = substr($line, 1, -1);
						$s.= str_replace(array('\"', '\n', '\\\\'), array('"', "\n", '\\'), $line);
						$idx++;
						if ($idx<count($pofile))
							$line = trim($pofile[$idx]);
					} while ($idx<count($pofile) && $line!='' && $line[0]=='"');

					// Convert encoding if needed
					if ($contentType)
						$s = mb_convert_encoding($s, $contentType, $intEnc);

					// Store this string
					if (substr($type, 0, 6) == 'msgstr') {
						if ($entry['plural'] && count($match)==1)
							throw new Exception('Non-plural string given for plural entry in '.$this->filename.' at line '.($idx+1));
						if (!$entry['plural'] && count($match)>1)
							throw new Exception('Plural string given for non-plural entry in '.$this->filename.' at line '.($idx+1));
						if ($entry['plural']) {
							if (!isset($entry['msgstr']))
								$entry['msgstr'] = array();
							$entry['msgstr'][$match[2]] = $s;
						} else
							$entry['msgstr'] = $s;
					} else {
						$entry[$type] = $s;
						if ($type == 'msgid_plural') {
							$entry['plural'] = true;
							$this->hasPlurals = true;
						}
					}
				} while ($idx<count($pofile) && trim($pofile[$idx])!='' && $pofile[$idx][0]!='#');
				if (!isset($entry['msgid']))
					throw new Exception('msgid missing for entry in '.$this->filename.' ending at line '.$idx);

				if ($entry['msgid']=='') {
					if (count($this->entries)>0)
						throw new Exception('Config given after message entries in '.$this->filename.' ending at line '.$idx);
					// Read config
					$confLines = explode("\n", $this->entries['']['msgstr']);
					foreach ($confLines as $conf) {
						if (preg_match('/^Plural-Forms:\s*nplurals=([0-9]+);\s*(plural.*);$/', $conf, $match)) {
							$this->nplural = $match[1];
							$this->plural = $match[2];
						} else if (preg_match('/^Content-Type:\s*.*?;\s*charset\s*=\s*(.*)$/', $conf, $match)) {
							$contentType = $match[1];
						}
					}
				} else
					$this->entries[$entry['msgid']]= $entry;

				while ($idx<count($pofile) && trim($pofile[$idx])=='')
					$idx++;
			} else
				$idx++;
		}
	}

	public function getEntry($id) {
		if (isset($this->entries[$id]))
			return $this->entries[$id];
		else
			return false;
	}

	public function getEntryIDs() {
		return array_keys($this->entries);
	}

	public function getMsgStr($id) {
		if (isset($this->entries[$id]))
			return $this->entries[$id]['msgstr'];
		else
			return false;
	}

	public function getPHPplural() {
		return str_replace('n', '$n', preg_replace('/^\s*plural\s*=\s*/', '', $this->plural));
	}

	public function __get($name) {
		if ($name == 'filename')
			return $this->$name;
	}
}
?>