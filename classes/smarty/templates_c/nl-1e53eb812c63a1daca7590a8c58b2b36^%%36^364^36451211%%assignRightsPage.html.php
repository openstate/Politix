<?php /* Smarty version 2.6.18, created on 2008-12-16 13:25:01
         compiled from /var/www/projects/politix/modules/user/pages/admin/roles/content/assignRightsPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/modules/user/pages/admin/roles/content/assignRightsPage.html', 11, false),)), $this); ?>
 
<h2>Rechten toekennen</h2>
<p>Rol: <?php echo $this->_tpl_vars['role']->title; ?>
</p>

<p><a href="/users/roles/rightList/">Bekijk alle gebruikte rechten</a></p>

<table class="list">
	<tr><th>Module</th><th>Recht</th><th>Opties</th></tr>
	<?php $_from = $this->_tpl_vars['role']->getRights(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
				<td><a href="/users/roles/removeRight/<?php echo $this->_tpl_vars['role']->id; ?>
/?module=<?php echo $this->_tpl_vars['module']; ?>
&right=<?php echo $this->_tpl_vars['right']; ?>
">Verwijderen</a></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>
	<form action="/users/roles/addRight/<?php echo $this->_tpl_vars['role']->id; ?>
/" method="post">
		<tr <?php echo smarty_function_cycle(array('values' => ',class="alt"'), $this);?>
>
			<td><input type="text" name="module" /></td>
			<td><input type="text" name="right" /></td>
			<td><input type="submit" value="Toevoegen"></td>
		</tr>
	</form>
</table>