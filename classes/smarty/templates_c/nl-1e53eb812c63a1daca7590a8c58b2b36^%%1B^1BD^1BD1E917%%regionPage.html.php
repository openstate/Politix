<?php /* Smarty version 2.6.18, created on 2008-12-16 13:26:44
         compiled from /var/www/projects/politix/pages/admin/user/content/regionPage.html */ ?>
<h2>Regio's voor <?php echo $this->_tpl_vars['user']->username; ?>
</h2>
<p><a href="/user/"><img src="/images/arrow_turn_up.png" alt="Terug" border="0" /></a> <a href="/user/">Terug</a></p>
<form method="post" action="">
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
" />
<div id="tree">
<?php $this->assign('currentKey', '0'); ?>
<?php $_from = $this->_tpl_vars['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
<?php if ($this->_tpl_vars['region']['level'] == ( $this->_tpl_vars['currentKey'] + 1 )): ?>
	<ul id="region_<?php echo $this->_tpl_vars['region']['parent']; ?>
" class="child"><?php ob_start(); ?> <?php $this->_smarty_vars['capture']['closing'] = ob_get_contents(); ob_end_clean(); ?>
<?php elseif ($this->_tpl_vars['region']['level'] == ( $this->_tpl_vars['currentKey'] - 1 )): ?>	
	</li></ul></li>
<?php else: ?>
	<?php echo $this->_smarty_vars['capture']['closing']; ?>
		
<?php endif; ?>
<li class="child"><img src="/images/collapse.gif" border="0" id="label_<?php echo $this->_tpl_vars['region']['id']; ?>
" class="toggler" alt=""/><label><input type="checkbox" name="regions[]" value="<?php echo $this->_tpl_vars['region']['id']; ?>
" <?php if (isset ( $this->_tpl_vars['selectedRegions'][$this->_tpl_vars['region']['id']] )): ?>checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['region']['name']; ?>
</label>
<?php ob_start(); ?></li><?php $this->_smarty_vars['capture']['closing'] = ob_get_contents(); ob_end_clean(); ?>
<?php $this->assign('currentKey', ($this->_tpl_vars['region']['level'])); ?>
<?php endforeach; endif; unset($_from); ?>
<?php unset($this->_sections['finishing']);
$this->_sections['finishing']['name'] = 'finishing';
$this->_sections['finishing']['loop'] = is_array($_loop=$this->_tpl_vars['currentKey']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['finishing']['start'] = (int)0;
$this->_sections['finishing']['max'] = (int)$this->_tpl_vars['currentKey'];
$this->_sections['finishing']['show'] = true;
if ($this->_sections['finishing']['max'] < 0)
    $this->_sections['finishing']['max'] = $this->_sections['finishing']['loop'];
$this->_sections['finishing']['step'] = 1;
if ($this->_sections['finishing']['start'] < 0)
    $this->_sections['finishing']['start'] = max($this->_sections['finishing']['step'] > 0 ? 0 : -1, $this->_sections['finishing']['loop'] + $this->_sections['finishing']['start']);
else
    $this->_sections['finishing']['start'] = min($this->_sections['finishing']['start'], $this->_sections['finishing']['step'] > 0 ? $this->_sections['finishing']['loop'] : $this->_sections['finishing']['loop']-1);
if ($this->_sections['finishing']['show']) {
    $this->_sections['finishing']['total'] = min(ceil(($this->_sections['finishing']['step'] > 0 ? $this->_sections['finishing']['loop'] - $this->_sections['finishing']['start'] : $this->_sections['finishing']['start']+1)/abs($this->_sections['finishing']['step'])), $this->_sections['finishing']['max']);
    if ($this->_sections['finishing']['total'] == 0)
        $this->_sections['finishing']['show'] = false;
} else
    $this->_sections['finishing']['total'] = 0;
if ($this->_sections['finishing']['show']):

            for ($this->_sections['finishing']['index'] = $this->_sections['finishing']['start'], $this->_sections['finishing']['iteration'] = 1;
                 $this->_sections['finishing']['iteration'] <= $this->_sections['finishing']['total'];
                 $this->_sections['finishing']['index'] += $this->_sections['finishing']['step'], $this->_sections['finishing']['iteration']++):
$this->_sections['finishing']['rownum'] = $this->_sections['finishing']['iteration'];
$this->_sections['finishing']['index_prev'] = $this->_sections['finishing']['index'] - $this->_sections['finishing']['step'];
$this->_sections['finishing']['index_next'] = $this->_sections['finishing']['index'] + $this->_sections['finishing']['step'];
$this->_sections['finishing']['first']      = ($this->_sections['finishing']['iteration'] == 1);
$this->_sections['finishing']['last']       = ($this->_sections['finishing']['iteration'] == $this->_sections['finishing']['total']);
?>
</li></ul>
<?php endfor; endif; ?>
</div>
<input type="submit" name="submit" value="Verstuur" />
</form>