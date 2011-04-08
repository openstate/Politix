<?php /* Smarty version 2.6.18, created on 2008-12-02 19:02:06
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/partyPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/partyPage.html', 4, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/partyPage.html', 4, false),array('function', 'cycle', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/partyPage.html', 12, false),)), $this); ?>

<div style="padding-left: 77px;">

<h2><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['raadsstuk']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</h2>
<h3><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['party']->name)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</h3>
<table class="list">
	<tr>
		<th><a href="?raadsstuk=<?php echo $this->_tpl_vars['raadsstuk']->id; ?>
&amp;sortcol=name_sortkey&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'name_sortkey' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'name_sortkey'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Naam</a></th>
		<th>Stem</th>
	</tr>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['datarow']):
?>
	<tr class="<?php echo smarty_function_cycle(array('values' => ',alt'), $this);?>
">
		<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->formatName())) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
		<td class="vote r<?php echo $this->_tpl_vars['datarow']->vote; ?>
"><?php echo $this->_tpl_vars['datarow']->getVoteTitle(); ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>

</div>