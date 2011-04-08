<?php /* Smarty version 2.6.18, created on 2008-12-02 16:17:59
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'array_slice', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 22, false),array('modifier', 'implode', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 23, false),array('modifier', 'htmlspecialchars', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 23, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 23, false),array('modifier', 'reset', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 31, false),array('modifier', 'count', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 37, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 75, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 79, false),array('modifier', 'replace', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 79, false),array('modifier', 'truncate', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 79, false),array('modifier', 'strip_tags', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 82, false),array('modifier', 'html_entity_decode', '/var/www/projects/politix/pages/watstemtmijnraad/search/content/indexPage.html', 82, false),)), $this); ?>


<div class="titleBlock"></div><h2 id="search_toggle" class="nomargin-bottom"><span id="search_span">Wijzig zoekopdracht</span> <img id="searchImage" src="" alt=""/></h2>
<p></p>
<?php if ($this->_tpl_vars['fts']): ?>
<div id="searchBlock" class="contentBlock">
	<form action="/search" method="post">
		<p><label for="q">Vul uw zoekterm in: </label> <input type="text" name="q" id="q" value="" class="search" size="30" maxlength="2048"/> <input type="submit" value="zoeken" class="submitButton"/></p>
	</form>
</div>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['smartyData']['contentDir'])."/../../advsearch/content/search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['stats']['count']): ?>
<div class="contentSection">
	<div class="titleBlock"></div><h2>Zoekresultaten <?php echo $this->_tpl_vars['stats']['start']+1; ?>
-<?php echo $this->_tpl_vars['stats']['end']; ?>
 van <?php echo $this->_tpl_vars['stats']['count']; ?>
</h2>
	<?php if ($this->_tpl_vars['warning']): ?><div class="warning"><p>Uw zoekopdracht heeft het maximale aantal resultaten opgeleverd. U kunt uw zoekopdracht beperken door het toevoegen van meer zoektermen.</p></div><?php endif; ?>
	<?php if ($this->_tpl_vars['header']): ?>
	<div class="contentBlock result">
		<p><?php echo $this->_tpl_vars['header']['0']; ?>
</p>
		<div class="title"><?php echo $this->_tpl_vars['header']['1']; ?>
</div>
		<?php $this->assign('header', array_slice($this->_tpl_vars['header'], 2)); ?>
		<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="\n")) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['header']) : implode($_tmp, $this->_tpl_vars['header'])))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

	</div>
	<hr class="filter"/>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['filter']): ?>
	<div class="contentBlock result">
		<table class="filter">
			<tr><td rowspan="2" class="filterDetails">
				<div class="title"><?php echo reset($this->_tpl_vars['filter']); ?>
</div>
				<?php $this->assign('filter', array_slice($this->_tpl_vars['filter'], 1)); ?>
				<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="\n")) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['filter']) : implode($_tmp, $this->_tpl_vars['filter'])))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

			</td>
			<th scope="col" class="filterHeader vote r0 first">Voor</th>
			<th scope="col" class="filterHeader vote r1">Tegen</th>
			<?php if (count($this->_tpl_vars['totals']) == 3): ?>
			<th scope="col" class="filterHeader vote r-1 last">Verdeeld</th>
			<?php else: ?>
			<th scope="col" class="filterHeader vote r2">Onthouden</th>
			<th scope="col" class="filterHeader vote r3 last">Afwezig</th>
			<?php endif; ?>
			</tr><tr>
			<?php $_from = $this->_tpl_vars['totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['totalloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['totalloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['val']):
        $this->_foreach['totalloop']['iteration']++;
?>
			<td class="filterTotals<?php if (($this->_foreach['totalloop']['iteration'] <= 1)): ?> first<?php elseif (($this->_foreach['totalloop']['iteration'] == $this->_foreach['totalloop']['total'])): ?> last<?php endif; ?>"><?php echo $this->_tpl_vars['val']; ?>
</td>
			<?php endforeach; endif; unset($_from); ?>
			</tr>
		</table>
	</div>
	<hr class="filter"/>
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['result_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['result_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['datarow']):
        $this->_foreach['result_loop']['iteration']++;
?>
	<div class="contentBlock result<?php if (($this->_foreach['result_loop']['iteration'] == $this->_foreach['result_loop']['total'])): ?> last<?php endif; ?>">
		<div class="link">
			<a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['datarow']->id; ?>
">&gt;</a>
		</div>
		<div class="stats">
			<?php if ($this->_tpl_vars['datarow']->vote_0 + $this->_tpl_vars['datarow']->vote_1 + $this->_tpl_vars['datarow']->vote_2 + $this->_tpl_vars['datarow']->vote_3 == 1): ?>
			<?php if ($this->_tpl_vars['datarow']->vote_0): ?>
			<div><span class="vote r0"><strong>Voor</strong></span></div>
			<?php elseif ($this->_tpl_vars['datarow']->vote_1): ?>
			<div><span class="vote r1"><strong>Tegen</strong></span></div>
			<?php elseif ($this->_tpl_vars['datarow']->vote_2): ?>
			<div><span class="vote r2"><strong>Onthouden</strong></span></div>
			<?php elseif ($this->_tpl_vars['datarow']->vote_3): ?>
			<div><span class="vote r3"><strong>Afwezig</strong></span></div>
			<?php endif; ?>
			<br />
			<?php else: ?>
			<div class="leftStats"><span class="green"><strong>Voor</strong></span><br/><?php echo $this->_tpl_vars['datarow']->vote_0; ?>
</div>
			<div class="rightStats"><span class="red"><strong>Tegen</strong></span><br/><?php echo $this->_tpl_vars['datarow']->vote_1; ?>
</div>
			<?php endif; ?>
			<span class="result r<?php echo $this->_tpl_vars['datarow']->result; ?>
"><?php echo $this->_tpl_vars['datarow']->getResultTitle(); ?>
</span>
		</div>
		<div class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
<br/>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m") : smarty_modifier_date_format($_tmp, "%m")); ?>
<br/>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%y") : smarty_modifier_date_format($_tmp, "%y")); ?>
</div>
		<div class="title">
			<span class="regio"><?php echo $this->_tpl_vars['datarow']->region_name; ?>
</span>: <a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['datarow']->id; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
"><?php if ($this->_tpl_vars['fts']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title_hl)) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('replace', true, $_tmp, '[[', '<b>') : smarty_modifier_replace($_tmp, '[[', '<b>')))) ? $this->_run_mod_handler('replace', true, $_tmp, ']]', '</b>') : smarty_modifier_replace($_tmp, ']]', '</b>')); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->title)) ? $this->_run_mod_handler('truncate', true, $_tmp, 37, '...', 1) : smarty_modifier_truncate($_tmp, 37, '...', 1)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<?php endif; ?></a>
		</div>
		<div class="summary">
			<?php if ($this->_tpl_vars['fts']): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->summary_hl)) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('replace', true, $_tmp, '[[', '<b>') : smarty_modifier_replace($_tmp, '[[', '<b>')))) ? $this->_run_mod_handler('replace', true, $_tmp, ']]', '</b>') : smarty_modifier_replace($_tmp, ']]', '</b>')); ?>
<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->summary)) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('html_entity_decode', true, $_tmp) : html_entity_decode($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 110, '...', 1) : smarty_modifier_truncate($_tmp, 110, '...', 1)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp, 2, 'UTF-8') : htmlspecialchars($_tmp, 2, 'UTF-8')); ?>
<?php endif; ?>
			<a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['datarow']->id; ?>
">lees verder &raquo;</a>
		</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
<?php if ($this->_tpl_vars['pager']): ?><p><?php echo $this->_tpl_vars['pager']; ?>
</p><?php endif; ?>
<?php else: ?>
<div class="titleBlock"></div><h2>Uw zoekopdracht heeft geen resultaten opgeleverd.</h2>
<?php endif; ?>