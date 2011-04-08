<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:45
         compiled from /var/www/projects/politix/modules/user/pages/admin///roles/php/../content//indexPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/modules/user/pages/admin///roles/php/../content//indexPageBase.html', 11, false),array('modifier', 'htmlentities', '/var/www/projects/politix/modules/user/pages/admin///roles/php/../content//indexPageBase.html', 12, false),array('modifier', 'nl2br', '/var/www/projects/politix/modules/user/pages/admin///roles/php/../content//indexPageBase.html', 12, false),)), $this); ?>
<a name="EditableRoleList"></a><form action="" name="EditableRoleList">
<table class="list">
				
		 
		<tr>
			<th><a href="?sortcol=title&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'title' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'title'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a></th>
			<th>Site</th>
			<th>Opties</th>
		</tr>
		<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
		<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
			<td class="link"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
			<td class="link"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['site'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
			<td class="options"><a href="/users/roles/assignRights/<?php echo $this->_tpl_vars['id']; ?>
/">Rechten toekennen</a>
								<a href="/users/roles/edit/<?php echo $this->_tpl_vars['id']; ?>
/"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
								<a href="/users/roles/delete/<?php echo $this->_tpl_vars['id']; ?>
/" onclick="return confirm('Weet u zeker dat u dit item wilt verwijderen?')"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>

			</table>
</form>