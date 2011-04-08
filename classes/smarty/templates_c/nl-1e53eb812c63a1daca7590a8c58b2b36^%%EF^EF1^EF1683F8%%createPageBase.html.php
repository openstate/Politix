<?php /* Smarty version 2.6.18, created on 2009-09-18 13:32:27
         compiled from /var/www/projects/politix/public_html/../pages/admin/appointments/php/../content//createPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/var/www/projects/politix/public_html/../pages/admin/appointments/php/../content//createPageBase.html', 7, false),array('function', 'html_select_date', '/var/www/projects/politix/public_html/../pages/admin/appointments/php/../content//createPageBase.html', 19, false),)), $this); ?>
<a name="AppointmentCreate"></a><form action="" name="AppointmentCreate" method="post" enctype="multipart/form-data">
<table class="form">
		
				
		<tr>
			<th>Regio:</th>
			<td><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['regions'],'id' => 'region','name' => 'region','selected' => $this->_tpl_vars['formdata']['region']), $this);?>
 <span class="error" id="_err_region_0" style="<?php if (! $this->_tpl_vars['formerrors']['region_0']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span></td>
		</tr>
		<tr>
			<th>Partij:</th>
			<td><div id="partyDiv"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['parties'],'id' => 'party','name' => 'party','selected' => $this->_tpl_vars['formdata']['party']), $this);?>
 <span class="error" id="_err_party_0" style="<?php if (! $this->_tpl_vars['formerrors']['party_0']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span></div></td>
		</tr>
		<tr>
			<th>Categorie:</th>
			<td><div id="categoryDiv"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categories'],'id' => 'category','name' => 'category','selected' => $this->_tpl_vars['formdata']['category']), $this);?>
 <span class="error" id="_err_category_0" style="<?php if (! $this->_tpl_vars['formerrors']['category_0']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span></div></td>
		</tr>
		<tr>
			<th>Aanvangsdatum:</th>
			<td><?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['formdata']['time_start']['unix'],'field_order' => 'DMY','field_array' => 'date_start','start_year' => 1980,'end_year' => "+10"), $this);?>
 <span class="error" id="_err_time_start_0" style="<?php if (! $this->_tpl_vars['formerrors']['time_start_0']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span></td>
		</tr>
		<tr>
			<th>Einddatum:</th>
			<td><?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['formdata']['time_end']['unix'],'field_order' => 'DMY','field_array' => 'date_end','start_year' => 1980,'end_year' => "+10"), $this);?>
 <span class="error" id="_err_time_end_0" style="<?php if (! $this->_tpl_vars['formerrors']['time_end_0']): ?>display:none<?php endif; ?>">Ongeldige waarde geselecteerd</span><span class="error" id="_err_time_start_1" style="<?php if (! $this->_tpl_vars['formerrors']['time_start_1']): ?>display:none<?php endif; ?>">De einddatum moet groter zijn dan aanvangsdatum</span></td>
		</tr>
		<tr>
			<th>Omschrijving:</th>
			<td><input type="text" name="description" value="<?php echo $this->_tpl_vars['formdata']['description']; ?>
"/></td>
		</tr>
		<tr>
			<td><input type="submit" value="Toevoegen"/> </td>
		</tr>
</table>
</form>