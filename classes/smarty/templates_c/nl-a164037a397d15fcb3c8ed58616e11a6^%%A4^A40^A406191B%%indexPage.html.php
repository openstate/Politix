<?php /* Smarty version 2.6.18, created on 2008-12-02 09:40:06
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/advsearch/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/advsearch/content/indexPage.html', 6, false),)), $this); ?>

<?php if (! $this->_tpl_vars['extern']): ?>
<div class="titleBlock"></div><h2>Geavanceerd zoeken</h2>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."/search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="titleBlock"></div><h2><?php echo ((is_array($_tmp=$this->_tpl_vars['page']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</h2>
<div class="contentBlock">
	<?php echo $this->_tpl_vars['page']->content; ?>

</div>