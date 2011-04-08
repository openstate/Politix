<?php /* Smarty version 2.6.18, created on 2008-12-16 13:31:31
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/content/votePage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/var/www/projects/politix/pages/admin/raadsstukken/content/votePage.html', 5, false),)), $this); ?>




<h2>Resultaten stemming over '<?php echo $this->_tpl_vars['raadsstuk']->title; ?>
' op <?php echo ((is_array($_tmp=$this->_tpl_vars['raadsstuk']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%e %B %Y') : smarty_modifier_date_format($_tmp, '%e %B %Y')); ?>
</h2>
<form action="" method="post">
<table id="council">
	<tr>
		<td><span><?php echo $this->_tpl_vars['region']->level_name; ?>
 <?php echo $this->_tpl_vars['region']->name; ?>
</span></td><td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."options.html", 'smarty_include_vars' => array('prefix' => 'council','class' => 'raad','set' => $this->_tpl_vars['council']['vote'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
	<?php $_from = $this->_tpl_vars['council']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['partyName'] => $this->_tpl_vars['party']):
?>
	<?php ob_start(); ?>party[<?php echo $this->_tpl_vars['party']['id']; ?>
]<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('pname', ob_get_contents());ob_end_clean(); ?>
	<tr>
		<td style="text-indent: 20px;"><span class="party-name"><?php echo $this->_tpl_vars['partyName']; ?>
</span></td><td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."options.html", 'smarty_include_vars' => array('prefix' => $this->_tpl_vars['pname'],'class' => 'party','set' => $this->_tpl_vars['party']['vote'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
	<?php $_from = $this->_tpl_vars['party']['politicians']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['politicianId'] => $this->_tpl_vars['politician']):
?>
	<?php ob_start(); ?>politician[<?php echo $this->_tpl_vars['politicianId']; ?>
]<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('poname', ob_get_contents());ob_end_clean(); ?>
	<tr>
		<td style="text-indent: 40px"><span><?php echo $this->_tpl_vars['politician']['name']; ?>
</span></td><td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."options.html", 'smarty_include_vars' => array('prefix' => $this->_tpl_vars['poname'],'class' => ($this->_tpl_vars['pname'])." politician",'set' => $this->_tpl_vars['politician']['vote']->vote)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>
	<tr>
		<td class="space"><span id="resultCaption">Resultaat:</span></td>
		<td class="space">
			<input type="hidden" id="result" name="result" value="<?php echo $this->_tpl_vars['raadsstuk']->result; ?>
"/>
			<div class="result-item notVoted">
				<div style="float: right">&raquo;</div><span class="vote-text">Niet gestemd</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="space">&nbsp;</td><td class="space"><input type="submit" name="submit" value="Versturen"/><input type="submit" name="submit_edit" value="Versturen en naar voorstel"/></td>
	</tr>
</table>
<div id="vote-box" style="display: none">
	<div class="vote-box-item voor border" id="box-voor"><input type="radio" name="vote" value="0"/><span class="vote-text">Voor</span></div>
	<div class="vote-box-item tegen border" id="box-tegen"><input type="radio" name="vote" value="1"/><span class="vote-text">Tegen</span></div>
	<div class="vote-box-item onthouden border" id="box-onthouden"><input type="radio" name="vote" value="2"/><span class="vote-text">Onthouden</span></div>
	<div class="vote-box-item afwezig" id="box-afwezig"><input type="radio" name="vote" value="3"/><span class="vote-text">Afwezig</span></div>
</div>
<div id="result-box" style="display: none">
	<div class="result-box-item voor border" id="box-accept"><input type="radio" name="result-radio" id="result-box-item-1" value="1"/><span class="vote-text">Aangenomen</span></div>
	<div class="result-box-item tegen border" id="box-reject"><input type="radio" name="result-radio" id="result-box-item-2" value="2"/><span class="vote-text">Afgewezen</span></div>
	<div class="result-box-item notVoted" id="box-notVoted"><input type="radio" name="result-radio" id="result-box-item-0" value="0"/><span class="vote-text">Niet gestemd</span></div>
</div>
<div id="spacer" style="height: 6em"/>
</form>
