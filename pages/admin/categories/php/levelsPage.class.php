<?php

require_once('Category.class.php');
require_once('Level.class.php');


class LevelsPage {
	protected $id;
	protected $db;
	protected $message;

	public function __construct() {
		$this->db = DBs::inst(DBs::SYSTEM);
	}

	public function processGet($get) {
		if (!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
		$this->id = $get['id'];
	}

	public function processPost($post) {
		if (!isset($post['category']) || !ctype_digit($post['category']))
			Dispatcher::header('../');
		$this->db->query('BEGIN');
		try {
			$this->db->query('DELETE FROM sys_category_regions WHERE category = %', $post['category']);
			foreach ($post['check'] as $key => $chk) {
				$this->db->query('INSERT INTO sys_category_regions (category, level, description) VALUES (%,%,%)', $post['category'], $key, $post['desc'][$key]);
			}
		} catch (Exception $e) {
			$this->db->query('ROLLBACK');
			$this->message = 'Er is een fout opgetreden.';
		}
		$this->db->query('COMMIT');
		$this->message = 'De wijzigingen zijn doorgevoerd.';
	}

	public function show($smarty) {
		$c = new Category($this->id);
		$catLevels = $this->db->query('SELECT * FROM sys_levels l LEFT JOIN (SELECT * FROM sys_category_regions WHERE category = %) cr ON l.id = cr.level ORDER BY l.id', $this->id)->fetchAllRows();
		$smarty->assign('levels', $catLevels);
		$smarty->assign('category', $c);
		if (strlen($this->message) > 0)
			$smarty->assign('message', $this->message);
		$smarty->display("levelsPage.html");
	}
}

?>