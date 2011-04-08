<?php /* Smarty version 2.6.18, created on 2009-04-08 09:55:20
         compiled from /var/www/projects/politix/pages/admin/appointments/header/formPage.html */ ?>
<script type="text/javascript" src="/javascripts/formValidation.js"></script>
<?php if (! $this->_tpl_vars['form']['freeze']): ?>
<script type="text/javascript" src="/javascripts/lookAheadText.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '
var s = \'--Typ hier om te zoeken--\';

window.addEvent(\'domready\', function() {
	if ($defined($(\'politician\'))) {
		lookAheadText = new LookAheadText($(\'politician\'));
		var el = lookAheadText.getElement();
		el.injectBefore($(\'politician\'));


		el.blur = function() {
			if (this.value == \'\')
				this.setStyle(\'color\', \'#aaa\').value = s;
		}
		el.focus = function() {
			if (this.value == s)
				this.setStyle(\'color\', \'black\').value = \'\';
		}

		el.addEvent(\'blur\', el.blur).addEvent(\'focus\', el.focus).blur();
	}
});
'; ?>

//--><!]]>
</script>
<?php endif; ?>