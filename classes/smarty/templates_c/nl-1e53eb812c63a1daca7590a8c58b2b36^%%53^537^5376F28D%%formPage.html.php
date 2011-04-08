<?php /* Smarty version 2.6.18, created on 2008-12-16 13:11:19
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/header/formPage.html */ ?>

<script type="text/javascript" src="/javascripts/formValidation.js"></script>
<?php if (! $this->_tpl_vars['form']['freeze']): ?>
<script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/javascripts/tinymce_init.js"></script>
<script type="text/javascript" src="/javascripts/mootools/Autocompleter.js"></script>
<script type="text/javascript" src="/javascripts/mootools/Observer.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
var allTags = <?php echo $this->_tpl_vars['allTags']; ?>
;
var tags = <?php echo $this->_tpl_vars['tags']; ?>
;
var cats = <?php echo $this->_tpl_vars['cats']; ?>
;
var catNames = <?php echo $this->_tpl_vars['catNames']; ?>
;

<?php echo '
var currentDate;
var unrestrictParent;

var tag_button;
var tag_text;
var tag_list;
var cat_button;
var cat_select;
var cat_list;

window.addEvent(\'domready\', function() {
	currentDate = $(\'day\').getValue()+\'-\'+$(\'month\').getValue()+\'-\'+$(\'year\').getValue();
	unrestrictParent = $(\'unrestrict_parent\').getValue();

	tag_button = $(\'tag_add\');
	tag_text = $(\'tag_text\');
	tag_list = $(\'tag_list\');
	cat_button = $$(\'.cat_add\');
	cat_select = $(\'cat_select\');
	cat_list = $(\'cat_list\');

	tags.each(function(item) {
		addTag(item);
	});

	cats.each(function(item, key) {
		addCat(item, catNames[key]);
	});

	tag_button.addEvent(\'click\', function() {
		if (Validator.notWhitespace(tag_text.getValue()) && !tags.contains(tag_text.getValue())) {
			addTag(tag_text.getValue());
		}
	});

	cat_button.addEvent(\'click\', function() {
		var value = parseInt(cat_select.getValue());
		if (cat_select.value > 0 && !cats.contains(value)) {
			addCat(value, cat_select.options[cat_select.selectedIndex].label);
		}
	});

	var completer = new Autocompleter.Local(tag_text, allTags, {
  	\'delay\': 0,
		\'maxChoices\': 10,
    \'filterTokens\': function() {
    	var regex = new RegExp(\'^\'+this.queryValue.escapeRegExp(), \'i\');
      return this.tokens.filter(function(tag) {
					return regex.test(tag);
    	});
  	},
		\'injectChoice\': function(choice) {
			var el = new Element(\'li\')
				.setHTML(this.markQueryValue(choice));
			el.inputValue = choice;
			this.addChoiceEvents(el).injectInside(this.choices);
		}
	});

	var type = $(\'type\');
	type.addEvent(\'change\', function(e) {
		$ES(\'div\', \'sub_el\').each(function(el) {
			toggleSubmitter(el, false);
		});

		switch (parseInt(type.options[type.selectedIndex].value)) {
		case 1: //Raadsvoorstel, Wetsvoorstel
			//toggleSubmitter(\'sub_el_rs\');
			//$(\'parent_row\').setStyle(\'display\', \'none\');

			$(\'parent_row\').setStyle(\'display\', \'none\');
			toggleSubmitter(\'sub_el_party\');
			break;

		case 2: //Initiatief voorstel
			toggleSubmitter(\'sub_el_members\');
			$(\'parent_row\').setStyle(\'display\', \'none\');
			break;

		case 3: //Amandament
			$(\'parent_row\').setStyle(\'display\', \'\');
			toggleSubmitter(\'sub_el_members\');
			break;

		/* case 4: //Burger initiatief
			$(\'parent_row\').setStyle(\'display\', \'none\');
			toggleSubmitter(\'sub_el_citizen\'); break; */

		default: //Onbekend
			$(\'parent_row\').setStyle(\'display\', \'none\');
			toggleSubmitter(\'sub_el_unknown\');
			break;
		}
	});

	$ES(\'select\', \'sub_el\').each(function (el) {
		el.disabled = (el.getParent().getStyle(\'display\') == \'none\');
	});
});

function toggleSubmitter(el, toggle) {
	if (null == toggle) toggle = true;
	var sel = $E(\'select\', el);
	if (sel) sel.disabled = !toggle;
	$(el).setStyle(\'display\', toggle ? \'\' : \'none\');
}

function addTag(tag) {
	new Element(\'input\', {type: \'hidden\', name: \'tags[]\', value: tag}).injectAfter(
	new Element(\'span\', {\'class\': \'tag\'}).setText(tag).injectAfter(
	new Element(\'img\', {src: \'/images/delete.png\', alt: \'Tag verwijderen\', title: \'Tag verwijderen\'}).addEvent(
	\'click\', function () {
		tags.remove(this.getNext().getText());
		this.getParent().remove();
		showTagList();
	}, this).injectInside(new Element(\'div\').injectInside(tag_list))));
	tags.push(tag);
	tag_text.value = \'\';
	showTagList();
}

function addCat(catId, catName) {
	new Element(\'input\', {type: \'hidden\', name: \'cats[]\', value: catId}).injectAfter(
	new Element(\'span\', {\'class\': \'cat\'}).setText(catName).injectAfter(
	new Element(\'img\', {src: \'/images/delete.png\', alt: \'Categorie verwijderen\', title: \'Categorie verwijderen\'}).addEvent(
	\'click\', function () {
		cats.remove(this.getNext().getNext().value);
		this.getParent().remove();
		showCatList();
	}, this).injectInside(new Element(\'div\').injectInside(cat_list))));
	cats.push(catId);
	showCatList();
}

function showTagList() {
	showList(\'tag\');
}

function showCatList() {
	showList(\'cat\');
}

function showList(prefix) {
	var el = $(prefix+\'_list\');
	el.setStyle(\'display\', el.getChildren().length ? \'\' : \'none\');
}

function dateOnChange() {
	date = $(\'year\').getValue()+\'-\'+$(\'month\').getValue()+\'-\'+$(\'day\').getValue();
	if (date == currentDate)
		return;
	currentDate = date;

	var request = new Ajax(\'/raadsstukken/submitters/\', {method: \'get\',
		\'data\': \'date=\'+date+\'&s=\'+$(\'submitters\').getValue(),
		onComplete: function(text, xml) {
			if (text == \'\')
				alert(\'Interne fout\');
			else
				$(\'sub_el_members\').empty().setHTML(text);
	}});

	request.request();

	if (!$(\'unrestrict_parent\').getValue()) {
		var request = new Ajax(\'/raadsstukken/parents/\', {method: \'get\',
			\'data\': \'date=\'+date+\'&s=\'+$(\'parent\').getValue()'; ?>
<?php if ($this->_tpl_vars['formdata']['id']): ?>+'&ex=<?php echo $this->_tpl_vars['formdata']['id']; ?>
'<?php endif; ?><?php echo ',
			onComplete: function(text, xml) {
				if (text == \'\')
					alert(\'Interne fout\');
				else
					$(\'parent_el\').empty().setHTML(text);
		}});

		request.request();
	}
}

function unrestrictParentOnChange() {
	if (unrestrictParent == $(\'unrestrict_parent\').getValue())
		return;
	unrestrictParent = $(\'unrestrict_parent\').getValue();

	var request = new Ajax(\'/raadsstukken/parents/\', {method: \'get\',
		\'data\': (!unrestrictParent ? \'date=\'+currentDate+\'&\' : \'\')+\'s=\'+$(\'parent\').getValue()'; ?>
<?php if ($this->_tpl_vars['formdata']['id']): ?>+'&ex=<?php echo $this->_tpl_vars['formdata']['id']; ?>
'<?php endif; ?><?php echo ',
		onComplete: function(text, xml) {
			if (text == \'\')
				alert(\'Interne fout\');
			else
				$(\'parent_el\').empty().setHTML(text);
	}});

	request.request();
}

'; ?>

//--><!]]>
</script>
<?php endif; ?>