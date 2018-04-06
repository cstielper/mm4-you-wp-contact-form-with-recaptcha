# WordPress Simple Contact Form Plugin With Google ReCAPTCHA Integration

![Version 4.3.0](https://img.shields.io/badge/Version-4.3.0-brightgreen.svg)

## Installation

1. Clone this repo to your local machine
2. Zip the plugin folder and upload it through the WP Dashboard, or drag the plugin folder into the /wp-content/plugins/ directory
3. Activate the plugin from the "Plugins" screen in the WP Dashboard

## Plugin Options

1. Email address(es) the form should submit to
2. Subject line of the email that is sent with the form
3. Email address the form will come from
4. Name that the form will come from
5. Page ID number of the "Thank You" page
6. Fields to enter your public and private ReCAPTCHA API keys. These keys can be obtained at [here](https://www.google.com/recaptcha/admin)

## Outputting the Form
You can use the following shortcode to output the form:

~~~~
[mm4-cf]
~~~~

You can also output the form in a template file:

~~~~
<?php echo do_shortcode("[mm4-cf]"); ?>
~~~~

## Additional Notes
This form will output a simple contact form with Name, Email, Phone, and Message fields. If additional fields are needed, you will need to edit the "mm4_you_contact_form" function in the [public/mm4-you-wp-contact-form-with-recaptcha-public-functions.php](public/mm4-you-wp-contact-form-with-recaptcha-public-functions.php) file to include your additional fields as well as the [mm4-you-wp-contact-form-with-recaptcha-contact.php](admin/mm4-you-wp-contact-form-with-recaptcha-contact.php) file to include your new fields in the email that is sent. This form uses the [MM4 You Javascript Form Validator](https://github.com/cstielper/mm4-you-js-form-validator). Please see its documentation to properly format your HTML for use with Javascript validation.