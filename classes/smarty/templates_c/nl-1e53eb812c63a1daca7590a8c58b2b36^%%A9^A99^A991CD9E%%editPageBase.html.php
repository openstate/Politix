<?php /* Smarty version 2.6.18, created on 2008-12-16 13:27:54
         compiled from /var/www/projects/politix/public_html/../pages/admin/user/php/../header//editPageBase.html */ ?>
<?php echo '<script type="text/javascript">
<!--
function clearErrors() {
	document.getElementById(\'_err_username_0\').style.display = \'none\';
	document.getElementById(\'_err_email_0\').style.display = \'none\';
	document.getElementById(\'_err_password_0\').style.display = \'none\';
	document.getElementById(\'_err_password_1\').style.display = \'none\';
	document.getElementById(\'_err_gender_0\').style.display = \'none\';
}

function validate(form) {
	var maySubmit = true
	if (form[\'username\'].value == \'\') { document.getElementById(\'_err_username_0\').style.display = \'\'; maySubmit = false; }
	if (form[\'password\'].value != form[\'password2\'].value) { document.getElementById(\'_err_password_0\').style.display = \'\'; maySubmit = false; }
	if (form[\'email\'].value == \'\') { document.getElementById(\'_err_email_0\').style.display = \'\'; maySubmit = false; }
	return maySubmit;
}

// -->
</script>'; ?>
