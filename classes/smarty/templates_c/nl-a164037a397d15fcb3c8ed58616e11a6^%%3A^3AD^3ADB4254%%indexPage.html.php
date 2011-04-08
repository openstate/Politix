<?php /* Smarty version 2.6.18, created on 2008-12-02 09:39:51
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 9, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 20, false),array('modifier', 'truncate', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 24, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 24, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 24, false),array('modifier', 'strip_tags', '/var/www/projects/politix/pages/watstemtmijnraad/home/content/indexPage.html', 27, false),)), $this); ?>

<div class="contentSection">
	<div class="titleBlock"></div><h2>Snel zoeken</h2>
	<form action="/search" method="post">
	<p><label for="q">Vul uw zoekterm in: </label> <input type="text" name="q" id="q" value="" class="search" size="30" maxlength="2048"/> <input type="submit" value="Zoeken" class="submitButton"/></p>
	</form>
</div>
<div class="contentSection">
	<div class="titleBlock"></div><h2>Laatste <?php echo count($this->_tpl_vars['recent']); ?>
 voorstellen</h2>
	<?php $_from = $this->_tpl_vars['recent']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['result_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['result_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['r']):
        $this->_foreach['result_loop']['iteration']++;
?>
	<div class="contentBlock result<?php if (($this->_foreach['result_loop']['iteration'] == $this->_foreach['result_loop']['total'])): ?> last<?php endif; ?>">
		<div class="link">
			<a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['r']->id; ?>
">&gt;</a>
		</div>
		<div class="stats">
			<div class="leftStats"><span class="green"><strong>Voor</strong></span><br/><?php echo $this->_tpl_vars['r']->vote_0; ?>
</div>
			<div class="rightStats"><span class="red"><strong>Tegen</strong></span><br/><?php echo $this->_tpl_vars['r']->vote_1; ?>
</div>
			<span class="result r<?php echo $this->_tpl_vars['r']->result; ?>
"><?php echo $this->_tpl_vars['r']->getResultTitle(); ?>
</span>
		</div>
		<div class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['r']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
<br/>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['r']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m") : smarty_modifier_date_format($_tmp, "%m")); ?>
<br/>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['r']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%y") : smarty_modifier_date_format($_tmp, "%y")); ?>
</div>
		<div class="title">
			<span class="regio"><?php echo $this->_tpl_vars['r']->region_name; ?>
</span>: <a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['r']->id; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['r']->title)) ? $this->_run_mod_handler('truncate', true, $_tmp, 37, '...', 1) : smarty_modifier_truncate($_tmp, 37, '...', 1)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a>
		</div>
		<div class="summary">
			<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['r']->summary)) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 110, '...', 1) : smarty_modifier_truncate($_tmp, 110, '...', 1)); ?>

			<a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['r']->id; ?>
">lees verder &raquo;</a>
		</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
<div class="titleBlock"></div><h2><?php echo ((is_array($_tmp=$this->_tpl_vars['page']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</h2>
<div class="contentBlock">
	<?php echo $this->_tpl_vars['page']->content; ?>

</div>