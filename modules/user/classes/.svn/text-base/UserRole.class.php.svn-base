<?php

class UserRole extends Record {

	protected $tableName = 'usr_bo_roles';
	protected $multiTables = 'usr_bo_roles t LEFT JOIN usr_bo_users_roles ur ON ur.roleid = t.id';
	protected $data = array(					
					'userid' => null,
					'title' => null,
				);
	protected $extraCols = array(
					'userid' => 'ur.userid',
				);
				
				
	public function getAllRoles() {
		return $this->getList();
	}
}


?>