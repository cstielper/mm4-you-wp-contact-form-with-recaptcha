<?php
/*
Plugin Name: MM4 You Contact Form
Description: Contact form plugin with Google ReCAPTCHA integration for use on WordPress sites. Built with help from: https://gist.github.com/annalinneajohansson/5290405
Version: 3.0
Author: Chris Stielper
License: GPL
*/

// Setup the options page for our plugin.
add_action('admin_menu', 'mm4_you_cf_add_gcf_interface');
function mm4_you_cf_add_gcf_interface() {
	add_menu_page( 'Contact Form Settings', 'Contact Forms', 'manage_options', 'mm4-you-contact-form-options', 'mm4_you_cf_options', 'dashicons-edit' );
}

// Setup settings groups and fields
add_action( 'admin_init', 'mm4_you_cf_admin_init' );
function mm4_you_cf_admin_init() {
  /* 
	 * http://codex.wordpress.org/Function_Reference/register_setting
	 * register_setting( $option_group, $option_name, $sanitize_callback );
	 * The second argument ($option_name) is the option name. It’s the one we use with functions like get_option() and update_option()
	 * */
  	# With input validation:
  	# register_setting( 'my-settings-group', 'my-plugin-settings', 'my_settings_validate_and_sanitize' );    
  	register_setting( 'mm4-you-cf-settings-group', 'mm4-you-cf-settings' );
	
  	/* 
	 * http://codex.wordpress.org/Function_Reference/add_settings_section
	 * add_settings_section( $id, $title, $callback, $page ); 
	 * */	 
  	add_settings_section( 'basic-form-settings', __( 'Basic Form Settings' ), 'mm4_you_cf_section_1_callback', 'mm4-you-contact-form-options' );
	add_settings_section( 'recaptcha-settings', __( 'ReCAPTCHA Settings' ), 'mm4_you_cf_section_2_callback', 'mm4-you-contact-form-options' );
	
	/* 
	 * http://codex.wordpress.org/Function_Reference/add_settings_field
	 * add_settings_field( $id, $title, $callback, $page, $section, $args );
	 * */
	add_settings_field( 'form-email-to', __( 'Email address(es) for form submission (separate multiple email addresses with a comma):' ), 'email_to_callback', 'mm4-you-contact-form-options', 'basic-form-settings' );
	add_settings_field( 'form-subject', __( 'Subject line for form submission:' ), 'subject_line_callback', 'mm4-you-contact-form-options', 'basic-form-settings' );
	add_settings_field( 'form-email-from', __( 'Email address that the form should come from:' ), 'email_from_callback', 'mm4-you-contact-form-options', 'basic-form-settings' );
	add_settings_field( 'form-redirect', __( 'Enter the page ID of the contact form "Thank You" page. This is the page users will see after the form is submitted:' ), 'thank_you_page_callback', 'mm4-you-contact-form-options', 'basic-form-settings' );
	
	add_settings_field( 'recaptcha-public-key', __( 'ReCAPTCHA public key:' ), 'recaptcha_public_key_callback', 'mm4-you-contact-form-options', 'recaptcha-settings' );
	add_settings_field( 'recaptcha-private-key', __( 'ReCAPTCHA private key:' ), 'recaptcha_private_key_callback', 'mm4-you-contact-form-options', 'recaptcha-settings' );
	
}

function mm4_you_cf_options() { ?>
	<div class="wrap">
		<h2>Contact Form Settings</h2>
		<form method="POST" action="options.php">
			<?php settings_fields('mm4-you-cf-settings-group'); ?>
			<?php do_settings_sections('mm4-you-contact-form-options'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php }

/*
* THE SECTIONS
* Hint: You can omit using add_settings_field() and instead
* directly put the input fields into the sections.
* */
function mm4_you_cf_section_1_callback() {
	_e( '' ); ?>
<?php }

function mm4_you_cf_section_2_callback() {
	_e( '' );
}

// The fields
function email_to_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "form-email-to";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

function subject_line_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "form-subject";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

function email_from_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "form-email-from";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

function thank_you_page_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "form-thank-you";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

function recaptcha_public_key_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "recaptcha-public-key";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

function recaptcha_private_key_callback() {
	$settings = (array) get_option( 'mm4-you-cf-settings' );
	$field = "recaptcha-private-key";
	$value = esc_attr( $settings[$field] );
	echo "<input type='text' name='mm4-you-cf-settings[$field]' value='$value' />";
}

// Grab the settings from our options page
// Include the ReCAPTCHA library and JS validation
// Markup our form
function mm4_you_contact_form() {
	wp_enqueue_script( 'mm4-recaptcha', '//www.google.com/recaptcha/api.js', array(), NULL, TRUE );
	wp_enqueue_script('mm4-you-validate', get_template_directory_uri() . '/plugins/mm4-you-contact-form/js/min/mm4-you-validate-min.js', array(), NULL, TRUE );

	$options_arr = get_option('mm4-you-cf-settings');
	$subject_line = $options_arr['form-subject'];
	$public_key = $options_arr['recaptcha-public-key'];
	$form_action = get_permalink($options_arr['form-thank-you']); ?>

	<form name="contact-form" method="POST" action="<?php echo $form_action; ?>" novalidate>
		<input type="hidden" value="<?php echo $subject_line; ?>" name="subject" id="subject">
		<label for="first-name">
			<input type="text" name="first-name" id="first-name" class="required" data-error-label="First Name" placeholder="NAME">
		</label>
		<label for="email-address">
			<input type="email" name="email-address" id="email-address" class="required" data-error-label="Email" placeholder="EMAIL">
		</label>
		<label for="primary-phone">
			<input type="tel" name="primary-phone" id="primary-phone" class="required" data-error-label="Primary Phone" placeholder="PHONE">
		</label>
		<label for="comments">
			<textarea name="comments" id="comments" rows="6" placeholder="MESSAGE"></textarea>
		</label>
		<div class="g-recaptcha" data-sitekey="<?php echo $public_key; ?>"></div>
		<div class="msg-box"></div>
		<input type="submit" value="Submit">
	</form>
<?php }

// Add our server-side mail processing script to the "thank you" page
function mm4_you_cf_thank_you_page() {
	global $post;
	$ID = $post->ID;
	$options_arr = get_option('mm4-you-cf-settings');
	$ty_page = $options_arr['form-thank-you'];
	if( $ID == $ty_page ) {
		require ('inc/contact.php');
	}
}
add_action('wp_head', 'mm4_you_cf_thank_you_page');
?>