<?php /* Smarty version 2.6.18, created on 2009-04-08 09:52:52
         compiled from /var/www/projects/politix/public_html/../pages/admin/appointments/php/../header//createPageBase.html */ ?>
<?php echo '<script type="text/javascript">
<!--//--><![CDATA[//><!--


var spinnerParty = null;
var spinnerCategory = null;


function loadPartyDropdown(regionIndex) {
	if (regionIndex == 0) return;
	var request = new Ajax(\'/appointments/partylist/\'+regionIndex, {method: \'get\', data: \'ajax\',
		onRequest: function() {
			spinnerParty.injectAfter($(\'party\'));
		},
		onComplete: function(text, xml) {
			spinnerParty.remove();
			// failure
			if (text == \'#failed#\') {
				alert(\'Er is een interne fout opgetreden.\');
				return;
			}
			text = \'<select name="party" id="party">\\n\'+text+\'<\\/select>\';
			$(\'partyDiv\').empty().setHTML(text);
		}});
	request.request();
};

function loadCategoryDropdown(regionIndex) {
	if (regionIndex == 0) return;
	var request = new Ajax(\'/appointments/categorylist/\'+regionIndex, {method: \'get\', data: \'ajax\',
		onRequest: function() {
			spinnerCategory.injectAfter($(\'category\'));
		},
		onComplete: function(text, xml) {
			spinnerCategory.remove();
			// failure
			if (text == \'#failed#\') {
				alert(\'Er is een interne fout opgetreden.\');
				return;
			}
			text = \'<select name="category" id="category">\\n\'+text+\'<\\/select>\';
			$(\'categoryDiv\').empty().setHTML(text);
		}});
	request.request();
}

function setDropdowns() {
	var regionSelect = $(\'region\');
	loadPartyDropdown(regionSelect.options[regionSelect.selectedIndex].value);
	loadCategoryDropdown(regionSelect.options[regionSelect.selectedIndex].value);
}

function clearDropdowns() {
	$(\'categoryDiv\').empty().setHTML(\'<select name="category" id="category"><option label="" value="0">Geen<\\/option><\\/select>\');
	$(\'partyDiv\').empty().setHTML(\'<select name="party" id="party"><option label="" value="0">Geen<\\/option><\\/select>\');
}

window.addEvent(\'domready\', function() {
	spinnerParty = new Element(\'img\');
	spinnerParty.setProperty(\'src\', \'/images/spinner.gif\');
	spinnerParty.setProperty(\'alt\', \'spinner\');
	spinnerParty.addClass(\'spinner\');

	spinnerCategory = new Element(\'img\');
	spinnerCategory.setProperty(\'src\', \'/images/spinner.gif\');
	spinnerCategory.setProperty(\'alt\', \'spinner\');
	spinnerCategory.addClass(\'spinner\');

	$(\'region\').addEvent(\'change\', setDropdowns);	
	clearDropdowns();
	setDropdowns();
});
//--><!]]>
</script>'; ?>
