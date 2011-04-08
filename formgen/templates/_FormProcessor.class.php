<?php

require_once('{processorclass}Base.class.php');

class {processorclass} extends {processorclass}Base {
	{if:loadmany}protected $sortDefault = 'id';{/if}

{if:load}
	public function loadFromObject($id) {
		require_once('{editclass}.class.php');
		$obj = new {editclass}();
		$obj->load($id);
		$this->loadData($obj);
	}
{/if}

{if:save}
	public function saveToObject() {
		require_once('{editclass}.class.php');
		$obj = new {editclass}();
		$this->doSaveToObject($obj);
		$obj->save();
	}
{/if}

	public function show($smarty) {
		{if:load || loadmany}$this->loadFromObject();{/if}
		parent::show($smarty);
	}

{if:save}
	public function action() {
		$this->saveToObject();
		Dispatcher::header('../');
	}
{/if}

{customfuncs}
}

?>