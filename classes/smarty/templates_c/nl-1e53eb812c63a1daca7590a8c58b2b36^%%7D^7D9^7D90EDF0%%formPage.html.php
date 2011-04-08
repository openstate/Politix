<?php /* Smarty version 2.6.18, created on 2009-03-11 15:27:41
         compiled from /var/www/projects/politix/pages/admin/party/header/formPage.html */ ?>
<script type="text/javascript" src="/javascripts/formValidation.js"></script>
<?php if (! $this->_tpl_vars['form']['freeze']): ?>
<script type="text/javascript">
<?php echo '
<!--
window.addEvent(\'domready\', function() {
	var parents = $(\'parents\');
	var tr_parents = $(\'tr_parents\');

	parents.addEvent(\'validate\', function(_) {
  	_(!($(\'combination\').checked && this.getValue().length < 2), \'required\');
	});

	parents.open = function() {
		tr_parents.setStyle(\'display\', \'\');
	}

	parents.close = function() {
		tr_parents.setStyle(\'display\', \'none\');
	}	

	parents.isOpen = function() {
		return tr_parents.getStyle(\'display\') != \'none\';
	}

	$(\'combination\').addEvent(\'click\', function() {
		if (parents.isOpen())
			parents.close();
		else
			parents.open();
	});
});
//-->
'; ?>

</script>
<?php endif; ?>