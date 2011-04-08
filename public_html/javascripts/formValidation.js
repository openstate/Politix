window.addEvent('domready', function() {
	// Register error handlers
	$$('.defErrorHandler').each(function(el) {
		el.errorElement = function(type) { return $('_err_' + this.name + '_' + type); }
	});
	$$('.idErrorHandler').each(function(el) {
		el.errorElement = function(type) { return $('_err_' + this.id + '_' + type); }
	});

	// Default validation methods
	$V('required', 'notWhitespace', 'required');
	$V('required_select', 'notEmpty', 'required');
	$V('email', 'isEmail', 'invalid');
	$V('email_optional', 'isEmailOptional', 'invalid');

	// Add useful validation methods here (prefix classname with 'vld_' to prevent clashes)
});

function $V(klass, method, element) {
	$$('.vld_' + klass).each(function(el) {
		el.addEvent('validate', function(_) { _(Validator[method](this.value), element); });
	});	
}

// JS Helper Functions
function Validator() {}

Validator.notEmpty = function(value) {
	return '' != value;
}

Validator.notWhitespace = function(value) {
	return value.search(/\S+/) >= 0;
}

Validator.isEmail = function(value) {
	return value.search(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{}|~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/) >= 0;  //'
}

Validator.isEmailOptional = function(value) {
	return !Validator.notWhitespace(value) || Validator.isEmail(value);
}

// Default clearErrors implementation
function clearErrors() {
	$ES('span.error').each(function(el) {
		el.style.display = 'none';
	});
}

// Validation framework
function validate(form) {
	var maySubmit = true;
	$ES('input,select,textarea', form).each(function(el) {
		if (!el.disabled) {
			el.fireEvent('validate', function(validates, type) {
				if (!validates) {
					var error;
					if ($defined(el.errorElement)) {
						error = el.errorElement(type);
					} else {
						while (el = el.getNext()) {
							if ('span' == el.getTag() && el.hasClass('error')) {
								error = el;
								break;
							}
						}
					}
					if (error) error.style.display = '';
				}
				maySubmit = maySubmit && validates;
			});
		}
	});
	return maySubmit;
}
