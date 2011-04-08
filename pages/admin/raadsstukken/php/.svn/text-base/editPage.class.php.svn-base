<?php

require_once('LoadFormById.class.php');

class EditPage extends LoadFormById {
	protected function getFormParameters() {
		return array('name' => 'RaadsstukEdit',
								 'header' => 'Voorstel wijzigen',
								 'objectId' => $this->rs->id,
								 'submitText' => 'Wijzigen',
								 'extraButton' => 'Wijzigen en naar stemming');
	}

	protected function getAction() {
		return 'edit';
	}

	public function show($smarty) {
		$smarty->assign('cats', json_encode(array_keys($this->data['cats'])));
		$smarty->assign('catNames', json_encode($this->data['cats']? array_values($this->data['cats']): array()));
		$smarty->assign('tags', json_encode($this->data['tags']? $this->data['tags']: array()));
		parent::show($smarty);
	}
}

?>
