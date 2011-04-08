function toggle(element) {
	if (element.style.display=='none')
		element.style.display='';
	else
		element.style.display='none';
}

function openCalendar(calendar) {
	dateSelected(calendar);
	toggle(calendar.outerContainer);
}

function dateSelected(calendar) {
	selDay   = calendar.form[calendar.inputName+'[Day]'];
	selMonth = calendar.form[calendar.inputName+'[Month]'];
	selYear  = calendar.form[calendar.inputName+'[Year]'];

	calendar.selectFullDay(selDay.selectedIndex+1, selMonth.selectedIndex+1, selYear.options[selYear.selectedIndex].value);
}

function calCallback(day, month, year, calendar) {
	calendar.form[calendar.inputName+'[Day]'].selectedIndex=day-1;
	calendar.form[calendar.inputName+'[Month]'].selectedIndex=month-1;
	var i = 0;
	var yr = calendar.form[calendar.inputName+'[Year]'];
	while (i<yr.options.length) {
		if (yr.options[i].value==year) {
			yr.selectedIndex = i;
			return;
		}
		i++;
	}
}

function closeCalendar(calendar) {
	toggle(calendar.outerContainer);
}


function initCalendar(container, outerContainer, varName, form, inputName) {
	calendar = new Calendar(varName);
	calendar.setContainerID(container);
	calendar.form = form;
	calendar.inputName = inputName;
	calendar.outerContainer = document.getElementById(outerContainer);
	calendar.setCallback(calCallback);
	calendar.setCloseCallback(closeCalendar);
	document.write(calendar.getHTML());

	return calendar;
}