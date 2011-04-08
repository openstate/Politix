<?php

require_once('Tag.class.php');
require_once('Category.class.php');

class tagsPage {
	protected $id = null;
	protected $edit = null;
	private $message = '';
	private $formdata = null;

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
			
		$this->id = $get['id'];
		if(isset($get['edit']) && ctype_digit($get['edit']))
			$this->edit = $get['edit'];
	}
	
	public function processPost($post) {
		if(isset($post['delete'])) {
			if(!isset($post['tag']))
				return;
			foreach($post['tag'] as $id) {
				$tag = new Tag();
				$tag->load($id);
				$tag->delete();
			}		
			$this->message = 'Tags verwijderd';
			return;
		} elseif(isset($post['add'])) {
			if(!isset($post['name']) || $post['name'] == '') {
				$this->formdata = $post;
				return;
			}
			$tag = new Tag();
			$tag->name = $post['name'];
			$tag->category = $this->id;
			$tag->save();
			$this->message = 'Tag toegevoegd';
			return;
		} elseif(isset($post['edit'])) {
			if(!isset($post['name']) || $post['name'] == '') {
				$this->formdata = $post;
				return;
			}
			$tag = new Tag();
			$tag->load($post['id']);
			$tag->name = $post['name'];
			$tag->save();
			dispatcher::header('/categories/tags/' . $post['category']);
			die;
		}
	}

	public function show($smarty) {
		if($this->formdata != null)
			$smarty->assign('formdata', $this->formdata);
		if($this->edit !== null) {
			$tag= new Tag();
			$tag->load($this->edit);
			$smarty->assign('id', $this->id);
			$smarty->assign('formdata', array('id' => $tag->id, 'name' => $tag->name));
			$smarty->display('tagsEditPage.html');
			die;
		}		
	
		$tag = new Tag();
		$tags = $tag->getList($where = 'WHERE category = ' . $this->id, $order = 'ORDER BY name');
		
		$category = new Category();
		$category->load($this->id);
		$smarty->assign('category', $category);
		
		$smarty->assign('tags', $tags);
		if($this->message != '') $smarty->assign('message', $this->message);
		$smarty->display('tagsPage.html');
	}
}

?>