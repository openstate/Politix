<?php /* Smarty version 2.6.18, created on 2008-12-16 13:11:19
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 10, false),array('modifier', 'htmlspecialchars', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 11, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 22, false),array('modifier', 'implode', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 26, false),array('modifier', 'truncate', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 52, false),array('modifier', 'default', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 78, false),array('function', 'html_options', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 11, false),array('function', 'html_select_date', '/var/www/projects/politix/pages/admin/raadsstukken/content/formPage.html', 22, false),)), $this); ?>



<form action="" name="<?php echo $this->_tpl_vars['form']['name']; ?>
" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
	<h2><?php echo $this->_tpl_vars['form']['header']; ?>
</h2>
	<p><?php echo $this->_tpl_vars['form']['note']; ?>
</p>
	<table class="form">
		<tr>
			<th>Site</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
test<?php else: ?>
				<?php echo smarty_function_html_options(array('id' => 'site','name' => 'site','options' => ((is_array($_tmp=$this->_tpl_vars['sites'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)),'selected' => $this->_tpl_vars['formdata']['site_id']), $this);?>

				<span class="error" id="_err_site_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['site_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>Titel</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="title" value="<?php echo $this->_tpl_vars['formdata']['title']; ?>
" id="title" class="large vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_title_required" style="<?php if (! $this->_tpl_vars['formerrors']['title_required']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Stemdatum</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['vote_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
<?php else: ?><?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['formdata']['vote_date'],'field_order' => 'DMY','start_year' => -10,'end_year' => "+10",'day_extra' => 'id="day"','month_extra' => 'id="month"','year_extra' => 'id="year"','all_extra' => 'onchange="dateOnChange();"'), $this);?>
 <span class="error" id="_err_date_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['date_invalid']): ?>display:none<?php endif; ?>">Ongeldige datum</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Onderwerp(en)</th>
			<td id="categories"><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=', ')) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['formdata']['cats']) : implode($_tmp, $this->_tpl_vars['formdata']['cats'])); ?>
<?php else: ?><div id="cat_list"<?php if ($this->_tpl_vars['formdata']['cats']['length'] == 0): ?> style="display: none"<?php endif; ?>></div><?php echo smarty_function_html_options(array('id' => 'cat_select','name' => 'category','options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['formdata']['category']), $this);?>
<span class="cat_add"><img src="/images/add.png" class="cat_add" alt="Categorie toevoegen" title="Categorie toevoegen"/>Geselecteerd onderwerp toevoegen</span> <span class="error" id="_err_category_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['category_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Samenvatting</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><div class="summary"><?php echo $this->_tpl_vars['formdata']['summary']; ?>
</div><?php else: ?><textarea name="summary" class="richtext" rows="5" cols="40"><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['summary'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</textarea> <span class="error" id="_err_summary_too_large" style="<?php if (! $this->_tpl_vars['formerrors']['summary_too_large']): ?>display:none<?php endif; ?>">De waarde is te groot voor dit veld</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Code</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['code'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="code" class="vld_required defErrorHandler" value="<?php echo $this->_tpl_vars['formdata']['code']; ?>
" onkeyup="revalidate(this.form)"/> <span class="error" id="_err_code_required" style="<?php if (! $this->_tpl_vars['formerrors']['code_required']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Tags</th>
			<td id="tags"><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=', ')) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['formdata']['tags']) : implode($_tmp, $this->_tpl_vars['formdata']['tags'])); ?>
<?php else: ?><div id="tag_list"<?php if ($this->_tpl_vars['formdata']['tags']['length'] == 0): ?> style="display: none"<?php endif; ?>></div><input type="text" id="tag_text"/><img src="/images/add.png" id="tag_add" alt="Tag toevoegen" title="Tag toevoegen"/><?php endif; ?></td>
		</tr>
		<tr>
			<th>Toon op homepage</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php if ($this->_tpl_vars['formdata']['show']): ?>Ja<?php else: ?>Nee<?php endif; ?><?php else: ?><input type="checkbox" name="show" value="1"<?php if ($this->_tpl_vars['formdata']['show']): ?> checked="checked"<?php endif; ?>/><?php endif; ?></td>
		</tr>
		<tr>
			<th>Soort</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['type_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><?php echo smarty_function_html_options(array('id' => 'type','name' => 'type','options' => $this->_tpl_vars['types'],'selected' => $this->_tpl_vars['formdata']['type']), $this);?>
 <span class="error" id="_err_type_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['type_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<?php if (! $this->_tpl_vars['form']['freeze']): ?><tr id="parent_row"<?php if ($this->_tpl_vars['formdata']['type'] != 3 && $this->_tpl_vars['formdata']['type'] != 4): ?> style="display: none"<?php endif; ?>>
			<th>Voorstel</th>
			<td>
				<span id="parent_el">
					<?php echo smarty_function_html_options(array('id' => 'parent','name' => 'parent','options' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['rs_parents'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80) : smarty_modifier_truncate($_tmp, 80)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)),'selected' => $this->_tpl_vars['formdata']['parent']), $this);?>

				</span>
				<input type="checkbox" name="unrestrict_parent" id="unrestrict_parent"<?php if ($this->_tpl_vars['formdata']['unrestrict_parent']): ?> checked="checked"<?php endif; ?> onchange="unrestrictParentOnChange();" />
				Alle voorstellen tonen
			</td>
		</tr><?php endif; ?>
		<tr>
			<th>Ingediend door</th>
			<td id="sub_el">
				<?php if ($this->_tpl_vars['form']['freeze']): ?>
					<?php if ($this->_tpl_vars['formdata']['submit_type'] == 3): ?>
						<?php $_from = $this->_tpl_vars['formdata']['submitters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i']):
        $this->_foreach['foo']['iteration']++;
?>
							<?php if (isset ( $this->_tpl_vars['councilMembers'][$this->_tpl_vars['i']] )): ?><?php echo $this->_tpl_vars['councilMembers'][$this->_tpl_vars['i']]->formatName(); ?>

								<?php if (! ($this->_foreach['foo']['iteration'] == $this->_foreach['foo']['total'])): ?>, <?php endif; ?>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					<?php else: ?><?php echo $this->_tpl_vars['formdata']['submit_type_name']; ?>
<?php endif; ?>
				<?php else: ?>
				<div id="sub_el_unknown"<?php if ($this->_tpl_vars['formdata']['type'] != 19): ?> style="display: none"<?php endif; ?>>
					Onbekend
					<input type="hidden" name="submitters" value="-1">
				</div>
								<div id="sub_el_party"<?php if ($this->_tpl_vars['formdata']['type'] != 1): ?> style="display: none"<?php endif; ?>>
					<?php echo smarty_function_html_options(array('id' => 'submitters','name' => 'submitters','class' => 'vld_required_select idErrorHandler','size' => '16','options' => $this->_tpl_vars['all_parties'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['formdata']['submitters'])) ? $this->_run_mod_handler('default', true, $_tmp, '%') : smarty_modifier_default($_tmp, '%')),'onclick' => "revalidate(this.form)"), $this);?>

				</div>

				<div id="sub_el_members"<?php if ($this->_tpl_vars['formdata']['type'] != 2 && $this->_tpl_vars['formdata']['type'] != 3 && $this->_tpl_vars['formdata']['type'] != 4): ?> style="display: none"<?php endif; ?>>
					<?php echo smarty_function_html_options(array('id' => 'submitters','name' => "submitters[]",'class' => 'vld_required_select idErrorHandler','multiple' => 'multiple','size' => '16','options' => $this->_tpl_vars['councilView'],'selected' => $this->_tpl_vars['formdata']['submitters'],'onclick' => "revalidate(this.form)"), $this);?>

				</div>
				<div id="sub_el_citizen"<?php if ($this->_tpl_vars['formdata']['type'] != 5): ?> style="display: none"<?php endif; ?>>Burger</div>
				<span class="error" id="_err_submitters_required" style="<?php if (! $this->_tpl_vars['formerrors']['submitters_required']): ?>display:none<?php endif; ?>">Dit veld is verplicht</span>
				<?php endif; ?></td>
		</tr>
		<tr>
			<th/>
			<td>
				<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['form']['submitText']; ?>
"/>
				<?php if (strlen ( $this->_tpl_vars['form']['extraButton'] )): ?><input type="submit" name="submit_vote" value="<?php echo $this->_tpl_vars['form']['extraButton']; ?>
"/><?php endif; ?>
			</td>
		</tr>
	</table>
</form>