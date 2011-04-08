function fillSelect(select, text) {
	var lines = text.split('\n');
	var selected = select.value;
	select.options.length = 0;
	for (var i = 0; i < lines.length; i++) {
		keyval = lines[i].split('||');
		option = new Option();
		option.value = keyval[0];
		option.label = keyval[1];
		option.selected = keyval[0] == selected;
		option.text = keyval[1];
		select.options[i] = option;
	}
}

function selectProvince(id) {
	$("province").selectedIndex = id;
	getGemeente(id+2);
}

function setProvincie(select) {
	$('Swiff_1').setProvincieFlash(select.selectedIndex);
}

function getGemeente(province) {
	if (province > 0) {
		new Ajax('/home/gemeente/'+province, {method: 'get',
		onComplete: function(text) {
			fillSelect($('gemeente'), text);
			toggleSearch($('gemeente').value > 0);
		}}).request();
	}
	$('gemeente_div').setStyle('display', province > 0 ? 'block' : 'none');
}

function toggleSearch(toggle) {
	$('home_search').setStyle('display', toggle ? 'block' : 'none');	
}

window.addEvent('domready', function(e) {
	$('province').addEvent('change', function(e) {
		getGemeente($('province').getValue());
	});

	$('gemeente').addEvent('change', function(e) {
		toggleSearch(this.getValue() > 0);
	});
});
