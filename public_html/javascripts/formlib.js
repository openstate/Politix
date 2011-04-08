function disableTag(tag, disable) {
	if (tag.type) // Check to see if this is an input tag
		tag.disabled = disable;
	var i;
	for (i=0; i<tag.childNodes.length; i++)
		disableTag(tag.childNodes.item(i), disable);
}

function isValidDate(datestr) {
	var parts = datestr.split('-');
	var d = new Date();
	d.setFullYear(parts[0], parts[1]-1, parts[2]);
	return (parts[0] == d.getFullYear() && parts[1]-1 == d.getMonth() && d.getDate() == parts[2]);
}

function makeDateStr(form, inputName) {
	var result;
	if (form[inputName+'[Year]']!=null)
		result = form[inputName+'[Year]'].value+'-';
	else
		result = '0000-';

	if (form[inputName+'[Month]']!=null)
		result+= form[inputName+'[Month]'].value+'-';
	else
		result+= '01-';

	if (form[inputName+'[Day]']!=null)
		result+= form[inputName+'[Day]'].value;
	else
		result+= '01';

	return result;
}

function isRadioSet(radio) {
	if (!radio.length) // Only 1 radio in group
		return radio.checked;
	var i;
	for (i=0; i<radio.length; i++)
		if (radio[i].checked)
			return true;
	return false;
}

function getRadioValue(radio) {
	if (!radio.length)
		if (radio.checked)
			return radio.value;
		else
			return '';

	var i;
	for (i=0; i<radio.length; i++)
		if (radio[i].checked)
			return radio[i].value;
	return '';
}

var autoValidate = false;

function revalidate(form) {
	if (!autoValidate) return;
	clearErrors();
	validate(form);
}

function formSubmit(form) {
	clearErrors();
	autoValidate = true;
	var valid = validate(form);
	if (!valid)
		location.hash = form.name;

	return valid;
}

function formReset(form) {
	form.reset();
	autoValidate = false;
	clearErrors();
	updateVisibility(form);
}