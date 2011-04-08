<?php /* Smarty version 2.6.18, created on 2008-12-16 13:25:41
         compiled from /var/www/projects/politix/pages/admin/user/content/indexPage.html */ ?>
<h2>Gebruikers</h2>

<form method="get" action="/user/">
<label for="query">Zoek op naam:</label>
<input type="text" name="q" id="query" value="<?php echo $this->_tpl_vars['query']; ?>
" />
<input type="submit" value="Zoeken" />
</form>

<?php if ($this->_tpl_vars['pager']): ?><p class="pager"><?php echo $this->_tpl_vars['pager']; ?>
</p><?php endif; ?>
<p><a href="/user/create/"><img src="/images/add.png" border="0" alt="Toevoegen" title="Toevoegen" /></a> <a href="/user/create/">Toevoegen</a></p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."/indexPageBase.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>