<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:22
         compiled from /var/www/projects/politix/pages/admin/categories/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/categories/content/indexPage.html', 18, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/categories/content/indexPage.html', 19, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/admin/categories/content/indexPage.html', 20, false),)), $this); ?>
<h2>Categorie&euml;n</h2>

<?php if ($this->_tpl_vars['error']): ?><p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p><?php endif; ?>

<p><a href="create/"><img src="/images/add.png" border="0" title="Toevoegen" alt="Toevoegen"/></a> <a href="create/">Toevoegen</a></p>

<a name="CategoryList"></a>
<form action="" name="CategoryList">
	<div id="accordion">
		<table class="list">
			<tr>
				<th><a href="?sortcol=name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a></th>
				<th>Beschrijving</th>
				<th>Opties</th>
			</tr>
			<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
			<?php if ($this->_tpl_vars['datarow']['id'] > 0): ?>
			<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['category_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
</td>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['description'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
				<td>
					<a href="edit/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/edit.png" alt="Edit" title="Edit" border="0" /></a>
					<a href="delete/<?php echo $this->_tpl_vars['datarow']['id']; ?>
" onclick="return confirm('Weet u zeker dat u dit item wilt verwijderen?');"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
					<a href="levels/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/page_white_text.png" border="0" alt="Wijzig Niveaus" title="Wijzig Niveaus" /></a>
				</td>
			</tr>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</table>
	</div>
</form>