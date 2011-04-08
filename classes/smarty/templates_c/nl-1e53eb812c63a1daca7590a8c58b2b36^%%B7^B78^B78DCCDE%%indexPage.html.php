<?php /* Smarty version 2.6.18, created on 2008-12-16 13:11:13
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html', 17, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html', 18, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html', 18, false),array('modifier', 'truncate', '/var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html', 19, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/raadsstukken/content/indexPage.html', 21, false),)), $this); ?>
<h2>Voorstellen</h2>



<?php if ($this->_tpl_vars['pager']): ?><p class="pager"><?php echo $this->_tpl_vars['pager']; ?>
</p><?php endif; ?>
<p><a href="create/"><img src="/images/add.png" alt="Toevoegen" title="Toevoegen" border="0"/></a> <a href="create/">Toevoegen</a></p>
<table class="list">
	<tr>
		<th><a href="?sortcol=code&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'code' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'code'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Code</a></th>
		<th><a href="?sortcol=title&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'title' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'title'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Titel</a></th>
		<th><a href="?sortcol=site&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'site' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'site'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Site</a></th>
		<th><a href="?sortcol=vote_date&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_date' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_date'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Stemdatum</a></th>
		<th><a href="?sortcol=type_name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'type_name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'type_name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Soort</a></th>
		<th>Opties</th>
	</tr>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->code)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('truncate', true, $_tmp, 120) : smarty_modifier_truncate($_tmp, 120)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->site)) ? $this->_run_mod_handler('truncate', true, $_tmp, 120) : smarty_modifier_truncate($_tmp, 120)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
</td>
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->type_name)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td>
			<?php if ($this->_tpl_vars['datarow']->showVotes()): ?><a class="vote" href="vote/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/page_white_text.png" alt="Stemming" title="Stemming" border="0" /></a><?php endif; ?>
			<a class="edit" href="edit/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
			<a href="delete/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr><td colspan="2">Geen voorstellen gevonden</td></tr>
	<?php endif; unset($_from); ?>
</table>