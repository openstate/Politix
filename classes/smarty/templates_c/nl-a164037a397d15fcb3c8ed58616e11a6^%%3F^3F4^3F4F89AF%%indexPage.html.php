<?php /* Smarty version 2.6.18, created on 2008-12-02 16:17:59
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/search/header/indexPage.html */ ?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '

window.addEvent(\'domready\', function() {
	var search = $(\'searchBlock\');
	var searchImage = $(\'searchImage\');

	search.open = function() {
		search.setStyle(\'display\', \'\');
		searchImage.setProperty(\'src\', \'/styles/close\');
	}

	search.close = function() {
		search.setStyle(\'display\', \'none\');
		searchImage.setProperty(\'src\', \'/styles/open\');
	}

	search.isOpen = function() {
		return search.getStyle(\'display\') != \'none\';
	}

	var st = $(\'search_span\');
	var el = new Element(\'a\', {href: \'#\'}).setText(st.getText()).injectTop(\'search_toggle\');
	st.remove();

	$(\'search_toggle\').addEvent(\'click\', function() {
		if (search.isOpen())
			search.close();
		else
			search.open();
	});

	if ($$(\'.result\').length) search.close();
});

'; ?>

//--><!]]>
</script>