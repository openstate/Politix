<?php /* Smarty version 2.6.18, created on 2009-04-03 10:11:41
         compiled from /var/www/projects/politix/pages/admin/politicians/content/formPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/politicians/content/formPage.html', 9, false),)), $this); ?>


<form action="" name="<?php echo $this->_tpl_vars['form']['name']; ?>
" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
	<h2><?php echo $this->_tpl_vars['form']['header']; ?>
</h2>
	<p><?php echo $this->_tpl_vars['form']['note']; ?>
</p>
	<table class="form">
		<tr>
			<th>Titels</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="title" value="<?php echo $this->_tpl_vars['formdata']['title']; ?>
" onkeyup="revalidate(this.form)" /><?php endif; ?></td>
		</tr>
		<tr>
			<th>Voorletters</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['first_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="first_name" value="<?php echo $this->_tpl_vars['formdata']['first_name']; ?>
" onkeyup="revalidate(this.form)" /><?php endif; ?></td>
		</tr>
		<tr>
			<th>Achternaam</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['last_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="last_name" class="vld_required defErrorHandler" value="<?php echo $this->_tpl_vars['formdata']['last_name']; ?>
" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_last_name_required" style="<?php if (! $this->_tpl_vars['formerrors']['last_name_required']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Geslacht</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php if ($this->_tpl_vars['formdata']['gender'] == 1): ?>Man<?php else: ?>Vrouw<?php endif; ?><?php else: ?><input type="radio" name="gender" value="1"<?php if ($this->_tpl_vars['formdata']['gender'] !== 0): ?> checked="checked"<?php endif; ?>/>Man <input type="radio" name="gender" value="0"<?php if ($this->_tpl_vars['formdata']['gender'] === 0): ?> checked="checked"<?php endif; ?>/>Vrouw<?php endif; ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['email'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="email" class="vld_email_optional defErrorHandler" value="<?php echo $this->_tpl_vars['formdata']['email']; ?>
" onkeyup="revalidate(this.form)"/> <span class="error" id="_err_email_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['email_invalid']): ?>display:none<?php endif; ?>">Ongeldig e-mailadres</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Extern ID</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['extern_id'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="extern_id" class="vld_optional defErrorHandler" value="<?php echo $this->_tpl_vars['formdata']['extern_id']; ?>
"/><?php endif; ?></td>
		</tr>
		<tr>
			<th/>
			<td><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['form']['submitText']; ?>
"/></td>
		</tr>
	</table>
</form>