# WordPress Simple Contact Form Plugin With Google ReCAPTCHA Integration
Version: 3.0

Follow the steps below to include/deploy this plugin with your WordPress theme:

1. Add all files to a directory in your theme using the following structure: /plugins/mm4-you-contact-form/
2. Include the mm4-you-cf.php file in your themes functions.php file (EX: include_once( get_stylesheet_directory() . '/plugins/mm4-you-contact-form/mm4-you-cf.php' );)

## Plugin Options
Once you have successfully included the plugin in your theme, you should see a menu item on your dashboard called "Contact Forms." Click on this to configure the following options:

1. Email address(es) the form should submit to
2. Subject line of the email that is sent with the form
3. Page ID number of the "Thank You" page
4. Fields to enter your public and private ReCAPTCHA API keys. These keys can be obtained at [here](https://www.google.com/recaptcha/admin)

## Outputting the Form in Your Template Files
You can use the following code to output the contact form into your page/post template files:

~~~~
<?php
	if(function_exists( 'mm4_you_contact_form' )): mm4_you_contact_form(); endif;
?>
~~~~

## Additional Notes
This form will output a simple contact form with Name, Email, Phone, and Comments fields. If additional fields are needed, you will need to edit the "mm4_you_contact_form" function in the [mm4-you-cf.php](https://github.com/cstielper/mm4-you-wp-contact-form-with-recaptcha/blob/master/mm4-you-cf.php) file to include your additional fields as well as the [contact.php](https://github.com/cstielper/mm4-you-wp-contact-form-with-recaptcha/blob/master/inc/contact.php) file to include your new fields in the email that is sent. This form uses the [MM4 You Javascript Form Validator](https://github.com/cstielper/mm4-you-js-form-validator). Please see its documentation to properly format your HTML for use with Javascript validation.