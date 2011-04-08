<?php

require_once('dist/Smarty.class.php');
require_once('GettextPO.class.php');

class CustomSmarty extends Smarty {
	protected $currDir = '';
	protected $baseTemplate = '';
	protected $contentDirs = array('header' => '../header/', 'content' => '../content/');

	private $locale;

	public function changeDelimiters($ldelim, $rdelim) {
		$this->left_delimiter = $ldelim;
		$this->right_delimiter = $rdelim;
	}

	public function __construct($locale) {
		if (!$locale)
			throw new Exception('Attempt to create CustomSmarty without giving a locale.');
		parent::__construct();
		$this->compile_dir = dirname(__FILE__).'/templates_c/';
		$this->locale = $locale;
		$this->register_prefilter(array($this, 'smarty_i18n_prefilter'));
		$this->register_postfilter(array($this, 'smarty_i18n_postfilter'));
	}

	public function setBaseTemplate($baseTemplate) {
		$this->baseTemplate = $baseTemplate;
		if (!realpath($this->baseTemplate))
			throw new Exception('Template does not exist: '.$this->baseTemplate);
	}

	public function setCurrDir($dir) {
		$this->currDir = $dir;
	}

	public function setContentDir($type, $dir) {
		$this->contentDirs[$type] = $dir;
	}

	// -- Translation filters
	// Translated are strings of the form ##message##
	// Strings are printf'ed, give parameters as: ##msg:par1:par2:...##
	// Plural strings must have the number in the first parameter.

	private $poFiles = array();
	private $smartyCompiler = null;
	private $currentPOs = null;
	private $poStack = array();

	// Finds all the references to PO files in the source and returns
	// their absolute paths.
	// $sourcePath - The path where the source is located
	// $source     - The template source
	private function getPOfiles($sourcePath, $source) {
		preg_match_all('/{pofile\s+([^}]+)}/', $source, $poFiles, PREG_PATTERN_ORDER);
		$result = array();
		foreach ($poFiles[1] as $poFile) {
			$file = $this->locale.'/'.$poFile.'.po';
			if (file_exists($sourcePath.'/../locale/'.$file))
				$result[]= $sourcePath.'/../locale/'.$file;
			else if (file_exists($_SERVER['DOCUMENT_ROOT'].'/../locale/'.$file))
				$result[]= $_SERVER['DOCUMENT_ROOT'].'/../locale/'.$file;
			else
				throw new Exception('Could not load language file: '.$poFile.'.po in '.$sourcePath);
		}
		return $result;
	}

	public function _is_compiled($resource_name, $compile_path) {
		$isCompiled = parent::_is_compiled($resource_name, $compile_path);
		if ($isCompiled) {
			// Check if we have PO files that have changed
			$poFiles = $this->getPOfiles(dirname($resource_name), file_get_contents($resource_name));
			$templateTime = filemtime($compile_path);
			foreach ($poFiles as $file) {
				if (filemtime($file) > $templateTime) {
					$isCompiled = false;
					break;
				}
			}
		}
		return $isCompiled;
	}

	public function translate($match) {
		foreach ($this->currentPOs as $po) {
			$entry = $po->getEntry($match[1]);
			if ($entry) break;
		}
		if (!$entry) {
			throw new Exception('Unknown translation id '.$match[0].' in '.$this->smartyCompiler->_current_file);
		}
		if ($entry['plural']) {
			if ($match[2]=='' || $match[2][0]!=':')
				throw new Exception('Missing argument for plural string '.$match[0]);
			$args = explode(':', substr($match[2], 1));
			$this->smartyCompiler->_parse_vars_props($args);
			$php = '{php}switch (_pluralfunc('.$args[0].')) {'."\n";
			foreach ($entry['msgstr'] as $key => $str) {
				$php.= 'case '.$key.': printf(\''.addslashes($str).'\', '.implode(',', $args).'); break;'."\n";
			}
			$php.= '}{/php}';
			return $php;
		} else {
			if ($match[2]!='') {
				$args = explode(':', substr($match[2], 1));
				$this->smartyCompiler->_parse_vars_props($args);
				return '{php} printf(\''.addslashes($entry['msgstr']).'\', '.implode(',', $args).'); {/php}';
			} else
				return $entry['msgstr'];
		}
	}

	public function smarty_i18n_prefilter($source, &$smarty) {
		// Check for included PO files
		$poFiles = $this->getPOfiles(dirname($smarty->_current_file), $source);
		$source = preg_replace('/{pofile\s+([^}]+)}/', '', $source);

		if (count($poFiles)==0)	{
			$this->currentPOs = array();
			$this->poStack[]= array();
			return $source;
		}

		$this->smartyCompiler = &$smarty;
		$POs = array();
		foreach ($poFiles as $poFileName) {
			if (!isset($this->poFiles[$poFileName])) {
				$po = new GettextPO($poFileName);
				$this->poFiles[$poFileName] = $po;
				$POs[]= $po;
			} else {
				$POs[]= $this->poFiles[$poFileName];
			}
		}
		$this->poStack[]= ($this->currentPOs = $POs);

		return @preg_replace_callback('/##(.+?)((?::.+?)*)##/', array($this, 'translate'), $source);
	}

	public function smarty_i18n_postfilter($source, &$smarty) {
		foreach ($this->currentPOs as $po) {
			if ($po->hasPlurals) {
				$source = '<?php function _pluralfunc($n) { return (int)('.$po->getPHPplural().'); } ?>'."\n".$source;
				break;
			}
		}
		array_pop($this->poStack);
		$this->currentPOs = end($this->poStack);
		return $source;
	}
	// -- End translation filters

	public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false) {
		// Use absolute paths so we don't get conflicts with same-name files in different dirs
		$name = realpath($resource_name);
		if (!$name)
			$this->trigger_error('Unable to find resource: '.$resource_name);

		// Generate a different compile ID for each language
		$compile_id = $this->locale.'-'.md5($name);

		// Now call parent method
		return parent::fetch($name, $cache_id, $compile_id, $display);
	}

	public function display($template) {
		$contentFile = realpath($this->currDir.$this->contentDirs['content'].$template);
		if (!$contentFile)
			throw new Exception('Unable to load content file: '.$this->currDir.$this->contentDirs['content'].$template);

		$this->assign('smartyData', array(
			'headerFile'  => (file_exists($this->currDir.$this->contentDirs['header'].$template) ? realpath($this->currDir.'../header/'.$template) : ''),
			'contentFile' => $contentFile,
			'contentDir' => $this->currDir.$this->contentDirs['content'],
			'headerDir' => $this->currDir.$this->contentDirs['header'],
			'role' => (isset($_SESSION['role']) ? $_SESSION['role'] : false)
		));

		parent::display($this->baseTemplate);
	}

	public function displayBlock($template) {
		$contentFile = realpath($this->currDir.$template);
		if (!$contentFile)
			throw new Exception('Unable to load content file: '.$this->currDir.$template);
		parent::display($contentFile);
	}

	public function displayAbsolute($template) {
		// TODO: HACK: We shouldn't need this function.
		$contentFile = realpath($_SERVER['DOCUMENT_ROOT'].'/../'.$template);
		if (!$contentFile)
			throw new Exception('Unable to load content file: '.$contentFile);
		parent::display($contentFile);
	}
}
?>
