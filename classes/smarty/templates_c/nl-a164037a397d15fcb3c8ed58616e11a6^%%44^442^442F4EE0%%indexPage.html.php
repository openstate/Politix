<?php /* Smarty version 2.6.18, created on 2008-12-16 00:05:13
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/indexPage.html', 13, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/indexPage.html', 14, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/indexPage.html', 14, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/indexPage.html', 15, false),)), $this); ?>


<table class="list">
	<tr>
		<th><a href="?sortcol=title&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'title' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'title'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Titel</a></th>
		<th><a href="?sortcol=vote_date&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_date' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_date'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Stemdatum</a></th>
		<th><a href="?sortcol=vote_0&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_0' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_0'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">V</a></th>
		<th><a href="?sortcol=vote_1&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_1' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_1'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">T</a></th>
		<th><a href="?sortcol=vote_2&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_2' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_2'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">O</a></th>
		<th><a href="?sortcol=vote_3&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_3' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'vote_3'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">A</a></th>
	</tr>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['datarow']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td width="50%"><a href="raadsstuk/<?php echo $this->_tpl_vars['datarow']->id; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a></td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
</td>
		<td><?php echo $this->_tpl_vars['datarow']->vote_0; ?>
</td>
		<td><?php echo $this->_tpl_vars['datarow']->vote_1; ?>
</td>
		<td><?php echo $this->_tpl_vars['datarow']->vote_2; ?>
</td>
		<td><?php echo $this->_tpl_vars['datarow']->vote_3; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>