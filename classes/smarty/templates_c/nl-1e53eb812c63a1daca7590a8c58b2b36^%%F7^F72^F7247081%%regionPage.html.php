<?php /* Smarty version 2.6.18, created on 2008-12-16 13:26:44
         compiled from /var/www/projects/politix/pages/admin/user/header/regionPage.html */ ?>
<?php echo '<script type="text/javascript">
<!--

window.addEvent(\'domready\', function() {
	var togglers = $$(\'.toggler\');
	togglers.each(function(toggle, i) {
		var num = toggle.id.split(\'_\');
		num = num[1];
		var region = $(\'region_\' + num);
		if(region == undefined) {
			toggle.setProperty(\'src\', \'/images/branch.gif\');
		} else {
			toggle.addEvent(\'click\', function(e) {
				if(region.style.display == \'none\') {
					region.style.display = \'\';
					toggle.setProperty(\'src\', \'/images/collapse.gif\');
				} else {
					region.style.display = \'none\';
					toggle.setProperty(\'src\', \'/images/expand.gif\');
				}
			});
		}
	});
});


// -->
</script>'; ?>