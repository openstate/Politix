<?php /* Smarty version 2.6.18, created on 2008-12-02 16:18:00
         compiled from /var/www/projects/politix/public_html/../pages/watstemtmijnraad/search/php/../content//../../advsearch/content/search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/var/www/projects/politix/public_html/../pages/watstemtmijnraad/search/php/../content//../../advsearch/content/search.html', 20, false),array('function', 'html_select_date', '/var/www/projects/politix/public_html/../pages/watstemtmijnraad/search/php/../content//../../advsearch/content/search.html', 75, false),array('modifier', 'urldecode', '/var/www/projects/politix/public_html/../pages/watstemtmijnraad/search/php/../content//../../advsearch/content/search.html', 45, false),array('modifier', 'htmlspecialchars', '/var/www/projects/politix/public_html/../pages/watstemtmijnraad/search/php/../content//../../advsearch/content/search.html', 45, false),)), $this); ?>



<div id="searchBlock" class="contentBlock extramargin">
<form action="/search" method="post">
	<?php if (count ( $this->_tpl_vars['params'] )): ?>
	<p>
	<?php $_from = $this->_tpl_vars['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['i']):
?>
		<input type="hidden" name="<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['i']; ?>
"/>
	<?php endforeach; endif; unset($_from); ?>
	</p>
	<?php endif; ?>
	<table class="form">
		<?php if ($this->_tpl_vars['region_page']): ?>
		<tr><td><input type="hidden" name="region" value="<?php echo $this->_tpl_vars['region_page']->id; ?>
"/></td></tr>
		<?php else: ?>
		<?php if ($this->_tpl_vars['form']['show_region']): ?>
		<tr>
			<th scope="row"><label for="regionSelect">Gemeente</label></th>
			<td><?php echo smarty_function_html_options(array('name' => 'region','id' => 'regionSelect','options' => $this->_tpl_vars['regions'],'selected' => $this->_tpl_vars['query']->region), $this);?>
</td>
		</tr>
		<?php endif; ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_party']): ?>
		<tr>
			<th scope="row"><label for="partySelect">Partij</label></th>
			<td>
				<span id="party"><?php echo smarty_function_html_options(array('name' => 'party','id' => 'partySelect','options' => $this->_tpl_vars['parties'],'selected' => $this->_tpl_vars['query']->party), $this);?>
</span>
				<label><input type="checkbox" id="parExpired"<?php if ($this->_tpl_vars['parExpired']): ?> checked="checked"<?php endif; ?> /> Toon ook voormalige partijen</label>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_politician_id']): ?>
		<tr>
			<th scope="row"><label for="politicianSelect">Politicus</label></th>
			<td>
				<span id="politician"><?php echo smarty_function_html_options(array('name' => 'politician_id','id' => 'politicianSelect','options' => $this->_tpl_vars['politicians'],'selected' => $this->_tpl_vars['query']->politician_id), $this);?>
</span>
				<label><input type="checkbox" id="polExpired"<?php if ($this->_tpl_vars['polExpired']): ?> checked="checked"<?php endif; ?> /> Toon ook voormalige politici</label>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_code']): ?>
		<tr>
			<th scope="row"><label for="code">Code</label></th>
			<td><input type="text" name="code" id="code" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['query']->code)) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_title']): ?>
		<tr>
			<th scope="row"><label for="title">Titel</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['query']->title)) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_summary']): ?>
		<tr>
			<th scope="row"><label for="summary">Samenvatting</label></th>
			<td><input type="text" name="summary" id="summary" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['query']->summary)) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_category']): ?>
		<tr>
			<th scope="row"><label for="categorySelect">Onderwerp(en)</label></th>
			<td><?php echo smarty_function_html_options(array('name' => 'category','id' => 'categorySelect','options' => $this->_tpl_vars['categories'],'selected' => $this->_tpl_vars['query']->category), $this);?>
</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_type']): ?>
		<tr>
			<th scope="row"><label for="typeSelect">Soort</label></th>
			<td><?php echo smarty_function_html_options(array('name' => 'type','id' => 'typeSelect','options' => $this->_tpl_vars['types'],'selected' => $this->_tpl_vars['query']->type), $this);?>
</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_vote_date']): ?>
		<tr>
			<th scope="row"><label for="dateMonthSelect">Stemdatum</label></th>
			<td><?php echo smarty_function_html_select_date(array('field_order' => 'MY','month_extra' => 'id="dateMonthSelect"','start_year' => -5,'year_empty' => "",'month_empty' => "",'time' => $this->_tpl_vars['time']), $this);?>
</td>
		</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['form']['show_tags']): ?>
		<tr>
			<th scope="row"><label for="tags">Tags</label></th>
			<td><input type="text" name="tags" id="tags" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['query']->tags)) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th/>
			<td><input type="submit" class="submitButton" name="submit" value="Zoeken"/></td>
		</tr>
	</table>
</form>
</div>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '
function fillSelect(select, text) {
	var lines = text.split(\'\\n\');
	var selected = select.value;
	select.options.length = 0;
	for (var i = 0; i < lines.length; i++) {
		keyval = lines[i].split(\'||\');
		option = new Option();
		option.value = keyval[0];
		option.label = keyval[1];
		option.selected = keyval[0] == selected;
		option.text = keyval[1];
		select.options[i] = option;
	}
}
'; ?>


<?php if ($this->_tpl_vars['form']['show_party'] && $this->_tpl_vars['form']['show_politician_id']): ?><?php echo '
function partyChanged() {
	new Ajax(\'/select/politician/?party=\'+$(\'partySelect\').value+\'&region='; ?>
<?php if ($this->_tpl_vars['region_page']): ?><?php echo $this->_tpl_vars['region_page']->id; ?>
<?php elseif (! $this->_tpl_vars['form']['show_region']): ?>0<?php endif; ?>'<?php if (! $this->_tpl_vars['region_page']): ?>+$('regionSelect').value<?php endif; ?><?php echo '+($(\'polExpired\').checked ? \'&expired\' : \'\'), {method: \'get\', onComplete: function(text) {
		fillSelect($(\'politicianSelect\'), text);
	}}).request();
}

'; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['form']['show_party']): ?><?php echo '
function regionChanged() {
	new Ajax(\'/select/party/?region='; ?>
<?php if ($this->_tpl_vars['region_page']): ?><?php echo $this->_tpl_vars['region_page']->id; ?>
<?php elseif (! $this->_tpl_vars['form']['show_region']): ?>0<?php endif; ?>'<?php if (! $this->_tpl_vars['region_page'] && $this->_tpl_vars['form']['show_region']): ?>+$('regionSelect').value<?php endif; ?><?php echo '+($(\'parExpired\').checked ? \'&expired\' : \'\'), {method: \'get\', onComplete: function(text) {
		fillSelect($(\'partySelect\'), text);
		'; ?>
<?php if ($this->_tpl_vars['form']['show_politician_id']): ?><?php echo '
		$(\'partySelect\').addEvent(\'change\', partyChanged);
		'; ?>
<?php endif; ?><?php echo '
	}}).request();
	'; ?>
<?php if ($this->_tpl_vars['form']['show_politician_id']): ?><?php echo '
	partyChanged();
	'; ?>
<?php endif; ?><?php echo '
}

//window.addEvent(\'domready\', regionChanged);
'; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['form']['show_party'] && $this->_tpl_vars['form']['show_politician_id']): ?><?php echo '
window.addEvent(\'domready\', function() {
	$(\'partySelect\').addEvent(\'change\', partyChanged);
	$(\'polExpired\').addEvent(\'click\', partyChanged);
	partyChanged();
});
'; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['form']['show_party']): ?><?php echo '
window.addEvent(\'domready\', function() {
'; ?>
<?php if ($this->_tpl_vars['form']['show_region'] && ! $this->_tpl_vars['region_page']): ?><?php echo '
	$(\'regionSelect\').addEvent(\'change\', regionChanged);
'; ?>
<?php endif; ?><?php echo '
	$(\'parExpired\').addEvent(\'click\', regionChanged);
	regionChanged();
});
'; ?>
<?php endif; ?>
//--><!]]>
</script>