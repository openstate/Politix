<?php /* Smarty version 2.6.18, created on 2009-06-09 11:40:38
         compiled from /var/www/projects/politix/pages/admin/appointments/content/partyPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', '/var/www/projects/politix/pages/admin/appointments/content/partyPage.html', 4, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/appointments/content/partyPage.html', 33, false),array('function', 'cycle', '/var/www/projects/politix/pages/admin/appointments/content/partyPage.html', 30, false),)), $this); ?>



<h2>Politici <?php echo ((is_array($_tmp=$this->_tpl_vars['localparty']->party_name)) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
 (<?php echo $this->_tpl_vars['localparty']->formatRegionName(); ?>
)</h2>
<p>
<?php if ($this->_tpl_vars['includeExpired']): ?><a href="/appointments/party/<?php echo $this->_tpl_vars['localparty']->id; ?>
?curr">Verberg verlopen aanstellingen</a>
<?php else: ?><a href="/appointments/party/<?php echo $this->_tpl_vars['localparty']->id; ?>
?all">Toon verlopen aanstellingen</a><?php endif; ?>
</p>
<p><a href="../createParty/"><img src="/images/add.png" border="0" title="Toevoegen" alt="Toevoegen"/></a> <a href="../createParty/">Toevoegen</a></p>
<table class="list">
	<tr>
		<th>
			<a href="?sortcol=name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a>
		</th>
		<th>
			<a href="?sortcol=cat_name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'cat_name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'cat_name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Categorie</a>
		</th>
		<th>
			<a href="?sortcol=time_start&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'time_start' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'time_start'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Aanvangsdatum</a>
		</th>
		<th>
			<a href="?sortcol=time_end&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'time_end' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'time_end'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Einddatum</a>
		</th>
		<th>
			<a href="?sortcol=description&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'description' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'description'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Omschrijving</a>
		</th>
		<th>Opties</th>
	</tr>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><?php echo $this->_tpl_vars['datarow']['name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['datarow']['cat_name']; ?>
</td>
		<td><?php if ($this->_tpl_vars['datarow']['time_start'] == @NEG_INFINITY): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['time_start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?></td>
		<td><?php if ($this->_tpl_vars['datarow']['time_end'] == @POS_INFINITY): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['time_end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?></td>
		<td><?php echo $this->_tpl_vars['datarow']['description']; ?>
</td>
		<td>
			<a href="../edit/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
			<a href="../delete/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
			<a href="/appointments/<?php echo $this->_tpl_vars['datarow']['pid']; ?>
" class="app"><img src="/images/user_go.png" alt="Aanstellingen politicus" title="Aanstellingen politicus" border="0" /></a>
			<a href="/politicians/edit/<?php echo $this->_tpl_vars['datarow']['pid']; ?>
"><img src="/images/user_edit.png" alt="Politicus aanpassen" title="Politicus aanpassen" border="0" /></a>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr>
		<td colspan="7">Geen</td>
	</tr>
	<?php endif; unset($_from); ?>
</table>
