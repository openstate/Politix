<?php /* Smarty version 2.6.18, created on 2008-12-16 13:25:41
         compiled from /var/www/projects/politix/public_html/../pages/admin/user/php/../content//indexPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/public_html/../pages/admin/user/php/../content//indexPageBase.html', 6, false),array('modifier', 'htmlentities', '/var/www/projects/politix/public_html/../pages/admin/user/php/../content//indexPageBase.html', 6, false),array('modifier', 'nl2br', '/var/www/projects/politix/public_html/../pages/admin/user/php/../content//indexPageBase.html', 6, false),)), $this); ?>
<a name="BackofficeUserList"></a><form action="" name="BackofficeUserList">
<table class="list">
								
		<tr><th><a href="?sortcol=username&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'username' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'username'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Gebruikersnaam</a></th><th><a href="?sortcol=firstname&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'firstname' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'firstname'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Voornaam</a></th><th><a href="?sortcol=lastname&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'lastname' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'lastname'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Achternaam</a></th><th>Opties</th></tr>
			<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
"><td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['username'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td><td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['firstname'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td><td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['lastname'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td><td><a href="edit/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/edit.png" alt="Edit" title="Edit" border="0" /></a>
					<a href="delete/<?php echo $this->_tpl_vars['datarow']['id']; ?>
" onclick="return confirm('Weet u zeker dat u dit item wilt verwijderen?');"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
					<a href="role/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/r.gif" border="0" alt="Wijzig Rol" title="Wijzig Rol" /></a>
					<a href="region/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/g.gif" border="0" alt="Wijzig Griffies" title="Wijzig Griffies" /></a></td></tr>
<?php endforeach; endif; unset($_from); ?>

			</table>
</form>