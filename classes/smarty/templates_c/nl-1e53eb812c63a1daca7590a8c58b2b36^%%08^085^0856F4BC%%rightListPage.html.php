<?php /* Smarty version 2.6.18, created on 2008-12-16 13:25:06
         compiled from /var/www/projects/politix/modules/user/pages/admin/roles/content/rightListPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/modules/user/pages/admin/roles/content/rightListPage.html', 7, false),)), $this); ?>
 
<h2>Rechten</h2>
<table class="list">
	<tr><th>Module</th><th>Recht</th></tr>
	<?php $_from = $this->_tpl_vars['rights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module'] => $this->_tpl_vars['rights']):
?>
		<?php $_from = $this->_tpl_vars['rights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['right']):
?>
			<tr <?php echo smarty_function_cycle(array('values' => ',class="alt"'), $this);?>
>
				<td><?php echo $this->_tpl_vars['module']; ?>
</td>
				<td><?php echo $this->_tpl_vars['right']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>
</table>