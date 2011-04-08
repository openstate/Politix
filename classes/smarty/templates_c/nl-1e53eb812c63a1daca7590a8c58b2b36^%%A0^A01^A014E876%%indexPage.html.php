<?php /* Smarty version 2.6.18, created on 2008-12-16 13:23:52
         compiled from /var/www/projects/politix/pages/admin/party/content/indexPage.html */ ?>
<h2>Partijen</h2>

<form method="get" action="/party/">
<label for="region">Zoek in regio:</label>
<select name="region" id="region">
	<option value="-1"<?php if (! isset ( $this->_tpl_vars['selectedRegion'] ) || $this->_tpl_vars['selectedRegion'] == -1): ?> selected="selected"<?php endif; ?>>Alle partijen</option>
	<option value="false"<?php if ($this->_tpl_vars['selectedRegion'] == 'false'): ?> selected="selected"<?php endif; ?>>Partijen zonder regio</option>
<?php $_from = $this->_tpl_vars['regions']['root']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
	<option value="<?php echo $this->_tpl_vars['region']->id; ?>
"<?php if ($this->_tpl_vars['selectedRegion'] == $this->_tpl_vars['region']->id): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['region']->name; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['parents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
	<optgroup label="<?php echo $this->_tpl_vars['parent']->formatName(); ?>
">
	<?php $this->assign('id', $this->_tpl_vars['parent']->id); ?>
	<?php $_from = $this->_tpl_vars['regions'][$this->_tpl_vars['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
		<option value="<?php echo $this->_tpl_vars['region']->id; ?>
"<?php if ($this->_tpl_vars['selectedRegion'] == $this->_tpl_vars['region']->id): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['region']->name; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	</optgroup>
<?php endforeach; endif; unset($_from); ?>
</select>
<input type="submit" value="Zoeken" />
</form>

<?php if ($this->_tpl_vars['pager']): ?><p class="pager"><?php echo $this->_tpl_vars['pager']; ?>
</p><?php endif; ?>
<p><a href="./create/"><img src="/images/add.png" alt="Toevoegen" title="Toevoegen" border="0"/></a> <a href="./create/">Toevoegen</a></p>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."/indexPageBase.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>