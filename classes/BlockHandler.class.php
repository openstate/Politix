<?php

class BlockHandler {
	protected $modules = array();
	protected $blocks = array();
	protected $handler = null;

	public function __construct($modules, $handler) {
		$this->modules = $modules;
		$this->handler = $handler;
	}

	public function blockInstance($block) {
		if (isset($this->blocks[$block]))
			$fileName = $this->blocks[$block];
		else {
			$fileName = false;
			// Locate the requested block class
			foreach ($this->modules as $module) {
				$fn = $_SERVER['DOCUMENT_ROOT'].'/../modules/'.$module.'/blocks/'.$block.'Block.class.php';
				if (file_exists($fn)) {
					$this->blocks[$block] = $fn;
					$fileName = $fn;
					require_once($fn);
					break;
				}
			}
			if (!$fileName)
				throw new Exception('Block type not found: '.$block.'. Has the module been added in the sites configuration?');
		}

		$className = $block.'Block';
		$inst = new $className($this->handler);
		return $inst;
	}

	public function __call($name, $args) {
		$inst = $this->blockInstance($name);

		$smarty = new CustomSmarty(Dispatcher::inst()->locale);
		$smarty->assign('global', Dispatcher::inst());
		$smarty->setCurrDir(dirname($this->blocks[$name]).'/html/');

		return call_user_func_array(array($inst, 'display'), array_merge(array($smarty), $args));
	}

	protected function findBlocks($modules) {
	}
}

?>
