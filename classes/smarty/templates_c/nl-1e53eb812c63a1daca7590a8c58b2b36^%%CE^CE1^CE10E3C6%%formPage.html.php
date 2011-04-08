<?php /* Smarty version 2.6.18, created on 2009-03-11 15:27:41
         compiled from /var/www/projects/politix/pages/admin/party/content/formPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/party/content/formPage.html', 10, false),array('function', 'html_options', '/var/www/projects/politix/pages/admin/party/content/formPage.html', 15, false),)), $this); ?>



<form action="" name="<?php echo $this->_tpl_vars['form']['name']; ?>
" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
	<h2><?php echo $this->_tpl_vars['form']['header']; ?>
</h2>
	<p><?php echo $this->_tpl_vars['form']['note']; ?>
</p>
	<table class="form">
		<tr>
			<th>Naam</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="title" value="<?php echo $this->_tpl_vars['formdata']['title']; ?>
" id="title" class="large vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_title_required" style="<?php if (! $this->_tpl_vars['formerrors']['title_required']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span><?php endif; ?></td>
		</tr>
		<?php if ($this->_tpl_vars['showOwner'] && ! $this->_tpl_vars['form']['freeze']): ?>
		<tr>
			<th>Niveau</th>
			<td><?php echo smarty_function_html_options(array('name' => 'owner','options' => $this->_tpl_vars['regions'],'selected' => $this->_tpl_vars['formdata']['owner']), $this);?>
</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th>Combinatiepartij</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php if ($this->_tpl_vars['formdata']['combination']): ?>Ja<?php else: ?>Nee<?php endif; ?><?php else: ?><input type="checkbox" name="combination" id="combination" onclick="revalidate(this.form)"<?php if ($this->_tpl_vars['formdata']['combination']): ?> checked="checked"<?php endif; ?>/><?php endif; ?></td>
		</tr>
		<?php if (! $this->_tpl_vars['form']['freeze'] || $this->_tpl_vars['formdata']['combination']): ?>
		<tr id="tr_parents"<?php if (! $this->_tpl_vars['formdata']['combination']): ?> style="display:none"<?php endif; ?>>
			<th>Combinatie van</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php $_from = $this->_tpl_vars['formdata']['parents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i']):
        $this->_foreach['foo']['iteration']++;
?><?php echo $this->_tpl_vars['parties'][$this->_tpl_vars['i']]; ?>
<?php if (! ($this->_foreach['foo']['iteration'] == $this->_foreach['foo']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?>
				<?php else: ?><?php echo smarty_function_html_options(array('name' => "parents[]",'id' => 'parents','multiple' => 'multiple','class' => 'idErrorHandler','size' => '16','options' => $this->_tpl_vars['parties'],'selected' => $this->_tpl_vars['formdata']['parents'],'onclick' => "revalidate(this.form)"), $this);?>
 <span class="error" id="_err_parents_required" style="<?php if (! $this->_tpl_vars['formerrors']['parents_required']): ?>display:none<?php endif; ?>">Een combinatiepartij dient uit minimaal twee partijen te bestaan</span><?php endif; ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th/>
			<td><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['form']['submitText']; ?>
"/></td>
		</tr>
	</table>
</form>