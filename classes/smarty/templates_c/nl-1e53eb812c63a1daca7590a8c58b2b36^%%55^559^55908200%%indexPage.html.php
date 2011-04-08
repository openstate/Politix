<?php /* Smarty version 2.6.18, created on 2008-12-16 13:23:50
         compiled from /var/www/projects/politix/pages/admin/politicians/content/indexPage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/projects/politix/pages/admin/politicians/content/indexPage.html', 26, false),array('modifier', 'htmlentities', '/var/www/projects/politix/pages/admin/politicians/content/indexPage.html', 27, false),)), $this); ?>


<h2>Politici</h2>

<form method="get" action="/politicians/">
<label for="query">Zoek op naam:</label>
<input type="text" name="q" id="query" value="<?php echo $this->_tpl_vars['query']; ?>
" />
<input type="submit" value="Zoeken" />
</form>

<?php if ($this->_tpl_vars['pager']): ?><p class="pager"><?php echo $this->_tpl_vars['pager']; ?>
</p><?php endif; ?>
<p><a href="create/"><img src="/images/add.png" border="0" title="Toevoegen" alt="Toevoegen"/> <a href="create/">Toevoegen</a></a>

<form action="" name="PoliticianList">
	<div id="accordion">
		<table class="list">
			<tr>
				<th>Titels</th>
				<th>Voorletters</th>
				<th>Achternaam</th>
				<th>Geslacht</th>
				<th>Email</th>
				<th>Opties</th>
			</tr>
			<?php $_from = $this->_tpl_vars['formdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['datarow']):
        $this->_foreach['dataloop']['iteration']++;
?>
				<tr class="link<?php echo smarty_function_cycle(array('values' => ', alt'), $this);?>
">
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['title'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['first_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
</td>
					<td><?php if (isset ( $this->_tpl_vars['datarow']['extern_id'] )): ?><a href="<?php echo $this->_tpl_vars['politician_base_url']; ?>
<?php echo $this->_tpl_vars['datarow']['extern_id']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['last_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
" target="_blank" onclick="event.cancelBubble = true; if(event.stopPropagation) event.stopPropagation();"><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['last_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
</a><?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['last_name'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
<?php endif; ?></td>
					<td><?php if ($this->_tpl_vars['datarow']['gender_is_male']): ?>Man<?php else: ?>Vrouw<?php endif; ?></td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['datarow']['email'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp, 2, 'UTF-8') : htmlentities($_tmp, 2, 'UTF-8')); ?>
</td>
					<td>
						<a class="edit" href="edit/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/edit.png" alt="Wijzigen" title="Wijzigen" border="0" /></a>
						<?php if ($this->_tpl_vars['datarow']['canDelete']): ?>
						<a href="delete/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/delete.png" alt="Verwijderen" title="Verwijderen" border="0" /></a>
						<?php endif; ?>
						<a href="/appointments/<?php echo $this->_tpl_vars['datarow']['id']; ?>
"><img src="/images/page_white_text.png" border="0" alt="Aanstelling toevoegen" title="Aanstelling toevoegen" /></a>
					</td>
				</tr>
<?php endforeach; endif; unset($_from); ?>

			</table>
</div>
</form>