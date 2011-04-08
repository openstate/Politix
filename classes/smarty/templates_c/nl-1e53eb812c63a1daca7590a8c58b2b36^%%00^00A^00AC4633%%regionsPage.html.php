<?php /* Smarty version 2.6.18, created on 2008-12-16 13:24:00
         compiled from /var/www/projects/politix/pages/admin/party/header/regionsPage.html */ ?>

<?php echo '
<script type="text/javascript" src="/javascripts/lookAheadText.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--

window.addEvent(\'domready\', function() {
	//check boxes
	var div = $(\'selects_java\');
	var link1 = new Element(\'a\').setText(\'Selecteer alles\');
	var link2 = new Element(\'a\').setText(\'Deselecteer alles\');
	
	link1.addEvent(\'click\', function(e) {
		var boxes = $$(\'.checkbox\');
		boxes.each(function(box, i) {
			box.checked = "checked";
		});
	});
	
	link2.addEvent(\'click\', function(e) {
		var boxes = $$(\'.checkbox\');
		boxes.each(function(box, i) {
			box.checked = "";
		});
	});
	div.appendChild(link1);
	div.appendChild(new Element(\'span\').setHTML(\'&#160;-&#160;\'));
	div.appendChild(link2);
	
	//onsubmit	
	$(\'partyListForm\').addEvent(\'submit\', function(e) {
		var e = new Event(e);
		if(!confirm(\'Weet u zeker dat u de geselecteerde regio\\\'s wilt verwijderen?\')) {
			e.preventDefault();
			return false;
		}
	});	

	//lookAheadText = new LookAheadText($(\'secretary\'));
	//lookAheadText.getElement().injectBefore($(\'secretary\'));
});

//--><!]]>
</script>'; ?>
