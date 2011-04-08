<?php /* Smarty version 2.6.18, created on 2008-12-16 13:23:48
         compiled from /var/www/projects/politix/pages/admin/selection/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/selection/content/indexPage.html', 17, false),)), $this); ?>
   

<h2>Selectie</h2>

<?php if ($this->_tpl_vars['count'] == 0): ?>
<p>U heeft nog geen rollen toegekend gekregen. Een administrator kan dit voor u doen.</p>
<a href="/logout">Log uit</a>
<?php endif; ?>

<?php if (count ( $this->_tpl_vars['politicians'] ) > 0): ?>
<table class="list">
	<caption>Politici</caption>
	<tr>
		<th>Naam</th>
	</tr>
	<?php $_from = $this->_tpl_vars['politicians']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['politician']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><a href="/selection/politician/<?php echo $this->_tpl_vars['politician']->id; ?>
"><?php echo $this->_tpl_vars['politician']->first_name; ?>
 <?php echo $this->_tpl_vars['politician']->last_name; ?>
</a></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>
<br />
<?php if (count ( $this->_tpl_vars['localparties'] ) > 0): ?>
<table class="list">
	<caption>Secretariaten</caption>
	<tr>
		<th>Naam</th>
		<th>Gebied</th>
	</tr>
	<?php $_from = $this->_tpl_vars['localparties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['localparty']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><a href="/selection/localparty/<?php echo $this->_tpl_vars['localparty']->id; ?>
"><?php echo $this->_tpl_vars['localparty']->party_name; ?>
</a></td>
		<td><?php echo $this->_tpl_vars['localparty']->formatRegionName(); ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>
<br />
<?php if (count ( $this->_tpl_vars['regions'] ) > 0): ?>
<table class="list">
	<caption>Griffies</caption>
	<tr>
		<th>Naam</th>
	</tr>
	<?php $_from = $this->_tpl_vars['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
	<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
		<td><a href="/selection/region/<?php echo $this->_tpl_vars['region']->id; ?>
"><?php echo $this->_tpl_vars['region']->formatName(); ?>
</a></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>