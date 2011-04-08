<?php /* Smarty version 2.6.18, created on 2009-09-07 19:11:27
         compiled from /var/www/projects/politix/pages/admin/appointments/content/formPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', '/var/www/projects/politix/pages/admin/appointments/content/formPage.html', 11, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/appointments/content/formPage.html', 20, false),array('function', 'html_options', '/var/www/projects/politix/pages/admin/appointments/content/formPage.html', 11, false),array('function', 'html_select_date', '/var/www/projects/politix/pages/admin/appointments/content/formPage.html', 20, false),)), $this); ?>



<h2><?php echo $this->_tpl_vars['form']['header']; ?>
</h2>
<p><?php echo $this->_tpl_vars['form']['note']; ?>
</p>
<form action="" name="<?php echo $this->_tpl_vars['form']['name']; ?>
" method="post" onsubmit="return formSubmit(this)">
	<table class="form">
		<?php if ($this->_tpl_vars['form']['showPolitician']): ?>
		<tr>
			<th>Politicus</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['politician_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['politicians'],'id' => 'politician','name' => 'politician','selected' => $this->_tpl_vars['formdata']['politician'],'class' => 'vld_required_select defErrorHandler'), $this);?>
 <a href="/appointments/createPolitician/" title="Politicus toevoegen"><img style="border: 0px" alt="Politicus toevoegen" src="/images/add.png"/></a><span class="error" id="_err_politician_required" style="<?php if (! $this->_tpl_vars['formerrors']['politician_required']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span><?php endif; ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th>Categorie</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['category_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><?php echo smarty_function_html_options(array('name' => 'category','options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['formdata']['category']), $this);?>
 <span class="error" id="_err_category_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['category_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Aanvangsdatum</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php if ($this->_tpl_vars['formdata']['time_start'] == '--'): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['time_start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?><?php else: ?><?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['formdata']['time_start'],'field_order' => 'DMY','prefix' => 'TS_','day_empty' => "",'month_empty' => "",'year_empty' => "",'start_year' => 1980,'end_year' => "+10"), $this);?>
 <span class="error" id="_err_time_start_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['time_start_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Einddatum</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php if ($this->_tpl_vars['formdata']['time_end'] == '--'): ?>Geen<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['time_end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php endif; ?><?php else: ?><?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['formdata']['time_end'],'field_order' => 'DMY','prefix' => 'TE_','day_empty' => "",'month_empty' => "",'year_empty' => "",'start_year' => 1980,'end_year' => "+10"), $this);?>
 <span class="error" id="_err_time_end_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['time_end_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><span class="error" id="_err_time_negative" style="<?php if (! $this->_tpl_vars['formerrors']['time_negative']): ?>display:none<?php endif; ?>">De einddatum moet groter zijn dan aanvangsdatum</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Omschrijving</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['description'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="description" class="large" value="<?php echo $this->_tpl_vars['formdata']['description']; ?>
"/><?php endif; ?></td>
		</tr>
		<tr>
			<th/>
			<td><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['form']['submitText']; ?>
"/></td>
		</tr>
	</table>
</form>