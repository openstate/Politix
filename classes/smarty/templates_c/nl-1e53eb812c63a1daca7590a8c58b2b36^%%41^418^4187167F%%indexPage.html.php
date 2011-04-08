<?php /* Smarty version 2.6.18, created on 2008-12-16 13:11:13
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/header/indexPage.html */ ?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '
window.addEvent(\'domready\', function(e) {
	$$(\'tr.link\').addEvent(\'click\', function(e) {
		var v = $E(\'a.edit\', this);
		if ($defined(v)) location.href = v.href;
	});
});
'; ?>

//--><!]]>
</script>