<?php /* Smarty version 2.6.18, created on 2008-12-02 17:31:53
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html', 5, false),array('modifier', 'nl2br', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html', 5, false),array('modifier', 'urlencode', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html', 16, false),array('modifier', 'date_format', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html', 24, false),array('function', 'cycle', '/var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/content/raadsstukPage.html', 133, false),)), $this); ?>



<div class="raadsstuk">
	<div class="titleBlock"></div><h2><span class="title"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['raadsstuk']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</span> - <span class="result r<?php echo $this->_tpl_vars['raadsstuk']->result; ?>
"><?php echo $this->_tpl_vars['raadsstuk']->getResultTitle(); ?>
</span></h2>
	<div class="contentBlock"><?php echo $this->_tpl_vars['raadsstuk']->summary; ?>
</div>
</div>
<div class="contentBlock extramargin">
	<table class="raadsstuk">
		<tr>
			<th scope="row">Gemeente:</th>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['raadsstuk']->region_name)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</td>
		</tr>
		<tr>
			<th scope="row">Onderwerp(en):</th>
			<td><span class="category"><?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['category_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['category_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['category']):
        $this->_foreach['category_loop']['iteration']++;
?><a href="/search/category/<?php echo ((is_array($_tmp=$this->_tpl_vars['k'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/submit/1"><?php echo $this->_tpl_vars['category']; ?>
</a><?php if (! ($this->_foreach['category_loop']['iteration'] == $this->_foreach['category_loop']['total'])): ?>, <?php endif; ?><?php endforeach; else: ?>Geen<?php endif; unset($_from); ?></span></td>
		</tr>
		<tr>
			<th scope="row">Code:</th>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['raadsstuk']->code)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</td>
		</tr>
		<tr>
			<th scope="row">Stemdatum:</th>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['raadsstuk']->vote_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
</td>
		</tr>
		<tr>
			<th scope="row">Soort:</th>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['raadsstuk']->type_name)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</td>
		</tr>
		<?php if (count ( $this->_tpl_vars['submitters'] )): ?>
		<tr>
			<th scope="row">Ingediend door:</th>
			<td>
				<?php $_from = $this->_tpl_vars['submitters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['party_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['party_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['p']):
        $this->_foreach['party_loop']['iteration']++;
?>
				<div>
					<span class="sub_party"><?php echo $this->_tpl_vars['name']; ?>
</span>
					<img src="/styles/open" alt="open"/>
					<span class="submitter">
						<?php $_from = $this->_tpl_vars['p']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['submitter_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['submitter_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['submitter']):
        $this->_foreach['submitter_loop']['iteration']++;
?>
						<a href="/search/submitter_id/<?php echo ((is_array($_tmp=$this->_tpl_vars['k'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/submit/1" title="Toon alle moties en amendementen van <?php echo $this->_tpl_vars['submitter']; ?>
"><?php echo $this->_tpl_vars['submitter']; ?>
</a><?php if (! ($this->_foreach['submitter_loop']['iteration'] == $this->_foreach['submitter_loop']['total'])): ?>, <?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</span>
					<?php if (! ($this->_foreach['party_loop']['iteration'] == $this->_foreach['party_loop']['total'])): ?><br/><?php endif; ?>
				</div>
				<?php endforeach; endif; unset($_from); ?>
			</td>
		</tr>
		<?php elseif ($this->_tpl_vars['paty_sbmitter'] || $this->_tpl_vars['regering']): ?>
		<tr>
			<th scope="row">Ingediend door:</th>
			<td>
				<div>
					<?php if ($this->_tpl_vars['regering']): ?><?php echo $this->_tpl_vars['regering']; ?>

					<?php else: ?><a href="/search/party/<?php echo ((is_array($_tmp=$this->_tpl_vars['paty_sbmitter']->id)) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/submit/1" title="Toon alle moties en amendementen van <?php echo $this->_tpl_vars['paty_sbmitter']->name; ?>
"><?php echo $this->_tpl_vars['paty_sbmitter']->name; ?>
</a><?php endif; ?>
				</div>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th scope="row">Tags:</th>
			<td><span class="tag"><?php $_from = $this->_tpl_vars['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tag_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tag_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['tag']):
        $this->_foreach['tag_loop']['iteration']++;
?><a href="/search/tags/<?php echo ((is_array($_tmp=$this->_tpl_vars['tag'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/submit/1"><?php echo $this->_tpl_vars['tag']; ?>
</a><?php if (! ($this->_foreach['tag_loop']['iteration'] == $this->_foreach['tag_loop']['total'])): ?>, <?php endif; ?><?php endforeach; else: ?>Geen<?php endif; unset($_from); ?></span></td>
		</tr>
		<?php if ($this->_tpl_vars['parent']): ?>
		<tr>
			<th scope="row">Voorstel:</th>
			<td><a href="/raadsstukken/raadsstuk/<?php echo $this->_tpl_vars['parent']->id; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['parent']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a></td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['moties']): ?>
		<tr>
			<th scope="row">Moties:</th>
			<td>
				<?php $_from = $this->_tpl_vars['moties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['motie_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['motie_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['child']):
        $this->_foreach['motie_loop']['iteration']++;
?><?php echo ''; ?><?php if ($this->_tpl_vars['child']->id != $this->_tpl_vars['raadsstuk']->id): ?><?php echo '<a href="/raadsstukken/raadsstuk/'; ?><?php echo $this->_tpl_vars['child']->id; ?><?php echo '">'; ?><?php endif; ?><?php echo ''; ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['child']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?><?php echo ''; ?><?php if ($this->_tpl_vars['child']->id != $this->_tpl_vars['raadsstuk']->id): ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php if (! ($this->_foreach['motie_loop']['iteration'] == $this->_foreach['motie_loop']['total'])): ?><?php echo '<br />'; ?><?php endif; ?><?php echo ''; ?>
<?php endforeach; endif; unset($_from); ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['amendementen']): ?>
		<tr>
			<th scope="row">Amendementen:</th>
			<td>
				<?php $_from = $this->_tpl_vars['amendementen']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['amendement_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['amendement_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['child']):
        $this->_foreach['amendement_loop']['iteration']++;
?><?php echo ''; ?><?php if ($this->_tpl_vars['child']->id != $this->_tpl_vars['raadsstuk']->id): ?><?php echo '<a href="/raadsstukken/raadsstuk/'; ?><?php echo $this->_tpl_vars['child']->id; ?><?php echo '">'; ?><?php endif; ?><?php echo ''; ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['child']->title)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?><?php echo ''; ?><?php if ($this->_tpl_vars['child']->id != $this->_tpl_vars['raadsstuk']->id): ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php if (! ($this->_foreach['amendement_loop']['iteration'] == $this->_foreach['amendement_loop']['total'])): ?><?php echo '<br />'; ?><?php endif; ?><?php echo ''; ?>
<?php endforeach; endif; unset($_from); ?>
			</td>
		</tr>
		<?php endif; ?>
	</table>
</div>
<?php if ($this->_tpl_vars['raadsstuk']->result > 0): ?>
<div class="titleBlock"></div><h2>Overzicht resultaten</h2>
<div class="contentBlock">
	<table id="votes">
		<thead>
			<tr>
				<th scope="col" class="vote r0">Voor</th>
				<th scope="col" class="vote r1">Tegen</th>
				<th scope="col" class="vote r2">Onthouden</th>
				<th scope="col" class="vote r3">Afwezig</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $this->_tpl_vars['raadsstuk']->vote_0; ?>
</td>
				<td><?php echo $this->_tpl_vars['raadsstuk']->vote_1; ?>
</td>
				<td><?php echo $this->_tpl_vars['raadsstuk']->vote_2; ?>
</td>
				<td><?php echo $this->_tpl_vars['raadsstuk']->vote_3; ?>
</td>
			</tr>
		</tbody>
	</table>
</div>
<?php if ($this->_tpl_vars['img'] & 1): ?><p><img src="/home/pie/<?php echo $this->_tpl_vars['raadsstuk']->id; ?>
" alt="pie"/></p><?php endif; ?>
<?php endif; ?>
<?php if (count ( $this->_tpl_vars['formdata'] )): ?>
<div class="contentBlock">
	<table id="parties">
		<thead>
			<tr>
				<th scope="col" class="titleCol"><a href="?sortcol=party_name&amp;sort=<?php if ($this->_tpl_vars['formsort']['col'] == 'party_name' && $this->_tpl_vars['formsort']['dir'] == 'asc'): ?>desc<?php else: ?>asc<?php endif; ?>" class="<?php if ($this->_tpl_vars['formsort']['col'] == 'party_name'): ?>current <?php echo $this->_tpl_vars['formsort']['dir']; ?>
<?php else: ?>asc<?php endif; ?>">Partij</a></th>
				<th scope="col" class="votes">Stem</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['datarow']):
?>
			<?php $this->assign('pname', $this->_tpl_vars['datarow']->party_name); ?>
			<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
				<td class="party titleCol">
					<a class="partyLink" href="../party/<?php echo $this->_tpl_vars['datarow']->party; ?>
?raadsstuk=<?php echo $this->_tpl_vars['raadsstuk']->id; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['datarow']->party_name)) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a>
				</td>
				<td class="vote r<?php echo $this->_tpl_vars['datarow']->getResult(); ?>
"><?php echo $this->_tpl_vars['datarow']->getResultTitle(); ?>
</td>
			</tr>
			<?php $_from = $this->_tpl_vars['council'][$this->_tpl_vars['pname']]['politicians']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['politician']):
?>
			<tr	class="politician nodisplay">
				<td class="name"><?php if (! is_null ( $this->_tpl_vars['politician']['extern_id'] )): ?><a href="<?php echo $this->_tpl_vars['politician_base_url']; ?>
<?php echo $this->_tpl_vars['politician']['extern_id']; ?>
" title="<?php echo $this->_tpl_vars['politician']['name']; ?>
" target="_blank"><?php echo $this->_tpl_vars['politician']['name']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['politician']['name']; ?>
<?php endif; ?></td>
				<td class="vote r<?php echo $this->_tpl_vars['politician']['vote']->vote; ?>
"><?php echo $this->_tpl_vars['politician']['vote']->getVoteTitle(); ?>
</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
	<?php if ($this->_tpl_vars['img'] & 2): ?><p style="margin-top: 30px"><img src="/home/bar/<?php echo $this->_tpl_vars['raadsstuk']->id; ?>
" alt="bar"/></p><?php endif; ?>
</div>
<?php else: ?>
<div class="titleBlock"></div><h2 id="noresults">Geen stemresultaten</h2>
<?php endif; ?>