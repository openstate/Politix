var DaysInMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var MonthNames = new Array('januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december');
var DayNames = new Array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');

function Calendar(varname, selDay, selMonth, selYear, currMonth, currYear) {
	this.container = null;
	this.closeCallback = null;
	this.closeParam = null;
	this.selCallback = null;
	this.today = new Date();
	this.varname = varname;

	this.minYear = null;
	this.maxYear = null;

	if (currMonth==null)
		this.currMonth = this.today.getMonth();
	else
		this.currMonth = currMonth;

	if (currYear==null)
		this.currYear = this.today.getFullYear();
	else
		this.currYear = currYear;

	if (selDay==null || selMonth==null || selYear==null) {
		this.selDay   = null;
		this.selMonth = null;
		this.selYear  = null;
		this.selToday = false;
	} else {
		this.selDay   = selDay;
		this.selMonth = selMonth-1;
		this.selYear  = selYear;
		this.selToday = selDay==this.today.getDate() && this.selMonth==this.currMonth && selYear==this.currYear;
	}

	this.setContainerID = function(containerID) {
		this.containerID = containerID
		this.container = document.getElementById(containerID);
	}

	this.setCallback = function(callback) {
		this.selCallback = callback;
	}

	this.setCloseCallback = function(callback, param) {
		this.closeCallback = callback;
		this.closeParam = param;
	}

	this.showDayInfo = function(dayNumber, day, month, year) {
		document.getElementById(this.container.id+'_showDate').innerHTML = DayNames[dayNumber] + ' ' + day + ' ' + MonthNames[month] + ' ' + year;
	}

	this.hideDayInfo = function() {
		document.getElementById(this.container.id+'_showDate').innerHTML = '&nbsp;';
	}

	this.selectMonth = function(month, year) {
		if ((this.minYear != null && year < this.minYear) || (this.maxYear != null && year > this.maxYear))
			return;
		this.currMonth = month-1;
		this.currYear = year;
		this.container.innerHTML = this.getHTML();
	}

	this.selectFullDay = function(day, month, year) {
		if (this.selDay!=null && this.selMonth==this.currMonth && this.selYear==this.currYear) {
			selTD = document.getElementById(this.container.id+'_day'+this.selDay);
			if (this.selToday) {
				selTD.className = 'calendarToday';
			} else {
				selTD.className = 'calendarDay';
			}
		}
		this.selDay   = day;
		this.selMonth = month-1;
		this.selYear  = year;
		if (this.selMonth==this.currMonth && this.selYear==this.currYear) {
			selTD = document.getElementById(this.container.id+'_day'+this.selDay);
			if (selTD!=null) {
				this.selToday = selTD.className == 'calendarToday';
				selTD.className = 'calendarSelected';
			}
		} else {
			this.selToday = false;
		}

		if (month-1!=this.currMonth || year!=this.currYear) {
			this.selectMonth(this.selMonth+1, this.selYear);
		}

		if (this.selCallback!=null)
			this.selCallback(day,month,year,this);

	}

	this.selectDay = function(day) {
		this.selectFullDay(day, this.currMonth+1, this.currYear);
//		document.getElementById(this.varname+'_caldebug').innerHTML = 'Closing...';
		this.closeCalendar();
	}

	this.closeCalendar = function() {
		if (this.closeCallback!=null) {
//			document.getElementById(this.varname+'_caldebug').innerHTML = 'Calling back...'+this.closeParam;
			this.closeCallback(this, this.closeParam);
		} else {
//			document.getElementById(this.varname+'_caldebug').innerHTML = 'No callback.';
		}
	}

	this.getHTML = function() {
		var leapYear = ((this.currYear%4)==0 && ((this.currYear%400)==0 || (this.currYear%100)!=0))? 1 : 0;
		var numDays = DaysInMonth[this.currMonth];
		if (this.currMonth==1) numDays+= leapYear;
		var startDate = new Date();
		startDate.setFullYear(this.currYear, this.currMonth, 1);
		var startDay = startDate.getUTCDay();

		var yearStart = new Date();
		yearStart.setFullYear(this.currYear, 0, 1);

		var temp = new Date();
		temp.setFullYear(this.currYear, this.currMonth-1, 1);
		if (this.minYear != null && temp.getFullYear() < this.minYear)
			prevMonth = null;
		else
			prevMonth = (temp.getMonth()+1)+','+temp.getFullYear();
		temp.setFullYear(this.currYear, this.currMonth+1, 1);
		if (this.maxYear != null && temp.getFullYear() > this.maxYear)
			nextMonth = null;
		else
			nextMonth = (temp.getMonth()+1)+','+temp.getFullYear();

		var startWeek = Math.floor((startDate.getTime()-yearStart.getTime()+((yearStart.getUTCDay()+6)%7)*86400000)/(7*86400000))+1;

		if (startDay==0) startDay = 7; // Make the week start on Monday

		var html =
//		'<span id="'+this.varname+'_caldebug">&nbsp;</span>'+
		'   <table border="1" class="calendar">\n'+
		'    <tr><td align="left" class="closeBtn"><a href="javascript:;" onclick="'+this.varname+'.closeCalendar()">X</a></td><td>'+(prevMonth != null ? '<a href="javascript:;" onclick="'+this.varname+'.selectMonth('+prevMonth+')">&lt;&lt;</a>' : '')+'</td><td colspan="5">'+MonthNames[this.currMonth]+' '+this.currYear+'</td><td>'+(nextMonth != null ? '<a href="javascript:;" onclick="'+this.varname+'.selectMonth('+nextMonth+')">&gt;&gt;</a>' : '')+'</td></tr>\n'+
		'    <tr>\n'+
		'     <td></td>\n'+
		'     <td width="17" class="calendarHeader">ma</td>\n'+
		'     <td width="17" class="calendarHeader">di</td>\n'+
		'     <td width="17" class="calendarHeader">wo</td>\n'+
		'     <td width="17" class="calendarHeader">do</td>\n'+
		'     <td width="17" class="calendarHeader">vr</td>\n'+
		'     <td width="17" class="calendarHeader">za</td>\n'+
		'     <td width="17" class="calendarHeader">zo</td>\n'+
		'    </tr>\n';
		// Empty cells up to the start of the month
		var currWeek = startWeek;
		var currDay = 2-startDay;
		var day;
		while (currDay<=numDays) {
			// Start week
			html = html+'<tr class="calendarWeek"><td class="calendarHeader">week '+currWeek+'</td>\n';
			// Loop through days
			for (day=1;day<=7;day++) {
				if (currDay<1 || currDay>numDays)
					html = html+'<td class="calendarEmpty"></td>\n';  // Filler
				else {
					var className;
					if (currDay==this.selDay && this.currMonth==this.selMonth && this.currYear==this.selYear)
						className = 'calendarSelected';
					else if (currDay==this.today.getDate() && this.currMonth==this.today.getMonth() && this.currYear==this.today.getFullYear())
						className = 'calendarToday';
					else
						className = 'calendarDay';
					html = html+'<td id="'+this.container.id+'_day'+currDay+'" class="'+className+'" onmouseout="'+this.varname+'.hideDayInfo()" onmouseover="'+this.varname+'.showDayInfo('+(day-1)+','+currDay+','+this.currMonth+','+this.currYear+')" onclick="'+this.varname+'.selectDay('+currDay+')">'+currDay+'</td>\n';
				}
				currDay++;
			}
			currWeek++;
			html = html+'</tr>\n';
		}
		html = html+'<tr><td colspan="8" align="right"><b><span id="'+this.container.id+'_showDate" style="white-space:nowrap">&nbsp;</span></b></td></tr></table>';
		return html;
	}
}
