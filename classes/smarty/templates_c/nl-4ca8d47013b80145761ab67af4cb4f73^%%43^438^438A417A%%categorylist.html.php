<?php /* Smarty version 2.6.18, created on 2009-04-08 09:52:54
         compiled from /var/www/projects/politix/pages/admin/appointments/content/categorylist.html */ ?>

<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categoryloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categoryloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category']):
        $this->_foreach['categoryloop']['iteration']++;
?>
<option label="<?php echo $this->_tpl_vars['category']->name; ?>
" value="<?php echo $this->_tpl_vars['category']->id; ?>
"><?php echo $this->_tpl_vars['category']->name; ?>
</option>
<?php endforeach; else: ?>
<option label="" value="0">Geen</option>
<?php endif; unset($_from); ?>