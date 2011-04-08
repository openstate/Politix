<?php /* Smarty version 2.6.18, created on 2008-12-16 13:23:52
         compiled from /var/www/projects/politix/public_html/../pages/admin/party/php/../content//indexPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/public_html/../pages/admin/party/php/../content//indexPageBase.html', 11, false),array('modifier', 'htmlentities', '/var/www/projects/politix/public_html/../pages/admin/party/php/../content//indexPageBase.html', 12, false),array('modifier', 'nl2br', '/var/www/projects/politix/public_html/../pages/admin/party/php/../content//indexPageBase.html', 12, false),array('modifier', 'date_format', '/var/www/projects/politix/public_html/../pages/admin/party/php/../content//indexPageBase.html', 13, false),)), $this); ?>

<a name="PartyList"></a>
<form action="" name="PartyList">
	<table class="list">
		<tr>
			<th><a href="?sortcol=name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a></th>
			<?php if (! $this->_tpl_vars['superAdmin']): ?><th>In <?php echo $this->_tpl_vars['regionName']; ?>
</th><?php endif; ?>
			<th>Opties</th>
		</tr>
		<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
		<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
			<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['party_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
			<?php if (! $this->_tpl_vars['superAdmin']): ?><td><?php if ($this->_tpl_vars['localParties'][$this->_tpl_vars['id']]): ?><?php if ($this->_tpl_vars['localParties'][$this->_tpl_vars['id']]->time_start > $this->_tpl_vars['now']): ?>Per <?php echo ((is_array($_tmp=$this->_tpl_vars['localParties'][$this->_tpl_vars['id']]->time_start)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php else: ?><?php if ($this->_tpl_vars['localParties'][$this->_tpl_vars['id']]->time_end != @POS_INFINITY): ?>Tot <?php echo ((is_array($_tmp=$this->_tpl_vars['localParties'][$this->_tpl_vars['id']]->time_end)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php else: ?>Ja<?php endif; ?><?php endif; ?><?php else: ?>Nee<?php endif; ?></td><?php endif; ?>
			<td><?php if ($this->_tpl_vars['datarow']['canEdit']): ?>
				<a href="/party/edit/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
				<a href="/party/delete/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a><?php endif; ?>
				<?php if ($this->_tpl_vars['superAdmin']): ?>
				<a href="/party/regions/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/link.png" border="0" alt="Wijzig Regio" title="Wijzig Regio" /></a>
				<?php else: ?>
				<a href="/party/regionLink/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/link.png" border="0" alt="Wijzig koppeling" title="Wijzig koppeling" /></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
</form>