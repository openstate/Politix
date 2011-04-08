<?php /* Smarty version 2.6.18, created on 2008-12-16 13:26:02
         compiled from /var/www/projects/politix/pages/admin/user/content/rolePage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', '/var/www/projects/politix/pages/admin/user/content/rolePage.html', 5, false),)), $this); ?>
<h2>Rollen voor <?php echo $this->_tpl_vars['user']->username; ?>
</h2>
<p><a href="/user/"><img src="/images/arrow_turn_up.png" alt="Terug" border="0" /></a> <a href="/user/">Terug</a></p>
<form method="post" action="">
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
" />
<?php echo smarty_function_html_checkboxes(array('options' => $this->_tpl_vars['roles'],'name' => 'roles','selected' => $this->_tpl_vars['selectedRoles'],'labels' => true), $this);?>
<br /><br />
<input type="submit" name="submit" value="Verstuur" />
</form>