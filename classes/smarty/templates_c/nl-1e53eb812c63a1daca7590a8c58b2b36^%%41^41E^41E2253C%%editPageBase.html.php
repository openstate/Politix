<?php /* Smarty version 2.6.18, created on 2008-12-16 13:25:32
         compiled from /var/www/projects/politix/modules/user/pages/admin//roles/php/../content//editPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/modules/user/pages/admin//roles/php/../content//editPageBase.html', 8, false),)), $this); ?>
<a name="EditableRoleEdit"></a><form action="" name="EditableRoleEdit" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['formdata']['id']; ?>
" />
<table class="form">
				
		 
			<tr>
				<th>Naam</th>
				<td><input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
" id="title" onkeyup="revalidate(this.form)" maxlength="40" class="text" /> <span class="error" id="_err_title_0" style="<?php if (! $this->_tpl_vars['formerrors']['title_0']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span></td>
			</tr>
			<tr>
				<th>Site</th>
				<td><select name="site" id="site" onkeyup="revalidate(this.form)">
				<?php $_from = $this->_tpl_vars['formdata']['sites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['site']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['site']; ?>

				<?php endforeach; endif; unset($_from); ?>
				</select><span class="error" id="_err_site_0" style="<?php if (! $this->_tpl_vars['formerrors']['site_0']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span></td>
			</tr>
		<tr>
				<th />
				<td><input type="submit" value="Wijzigen" /> </td>
			</tr>
			</table>
</form><script type="text/javascript"><!--
updateVisibility(document.forms['EditableRoleEdit']) //--></script>