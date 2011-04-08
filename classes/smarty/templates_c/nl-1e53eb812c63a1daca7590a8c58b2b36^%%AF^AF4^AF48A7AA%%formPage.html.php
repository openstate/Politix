<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:28
         compiled from /var/www/projects/politix/pages/admin/style/content/formPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/style/content/formPage.html', 9, false),)), $this); ?>



<form action="" name="<?php echo $this->_tpl_vars['form']['name']; ?>
" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
	<h2>Opmaak wijzigen</h2>
	<table class="form">
		<tr>
			<th>Kleur 1</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color1'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color1" value="<?php echo $this->_tpl_vars['formdata']['color1']; ?>
" id="color1" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color1_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color1_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 2</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color2'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color2" value="<?php echo $this->_tpl_vars['formdata']['color2']; ?>
" id="color2" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color2_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color2_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 3</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color3'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color3" value="<?php echo $this->_tpl_vars['formdata']['color3']; ?>
" id="color3" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color3_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color3_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 4</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color4'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color4" value="<?php echo $this->_tpl_vars['formdata']['color4']; ?>
" id="color4" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color4_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color4_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 5</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color5'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color5" value="<?php echo $this->_tpl_vars['formdata']['color5']; ?>
" id="color5" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color5_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color5_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 6</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color6'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color6" value="<?php echo $this->_tpl_vars['formdata']['color6']; ?>
" id="color6" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color6_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color6_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 7</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color7'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color7" value="<?php echo $this->_tpl_vars['formdata']['color7']; ?>
" id="color7" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color7_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color7_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Kleur 8</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['color8'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="color8" value="<?php echo $this->_tpl_vars['formdata']['color8']; ?>
" id="color8" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_color8_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['color8_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Slogan</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['slogan'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="slogan" value="<?php echo $this->_tpl_vars['formdata']['slogan']; ?>
" id="slogan"/><?php endif; ?></td>
		</tr>
		<tr>
			<th>Fontnaam</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['font_family'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="font_family" value="<?php echo $this->_tpl_vars['formdata']['font_family']; ?>
" id="font_family"/><?php endif; ?></td>
		</tr>
		<tr>
			<th>Fontkleur</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['font_color'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="font_color" value="<?php echo $this->_tpl_vars['formdata']['font_color']; ?>
" id="font_color" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_font_color_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['font_color_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Fontgrootte</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['font_size'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="font_size" value="<?php echo $this->_tpl_vars['formdata']['font_size']; ?>
" id="font_size"/><?php endif; ?></td>
		</tr>
		<tr>
			<th>Achtergrondkleur</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['bg_color'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="bg_color" value="<?php echo $this->_tpl_vars['formdata']['bg_color']; ?>
" id="bg_color" class="vld_required defErrorHandler" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_bg_color_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['bg_color_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<tr>
			<th>Zoekvelden</th>
			<td><?php if ($this->_tpl_vars['form']['freeze']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['fields'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php else: ?><input type="text" name="fields" value="<?php echo $this->_tpl_vars['formdata']['fields']; ?>
" id="fields" onkeyup="revalidate(this.form)" /> <span class="error" id="_err_fields_invalid" style="<?php if (! $this->_tpl_vars['formerrors']['fields_invalid']): ?>display:none<?php endif; ?>">Ongeldige waarde</span><?php endif; ?></td>
		</tr>
		<?php if (! $this->_tpl_vars['form']['freeze']): ?>
		<tr>
			<th>Logo</th>
			<td><?php if ($this->_tpl_vars['formdata']['logo']): ?><img style="border: 1px solid black; margin-bottom: 5px" src="/files/<?php echo $this->_tpl_vars['formdata']['logo']; ?>
"/><br/><?php endif; ?><input type="file" name="logo" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['logo'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
" id="logo" /><br/><?php if (isset ( $this->_tpl_vars['formdata']['logo'] ) && $this->_tpl_vars['formdata']['logo'] != 'wsmr.gif'): ?><input type="checkbox" name="removeLogo">Logo verwijderen</input><?php endif; ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th/>
			<td><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['form']['submitText']; ?>
"/></td>
		</tr>
	</table>
</form>