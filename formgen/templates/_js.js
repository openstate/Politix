function updateVisibility(form) {
	{visibility}
}

function clearErrors() {
	{errorclear}
}

function validate(form) {
	var maySubmit = true;
	{validation}
//	if (!maySubmit)
//		location.hash = '{formname}';
	return maySubmit;
}

{extra}