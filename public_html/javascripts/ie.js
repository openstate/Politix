if (window.ie) {
	window.addEvent('domready', function(e) {
		$$('span.error').each(function(el) { // :before hack
			new Element('img', {src: '/images/arrow_side_up.png'}).injectTop(el);
		});
	});
}
