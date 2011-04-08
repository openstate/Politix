<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:25
         compiled from /var/www/projects/politix/pages/admin/pages/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/pages/content/indexPage.html', 12, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/pages/content/indexPage.html', 13, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/admin/pages/content/indexPage.html', 13, false),)), $this); ?>



<h2>Teksten</h2>
<table class="list">
	<tr>
		<th>URL</a></th>
		<th>Titel</a></th>
		<th>Opties</th>
	</tr>
	<?php $_from = $this->_tpl_vars['default']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->url)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td>
			<a class="edit" href="edit/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
			<?php if ($this->_tpl_vars['region'] == $this->_tpl_vars['datarow']->region): ?>
			<a href="delete/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr><td colspan="3">Geen pagina's gevonden</td></tr>
	<?php endif; unset($_from); ?>
</table>
<div style="padding: 30px 0"/>
<h2>Pagina's</h2>
<p><a href="create/"><img src="/images/add.png" alt="Toevoegen" title="Toevoegen" border="0"/></a> <a href="create/">Toevoegen</a></p>
<table class="list">
	<tr>
		<th><a href="?sortcol=url&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'url' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'url'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">URL</a></th>
		<th><a href="?sortcol=title&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'title' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'title'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Titel</a></th>
		<th><a href="?sortcol=linkText&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'linkText' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'linkText'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Linktekst</a></th>
		<th>Opties</th>
	</tr>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->url)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->linkText)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td>
			<a class="edit" href="edit/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
			<a href="delete/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>					
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr><td colspan="4">Geen pagina's gevonden</td></tr>
	<?php endif; unset($_from); ?>
</table>