(function() {
	/*******************************************************************************/
	// SET REQUIRED VARIABLES:
	// Error class to apply (defined in CSS)
	var errorClass = 'error';
	
	// Form "name" attribute that you want to pass to the validator
	// var form = document.forms['YOUR FORM NAME HERE'];
	var form = document.forms['contact-form'];

	// Message box where we want the errors to display.
	// If you have set your "form" variable correctly, you shouldn't have to change this.
	var msgs = document.querySelector('form[name="' + form.name + '"] .msg-box');
	
	// If you want to validate multiple forms, you can define them here:
	// var form2 = document.forms['YOUR FORM NAME HERE'];

	// var msgs2 = document.querySelector('form[name="' + form2.name + '"] .msg-box');

	/*******************************************************************************/

	// RUN VALIDATION ON SUBMIT BY PASSING IN OUR VARIABLES
	form.addEventListener('submit', function(event) {
		validateForm(this, msgs, event);
	});

	// If you want to validate multiple forms, add your additional listeners here:
	/*form2.addEventListener('submit', function(event) {
		validateForm(this, msgs2, event);
	});*/
	


	


	/***************** YOU SHOULD NOT HAVE TO EDIT ANYTHING BELOW THIS LINE !!!! *****************/
	// VALIDATE FORM:
	function validateForm(form, msgBox, e) {
		// Create an array to hold our required fields
		var required = [];
		// Create an array to hold our errors
		var errors = [];

		// Clear out our items/errors from any previous submissions and get rid of all error classes in the DOM to re-evaluate the form.
		required.length = 0;
		errors.length = 0;
		form.classList.remove(errorClass);
		msgBox.classList.remove(errorClass);

		var i;
		for(i = 0; i < form.length; i++) {
			form[i].classList.remove(errorClass);
		}
		
		var labels = form.getElementsByTagName('label');
		for(i = 0; i < labels.length; i++) {
			labels[i].classList.remove(errorClass);
		}

		// Grab all of the fields with the 'required' class in our form, and push them to 'required[]' using a string ('fields') to determine whether or not an element with the same name has already been added to the array (for checkbox/radio button groups).
		var requiredFields = form.getElementsByClassName('required');
		var fields = '';
		for(i = 0; i < requiredFields.length; i++ ) {
			var fieldName = requiredFields[i].name;

			// If the name of this field has not already been added to the "fields" string, then add it and push the element to required[], otherwise keep going.
			if(fields.indexOf(fieldName) === -1) {
				required.push([requiredFields[i]]);
			} else  {
				continue;
			}
			fields += ' ' + fieldName;
		}

		// At this point, we should have an array with a nested array for each required field, or the first required field in a checkbox/radio group:
		//console.log(required);

		// Loop through required[] and validate each field. If it is empty, push it to errors[].
		var checkboxes;
		var radioBtns;
		var checked;
		for(i = 0; i < required.length; i++) {
			if(required[i][0].type === 'checkbox') {
				// If we come to a checkbox in required[], reset our "checked" variable from any previous loops.
				checked = false;
				
				// Get its name, loop through the form and find if there are any checkboxes with that name checked.
				checkboxes = document.getElementsByName(required[i][0].name);
				for (var j = 0; j < checkboxes.length; j++) {
					// If there is a field checked, change our "checked" variable, stop the loop and move on... otherwise, keep going
					if(checkboxes[j].checked) {
						checked = true;
						break;
					} else {
						continue;
					}
				}
				// If there is not another field with this name checked after looping, push an error to errors[]
				if(checked === false) {
					errors.push([checkboxes[0].name, '<span>The <strong><em>' + checkboxes[0].getAttribute('data-error-label') + '</em></strong> field is required.</span>']);
				}
			} else if(required[i][0].type === 'radio') {
				// If we come to a radio button in required[], reset our "checked" variable from any previous loops.
				checked = false;

				// Get its name, loop through the form and find if there are any radio buttons with that name checked.
				radioBtns = document.getElementsByName(required[i][0].name);
				for (var k = 0; k < radioBtns.length; k++) {
					// If there is a field checked, change our "checked" variable, stop the loop and move on... otherwise, keep going
					if(radioBtns[k].checked) {
						checked = true;
						break;
					} else {
						continue;
					}
				}
				// If there is not another field with this name checked after looping, push an error to errors[]
				if(checked === false) {
					errors.push([radioBtns[0].name, '<span>The <strong><em>' + radioBtns[0].getAttribute('data-error-label') + '</em></strong> field is required.</span>']);
				}
			} else if(required[i][0].value === '') {
				errors.push([required[i][0].name, '<span>The <strong><em>' + required[i][0].getAttribute('data-error-label') + '</em></strong> field is required.</span>']);
			}
		}

		var captchaResponse = grecaptcha.getResponse();
		if(captchaResponse.length === 0) {
			errors.push(['recaptcha', '<span>The <strong><em>Anti-Spam</em></strong> field is required. Please check the box to continue.</span>']);
		}

		// At this point, we should have an array with a nested array for each required field that is empty.
		// The nested array contains the field "name" and the error to display
		//console.log(errors);

		// If the user has entered an email address in any input[type="email"], then to check to see if it follows an expected email pattern.
		var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;	
		for(i = 0; i < form.length; i++) {
			if(form[i].type === 'email' && form[i].value !== '' && !form[i].value.match(emailRegex)) {
				errors.push([form[i].name, '<span>Please enter a valid email address for the <strong><em>' + form[i].getAttribute('data-error-label') + '</em></strong> field.</span>']);
			}
		}

		// If there are errors in errors[], stop the form from submitting, loop through the errors to compile a list to output to our message box, and our errorClass to DOM elements
		if(errors.length > 0) {
			e.preventDefault();
			var error = '';
			for(i = 0; i < errors.length; i++) {
				error = error + errors[i][1];
				var element = document.getElementsByName(errors[i][0]);
				for(var l = 0; l < element.length; l++) {
					element[l].classList.add(errorClass);
					element[l].parentNode.classList.add(errorClass);
				}
				msgBox.innerHTML = error;
			}
			msgBox.classList.add(errorClass);
		}
		// Congratulations!
		// If you have made it this far, you should grab a nice cold beer because your form submission is valid.
		// You've earned it my friend.
	}
})();