<?php

class EditableRole extends Record {
	protected $data = array(
		'title' => '',
		'site_id' => ''
	);
	protected $tableName =  'usr_bo_roles';
	protected $accessTable = 'usr_bo_roles_access';

	protected $rights = array();
	protected $loadedRights = false;

	public function loadFromArray(array $data) {
		parent::loadFromArray($data);
	}

	protected function loadRights() {
		if (!$this->id || $this->loadedRights)
			return;
		$this->rights = $this->db->query('SELECT access, module FROM '.$this->accessTable.' WHERE roleid=%', $this->id)->fetchAllCells('access', 'module');
		$this->loadedRights = true;
	}

	public function save() {
		parent::save();

		if ($this->loadedRights) {
			$this->db->query('BEGIN');
			$this->db->query('DELETE FROM '.$this->accessTable.' WHERE roleid=%', $this->id);
			foreach ($this->rights as $module => $rights)
				foreach ($rights as $access)
					$this->db->query('INSERT INTO '.$this->accessTable.' (roleid, module, access) VALUES (%, %, %)', $this->id, $module, $access);
			$this->db->query('COMMIT');
		}
	}

	public function delete($id = false) {
		if (!$id)
			$id = $this->id;
		parent::delete($id);
		$this->db->query('DELETE FROM '.$this->accessTable.' WHERE roleid=%', $id);
	}

	public function addRight($module, $access) {
		$this->loadRights();
		$this->rights[$module][$access] = $access;
	}

	public function removeRight($module, $access) {
		$this->loadRights();
		unset($this->rights[$module][$access]);
	}

	public function getRights() {
		$this->loadRights();
		return $this->rights;
	}

	public function getAllRights() {
		return $this->db->query('SELECT DISTINCT access, module FROM '.$this->accessTable)->fetchAllCells('access', 'module');
	}
}

?>