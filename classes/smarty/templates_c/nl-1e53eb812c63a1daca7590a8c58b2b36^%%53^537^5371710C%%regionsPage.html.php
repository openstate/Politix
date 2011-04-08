<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:00
         compiled from /var/www/projects/politix/pages/admin/party/content/regionsPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/party/content/regionsPage.html', 16, false),array('function', 'html_options', '/var/www/projects/politix/pages/admin/party/content/regionsPage.html', 39, false),array('function', 'html_select_date', '/var/www/projects/politix/pages/admin/party/content/regionsPage.html', 50, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/party/content/regionsPage.html', 20, false),)), $this); ?>
<h2>Regio's voor <?php echo $this->_tpl_vars['party']->name; ?>
</h2>

<p>
	<a href="/party/"><img src="/images/arrow_turn_up.png" title="Terug" alt="Terug" border="0" /></a>&nbsp;<?php echo $this->_tpl_vars['party']->name; ?>

</p>
<form id="partyListForm" method="post" action="">
<table class="list"><tr>
	<th>&nbsp;</th>
	<th>Regio</th>
	<th>Aanvangsdatum</th>
	<th>Einddatum</th>
		<th>Opties</th>
</tr>
<?php $_from = $this->_tpl_vars['prs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pr']):
?>
<tr class="link<?php echo smarty_function_cycle(array('values' => ", alt"), $this);?>
">
	<td><input type="checkbox" name="prs[]" value="<?php echo $this->_tpl_vars['pr']->id; ?>
" class="checkbox" /></td>
	<td><?php echo $this->_tpl_vars['pr']->formatRegionName(); ?>
</td>
		<td><?php if ($this->_tpl_vars['pr']->time_start == @NEG_INFINITY): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['pr']->time_start)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['pr']->time_end == @POS_INFINITY): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['pr']->time_end)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?></td>
	<td>
		<a href="?edit=<?php echo $this->_tpl_vars['pr']->id; ?>
"><img src="/images/edit.png" title="Wijzigen" alt="Wijzigen" border="0"/></a>
		<a href="/appointments/createParty/<?php echo $this->_tpl_vars['pr']->id; ?>
"><img src="/images/add.png" border="0" alt="Aanstelling toevoegen" title="Aanstelling toevoegen" /></a>
	</td>
</tr>
<?php endforeach; else: ?>
<tr class="link"><td>&nbsp;</td><td>Geen regio's aanwezig</td></tr>
<?php endif; unset($_from); ?>
</table>
<div id="selects_java"></div>
<input type="submit" name="delete" value="Verwijder geselecteerde(n)"/>
</form>
<br/><br/>
<form id="prsAddForm" method="post" action="">
<table class="form"><tr>
	<th>Regio</th>
	<td>
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['regions'],'name' => 'region','selected' => $this->_tpl_vars['formdata']['region']), $this);?>

	</td>
</tr>
	<tr>
		<th>Aanvangsdatum</th>
		<td><?php echo smarty_function_html_select_date(array('name' => 'time_start','time' => $this->_tpl_vars['formdata']['time_start'],'field_order' => 'DMY','prefix' => 'TS_','day_empty' => "",'month_empty' => "",'year_empty' => "",'start_year' => -5,'end_year' => "+5"), $this);?>
 <span class="error" id="_err_time_start_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['time_start_invalid']): ?>display:none<?php endif; ?>">Ongeldige datum</span></td>
	</tr>
	<tr>
		<th>Einddatum</th>
		<td><?php echo smarty_function_html_select_date(array('name' => 'time_end','time' => $this->_tpl_vars['formdata']['time_end'],'field_order' => 'DMY','prefix' => 'TE_','day_empty' => "",'month_empty' => "",'year_empty' => "",'start_year' => -5,'end_year' => "+5"), $this);?>
 <span class="error" id="_err_time_end_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['time_end_invalid']): ?>display:none<?php endif; ?>">Ongeldige datum</span></td>
	</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="add" value="Toevoegen" /></td>
</tr></table>
</form>