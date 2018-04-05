<?php
require_once( 'class-mm4-you-contact-options.php' );

$pages = array(
	'mm4-you-wp-contact-form-with-recaptcha-options'	=> array(
		'page_title'	=> __( 'MM4 Contact Form', 'mm4-you-wp-contact-form-with-recaptcha' ),
		'parent_slug' => 'options-general.php',
		'sections'		=> array(
			'section-one' => array(
				'title'			=> __( 'Delivery Settings', 'mm4-you-wp-contact-form-with-recaptcha' ),
				'fields' => array(
					'email-to'			=> array(
						'title'			=> __( 'To Address', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
						'text' => 'Email address(es) form submission is emailed to. Separate multiple email addresses with a comma.'
					),
					'subject'			=> array(
						'title'			=> __( 'Subject Line', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
						'text' => 'Subject line for form submission email.'
					),
				),
			),
			'section-two' => array(
				'title'			=> __( 'Sender Settings', 'mm4-you-wp-contact-form-with-recaptcha' ),
				'fields' => array(
					'email-from'			=> array(
						'title'			=> __( 'From Address', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
						'text' => 'Email address that the form submission should come from.'
					),
					'name-from'			=> array(
						'title'			=> __( 'From Name', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
						'text' => 'Name that the form submission should come from.'
					),
				),
			),
			'section-three' => array(
				'title'			=> __( 'WordPress Settings', 'mm4-you-wp-contact-form-with-recaptcha' ),
				'fields' => array(
					'thank-you-id'			=> array(
						'title'			=> __( 'Thank You page ID', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
						'text' => 'Enter the page ID of the contact form "Thank You" page.'
					),
				),
			),
			'section-four' => array(
				'title'			=> __( 'ReCAPTCHA Settings', 'mm4-you-wp-contact-form-with-recaptcha' ),
				'fields' => array(
					'public-key'			=> array(
						'title'			=> __( 'ReCAPTCHA public key:', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
					),
					'private-key'			=> array(
						'title'			=> __( 'ReCAPTCHA private key:', 'mm4-you-wp-contact-form-with-recaptcha' ),
						'type'			=> 'text',
					),
				),
			),
		),
	),
);
$option_page = new MM4YouContactOptionsPage( $pages );