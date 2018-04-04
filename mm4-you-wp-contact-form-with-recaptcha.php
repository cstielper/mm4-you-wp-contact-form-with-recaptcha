<?php
/*
	Plugin Name: MM4 You Contact Form
  Plugin URI: http://www.mm4solutions.com
  Description: Contact form plugin with Google ReCAPTCHA integration for use on WordPress sites.
  Version: 4.0.0
  Author: Chris Stielper
  License: GPL
*/

// Built with help from: https://gist.github.com/annalinneajohansson/5290405

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 *  Admin settings
 */
require_once( 'admin/mm4-you-wp-contact-form-with-recaptcha-admin-functions.php' );

/**
 *  Front-end
 */
require_once( 'public/mm4-you-wp-contact-form-with-recaptcha-public-functions.php' );