<?php /* Smarty version 2.6.18, created on 2008-12-02 16:02:14
         compiled from /var/www/projects/politix/templates/exception.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/templates/exception.html', 8, false),array('modifier', 'default', '/var/www/projects/politix/templates/exception.html', 8, false),array('modifier', 'truncate', '/var/www/projects/politix/templates/exception.html', 28, false),array('modifier', 'print_r', '/var/www/projects/politix/templates/exception.html', 38, false),)), $this); ?>
<?php $this->assign('thcol', "#9999ee"); ?>
<?php $this->assign('tdcol', "#ddddff"); ?>
<div>
<?php if ($this->_tpl_vars['data']['developer']): ?>
	<br />
	<h2 class="header">Exception</h2>
	<p>An error occurred while processing a request (<?php echo $this->_tpl_vars['data']['exception']; ?>
).</p>
	<p><strong>Message:</strong><br /><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['message'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 'No message.') : smarty_modifier_default($_tmp, 'No message.')); ?>
</p>
	<?php if ($this->_tpl_vars['data']['data']): ?><p><strong>Extra data:</strong><br /><pre><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['data'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</pre></p><?php endif; ?>
	<?php if ($this->_tpl_vars['data']['sql']): ?>
	<p><strong>Query:</strong><br /><pre style="overflow:scroll"><?php echo $this->_tpl_vars['data']['sql']; ?>
</pre></p>
	<p><strong>Error:</strong><br /><?php echo $this->_tpl_vars['data']['error']; ?>
</p>
	<?php endif; ?>
	<p>The error occurred in <strong><?php echo $this->_tpl_vars['data']['file']; ?>
</strong> at line <strong><?php echo $this->_tpl_vars['data']['line']; ?>
</strong>.</p>
	<p>Trace:</p>
	<div style="overflow:scroll">
	<table>
		<tr>
			<th bgcolor="<?php echo $this->_tpl_vars['thcol']; ?>
">#</th><th bgcolor="<?php echo $this->_tpl_vars['thcol']; ?>
">Function</th><th bgcolor="<?php echo $this->_tpl_vars['thcol']; ?>
">Called from</th>
		</tr>
		<?php $_from = $this->_tpl_vars['data']['trace']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['trace']):
?>
		<tr>
			<td bgcolor="<?php echo $this->_tpl_vars['tdcol']; ?>
"><?php echo $this->_tpl_vars['idx']+1; ?>
</td><td bgcolor="<?php echo $this->_tpl_vars['tdcol']; ?>
">
				<?php if (isset ( $this->_tpl_vars['trace']['type'] )): ?><?php echo $this->_tpl_vars['trace']['class']; ?>
<?php echo $this->_tpl_vars['trace']['type']; ?>
<?php endif; ?><?php echo $this->_tpl_vars['trace']['function']; ?>
(
					<?php if (isset ( $this->_tpl_vars['trace']['args'] )): ?>
						<?php $_from = $this->_tpl_vars['trace']['args']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['argidx'] => $this->_tpl_vars['arg']):
?>
							<?php if (is_string ( $this->_tpl_vars['arg'] )): ?>
								<span style="color:red">'<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arg'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80) : smarty_modifier_truncate($_tmp, 80)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
'</span>
							<?php elseif (is_integer ( $this->_tpl_vars['arg'] )): ?>
								<span style="color:green"><?php echo $this->_tpl_vars['arg']; ?>
</span>
							<?php elseif (is_float ( $this->_tpl_vars['arg'] )): ?>
								<span style="color:blue"><?php echo $this->_tpl_vars['arg']; ?>
</span>
							<?php elseif (is_bool ( $this->_tpl_vars['arg'] )): ?>
								<span style="color:#75507b"><?php if ($this->_tpl_vars['arg']): ?>true<?php else: ?>false<?php endif; ?></span>
							<?php elseif (is_null ( $this->_tpl_vars['arg'] )): ?>
								<span style="color:#3465a4">null</span>
							<?php else: ?>
								<?php $this->assign('argdata', print_r($this->_tpl_vars['arg'], true)); ?>
								<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['argdata'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80) : smarty_modifier_truncate($_tmp, 80)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>

								<?php $this->assign('argdata', ''); ?> 							<?php endif; ?>
							<?php if ($this->_tpl_vars['argidx'] < count ( $this->_tpl_vars['trace']['args'] ) - 1): ?>,<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
				)</td><td bgcolor="<?php echo $this->_tpl_vars['tdcol']; ?>
"><?php echo $this->_tpl_vars['trace']['file']; ?>
:<?php echo $this->_tpl_vars['trace']['line']; ?>
</td></tr>
		<?php endforeach; endif; unset($_from); ?>
		</tr>
	</table>
	</div>
<?php else: ?>
	<h2>Fout</h2>
	<p>Er is een fout opgetreden in het systeem. De beheerder van de website is hiervan op de hoogte gesteld.</p>
<?php endif; ?>
</div>