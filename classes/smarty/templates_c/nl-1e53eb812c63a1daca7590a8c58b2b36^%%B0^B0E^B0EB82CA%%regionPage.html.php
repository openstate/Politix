<?php /* Smarty version 2.6.18, created on 2009-06-09 11:40:29
         compiled from /var/www/projects/politix/pages/admin/appointments/content/regionPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/appointments/content/regionPage.html', 12, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/appointments/content/regionPage.html', 12, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/admin/appointments/content/regionPage.html', 12, false),)), $this); ?>
<form action="" name="PartyList">
<h2>Aanstellingen <?php echo $this->_tpl_vars['region']->formatName(); ?>
</h2>
<p>
<?php if ($this->_tpl_vars['includeExpired']): ?><a href="/appointments/region/<?php echo $this->_tpl_vars['region']->id; ?>
?curr">Verberg be&euml;indigde partijen</a>
<?php else: ?><a href="/appointments/region/<?php echo $this->_tpl_vars['region']->id; ?>
?all">Toon be&euml;indigde partijen</a><?php endif; ?>
</p>
	<table class="list">
		<tr>
			<th><a href="?sortcol=name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'party_name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'party_name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a></th>
		</tr>
		<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
		<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
"><td><a href="../party/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']['party_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a></td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
</form>