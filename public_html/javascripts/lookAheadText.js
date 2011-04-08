function LookAheadText(dropdown) {
	var ids = [];
	var names = [];
	var element = new Element('input');
	element.type = 'text';
	element.addEvent('keyup', function(e) {
		var prefix = element.value.toLowerCase();
		var index = binSearch(prefix);
		if (index >= 0) {
			var r = getRange(prefix, index);
			dropdown.empty();
			for (var i = r[0]; i < r[1]; i++) {
				var option = new Element('option');
				option.value = ids[i];
				option.label = names[i];
				option.setText(names[i]);
				dropdown.appendChild(option);
			}
		}
	});
	fillArray();

	function fillArray() {
		for (var i = 0; i < dropdown.options.length; i++) {
			var option = dropdown.options[i];
			ids.push(option.value);
			names.push(option.label);
		}
	}

	function binSearch(prefix) {
		var start = 0;
		var end = names.length - 1;
		while (start <= end) {
			var m = Math.floor((start + end) / 2);
			var substr = names[m].substring(0, prefix.length).toLowerCase();
			if (substr > prefix) {
				end = m - 1;
			} else if (substr < prefix) {
				start = m + 1;
			} else {
				return m;
			}
		}
		return -1;
	}

	function getRange(prefix, index) {
		var start = index;
		var end = index;
		while (names[start].substring(0, prefix.length).toLowerCase() == prefix) {
			start--;
			if (start < 0) break;
		}
		start++;

		while (names[end].substring(0, prefix.length).toLowerCase() == prefix) {
			end++;
			if (end >= names.length) break;
		}
		return [start, end];
	}

	this.getElement = function () {
		return element;
	};
}