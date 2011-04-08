<?php /* Smarty version 2.6.18, created on 2009-03-11 15:25:07
         compiled from /var/www/projects/politix/modules/user/pages/login/content/passwordPage.html */ ?>

<h2>Wachtwoord aanvragen</h2>
<div class="block" id="loginForm">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."/passwordPageBase.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['noLoginGiven']): ?><span class="error">U moet een gebruikersnaam of emailadres opgeven.</span><?php endif; ?>
</div>