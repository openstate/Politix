<?php /* Smarty version 2.6.18, created on 2008-12-16 13:31:31
         compiled from /var/www/projects/politix/pages/admin/raadsstukken/header/votePage.html */ ?>


<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '

var text = [\'Voor\', \'Tegen\', \'Onthouden\', \'Afwezig\'];
var resultText = [\'Niet gestemd\', \'Aangenomen\', \'Afgewezen\'];
var resultClass = [\'notVoted\', \'voor\', \'tegen\'];

var VoteItem = new Class({
	className: \'vote-item\',

	initialize: function(el) {
		this.element = el;
		this.text = el.getFirst().getNext();
	},

	setText: function(text) {
		return this.text.setText(text);
	},

	setClass: function(klass) {
		this.element.setProperty(\'class\', this.className + \' \' + klass);
	}
});

var ResultItem = VoteItem.extend({
	className: \'result-item\'
});

var Votable = new Class({
	_vote: null,

	vote: function(value) {
		if ($defined(this.children)) {
			this.children.each(function(obj) {
				obj.vote(value);
			});
		}
		this.setValue(value);
	},

	getVote: function() {
		return this._vote;
	},

	setValue: function(value) {
		this.element.value = value;
		this.vote_item.setClass(text[value].toLowerCase())
		this.vote_item.setText(text[value]);
		this._vote = value;
	},

	clear: function() {
		this.element.value = \'\';
		this.vote_item.setClass(\'Verdeeld\'.toLowerCase());
		this.vote_item.setText(\'Verdeeld\');
		this._vote = null;
	},

	calculateParentVote: function(value) {
		if ($defined(this.parent)) {
			var p = this.parent;
			var v = [0, 0, 0, 0];
			p.children.each(function(obj) {
				v[obj.getVote()]++;
			});
			if (v[0] && v[1]) {
				p.clear();
			} else {
				v.some(function(item, index) {
					if (item) p.setValue(index);
					return item;
				});
			}
			this.parent.calculateParentVote(value);
		}
	},

	calculateResult: function() {
		var count = [0,0];
		var total = 0;
		$$(\'input.politician\').each(function(el) {
			if (el.value == 0 || el.value == 1) {
				total++;
				count[el.value]++;
			}
		});
		total /= 2;
		if (count[0] > total) {
			$(\'result\').setValue(1);
		} else if (count[1] > total) {
			$(\'result\').setValue(2);
		} else {
			$(\'result\').setValue(0);
		}
	},

	register: function() {
		this.element.object = this;
		this.vote_item = new VoteItem(this.element.getParent().getFirst().getNext());
	}
});

var Council = Votable.extend({
	initialize: function(el) {
		this.element = el;
		this.children = [];
		$$(\'input.party\').each(function(el) {
			var id = el.name.substring(6, el.name.indexOf(\']\'));
			this.children.push(new Party(id, el, this));
		}, this);
		this.register();
	}
});

var Party = Votable.extend({
	initialize: function(id, el, council) {
		this.id = id;
		this.element = el;
		this.parent = council;
		this.children = [];
		$ES(\'input.politician\').filterByClass(el.name).each(function(el) {
			var id = el.name.substring(11, el.name.indexOf(\']\'));
			this.children.push(new Politician(id, el, this));
		}, this);
		this.register();
	}
});

var Politician = Votable.extend({
	initialize: function(id, el, party) {
		this.id = id;
		this.element = el;
		this.parent = party;
		this.register();
	}
});

function initBox(boxes, type) {
	var box = $(type + \'-box\');
	box.element = $E(\'.\' + type + \'-item\');
	box.open = function (el) {
		boxes.each(function (el) {
			// Close all other boxes
			if (box != el) {
				el.close();
				el.element.fireEvent(\'mouseout\');
			}
		});
		if (this.element != el) {
			this.element.setStyle(\'width\', \'8em\');
		}
		this.setStyle(\'display\', \'\');
		this.element = el;
		this.setValue(this.getPrevious().value);
	}

	box.close = function (el) {
		this.setStyle(\'display\', \'none\');
	}

	box.isOpen = function (el) {
		return this.element == el && this.style.display == \'\';
	}

	box.radios = $ES(\'input\', box);

	box.setValue = function(value) {
		if (value == null || value == \'\')
			box.radios.each(function(el) { el.checked = false });
		else
			box.radios[value].checked = true;
	}

	/*
	$$(\'.vote-item\').each (function(el) {
		el.slide = new Fx.Style(el, \'width\', { transition: Fx.Transitions.Quad.easeOut, duration: 300 });
	});
	*/

	$$(\'.\' + type + \'-item\').addEvent(\'click\', function(e) {
		box.injectBefore(this);
		if (box.isOpen(this)) {
			box.close(this);
		} else {
			box.open(this);
		}
	}).addEvent(\'mouseover\', function(e) {
		this.caption.addClass(\'highlight\');
		if (!box.isOpen(this)) {
			this.setStyle(\'width\', \'9em\');
		}
	}).addEvent(\'mouseout\', function(e) {
		this.caption.removeClass(\'highlight\');
		if (!box.isOpen(this)) {
			this.setStyle(\'width\', \'8em\');
		}
	}).each(function(el) {
			el.caption = el.getParent().getPrevious().getFirst();
	});
}

window.addEvent(\'domready\', function() {
	window.council = new Council($$(\'input.raad\')[0]);
	var result = $(\'result\');

	$$(\'input.vote\').each(function(el) {
		if (el.value != \'\') {
			el.object.vote(el.value);
			el.object.calculateParentVote(el.value);
		}
	});

	result.object = new ResultItem(result.getNext());
	result.setValue = function(value) {
		if (!$defined(value)) value = result.value;
		else result.value = value;
		result.object.setText(resultText[value]);
		result.object.setClass(resultClass[value]);
	}

	if (result.value != \'\') {
		result.setValue();
	}

	var boxes = [$(\'vote-box\'), $(\'result-box\')];

	initBox(boxes, \'vote\');
	initBox(boxes, \'result\');

	// Radios are not in dom-order
	$(\'result-box\').radios = [$(\'result-box-item-0\'),
														$(\'result-box-item-1\'),
														$(\'result-box-item-2\')];

	$$(\'.vote-box-item\').addEvent(\'click\', function(e) {
		var obj = this.getParent().getParent().getFirst().object;
		var value = this.getFirst().value;
		obj.vote(value);
		obj.calculateParentVote(value);
		obj.calculateResult();
		$(\'vote-box\').close();
		obj.vote_item.element.fireEvent(\'mouseout\');
	});

	$$(\'.result-box-item\').addEvent(\'click\', function(e) {
		var result = $(\'result\');
		result.setValue(this.getFirst().value);
		$(\'result-box\').close();
		result.object.element.fireEvent(\'mouseout\');
	});
});
'; ?>

//--><!]]>
</script>