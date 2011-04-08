<?php /* Smarty version 2.6.18, created on 2009-04-08 09:52:54
         compiled from /var/www/projects/politix/pages/admin/appointments/content/partylist.html */ ?>

<?php $_from = $this->_tpl_vars['parties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['partyloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['partyloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['party']):
        $this->_foreach['partyloop']['iteration']++;
?>
<option label="<?php echo $this->_tpl_vars['party']->name; ?>
" value="<?php echo $this->_tpl_vars['party']->id; ?>
"><?php echo $this->_tpl_vars['party']->name; ?>
</option>
<?php endforeach; else: ?>
<option label="" value="0">Geen</option>
<?php endif; unset($_from); ?>