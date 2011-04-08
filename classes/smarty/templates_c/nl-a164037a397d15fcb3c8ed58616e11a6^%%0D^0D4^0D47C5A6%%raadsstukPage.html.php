<?php /* Smarty version 2.6.18, created on 2009-04-09 13:12:45
         compiled from /var/www/projects/politix/pages/watstemtmijnraad/raadsstukken/header/raadsstukPage.html */ ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php echo '
window.addEvent(\'domready\', function(e) {
	$ES(\'tr.link\', \'parties\').each(function(el) {
		var ps = [];
		var next = el.getNext();
		while (!(null == next || next.hasClass(\'link\'))) {
			ps.push(next);
			next = next.getNext();
		}

		var img = new Element(\'img\');

		el.open = function() {
			ps.each(function(el) {
				el.removeClass(\'nodisplay\');
			});
			img.src = \'/images/collapse.gif\';
			img.alt = \'Sluiten\';
			img.title = \'Sluiten\';
			el.addClass(\'open\');
		}

		el.close = function() {
			ps.each(function(el) {
				el.addClass(\'nodisplay\');
			});
			img.src = \'/images/expand.gif\';
			img.alt = \'Openen\';
			img.title = \'Openen\';
			el.removeClass(\'open\');
		}

		el.isOpen = function() {
			return this.hasClass(\'open\');
		}

		el.toggle = function() {
			if(ps.length < 1) return;
			if (this.isOpen()) {
				this.close();
			} else {
				this.open();
			}
		}

		var partyLink = $E(\'a.partyLink\', el);
		img.injectBefore(partyLink);
		
		if(ps.length > 0) {
			img.addEvent(\'click\', function(e) { el.toggle(); });
			el.close();
		}

		new Element(\'span\')
		  .setText(partyLink.getText())
		  .injectAfter(img)
			.addEvent(\'click\', function(e) {
			el.toggle();
		});
		partyLink.remove();
	});

	$$(\'span.sub_party\').each(function(el) {
		new Element(\'a\', {href: \'#\', \'class\': \'sub_party\'}).setText(el.getText()).injectTop(el.getParent());
		el.remove();
	});

	$$(\'a.sub_party\').each(function(el) {
		el.open = function() {
			el.getNext().getNext().setStyle(\'display\', \'\');
			el.getNext().setProperty(\'src\', \'/styles/close\');
		}

		el.close = function() {
			el.getNext().getNext().setStyle(\'display\', \'none\');
			el.getNext().setProperty(\'src\', \'/styles/open\');
		}

		el.isOpen = function() {
			return el.getNext().getNext().getStyle(\'display\') != \'none\';
		}

		el.toggle = function() {
			if (el.isOpen())
				el.close();
			else
				el.open();
		}

		el.close();
		el.addEvent(\'click\', el.toggle).getNext().addEvent(\'click\', el.toggle);
	});
});
'; ?>

//--><!]]>
</script>