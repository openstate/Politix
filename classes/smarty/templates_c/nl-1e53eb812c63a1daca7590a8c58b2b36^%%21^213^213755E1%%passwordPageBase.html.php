<?php /* Smarty version 2.6.18, created on 2009-03-11 15:25:07
         compiled from /var/www/projects/politix/modules/user/pages/login/php/../header//passwordPageBase.html */ ?>
<?php echo '<script type="text/javascript">
<!--//--><![CDATA[//><!--
function updateVisibility(form) {
	
}

function clearErrors() {
			document.getElementById(\'_err_username_0\').style.display = \'none\';
		document.getElementById(\'_err_email_0\').style.display = \'none\';
		document.getElementById(\'_err_email_1\').style.display = \'none\';
		document.getElementById(\'_err_email_2\').style.display = \'none\';

}

function validate(form) {
	var maySubmit = true;
			if ((form[\'username\'].value!=\'\' && !true)) { document.getElementById(\'_err_username_0\').style.display = \'\'; maySubmit = false; }
		if (form[\'email\'].value!=\'\') if (!(form[\'email\'].value.search(/^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{}|~-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/)!=-1)) { document.getElementById(\'_err_email_0\').style.display = \'\'; maySubmit = false; }
		else if (!true) { document.getElementById(\'_err_email_1\').style.display = \'\'; maySubmit = false; }
		else if (!true) { document.getElementById(\'_err_email_2\').style.display = \'\'; maySubmit = false; }

//	if (!maySubmit)
//		location.hash = \'PasswordCreate\';
	return maySubmit;
}

//--><!]]>
</script>'; ?>