<?php /* Smarty version 2.6.18, created on 2009-03-11 15:25:07
         compiled from /var/www/projects/politix/modules/user/pages/login/php/../content//passwordPageBase.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/modules/user/pages/login/php/../content//passwordPageBase.html', 5, false),)), $this); ?>
  
<a name="PasswordCreate"></a>
<form action="" name="PasswordCreate" method="post" onsubmit="return formSubmit(this)" enctype="multipart/form-data">
	<strong class="label">E-mailadres:</strong>
	<input class="field text" type="text" name="username" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['formdata']['username'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
" id="username" onkeyup="revalidate(this.form)" maxlength="40" />
	<span class="error" id="_err_username_0" style="<?php if (! $this->_tpl_vars['formerrors']['username_0']): ?>display:none<?php endif; ?>">Onbekende gebruikersnaam</span>
	<br/><br class="clear" />

	<input class="field button" type="submit" value="Wachtwoord aanvragen" /> 
</form>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
	updateVisibility(document.forms['PasswordCreate'])
//--><!]]>
</script>