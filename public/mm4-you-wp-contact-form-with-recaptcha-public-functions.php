<?php

function mm4_you_contact_form() {
	ob_start();
	$options = get_option( 'mm4-you-wp-contact-form-with-recaptcha-options', array() );
	
	wp_enqueue_script( 'mm4-recaptcha', '//www.google.com/recaptcha/api.js', NULL, NULL, TRUE );
	wp_enqueue_script('mm4-you-validate', plugin_dir_url( dirname(__FILE__) ) . 'public/js/min/mm4-you-validate-min.js', NULL, NULL, TRUE ); ?>

	<form name="mm4-contact-form" id="mm4-contact-form" method="POST" action="<?php echo get_permalink($options['thank_you_page_id']); ?>" novalidate>
		<label for="first-name">
			<input type="text" name="first-name" id="first-name" class="required" data-error-label="Name" placeholder="NAME">
		</label>
		<label for="email-address">
			<input type="email" name="email-address" id="email-address" class="required" data-error-label="Email" placeholder="EMAIL">
		</label>
		<label for="primary-phone">
			<input type="tel" name="primary-phone" id="primary-phone" class="required" data-error-label="Phone" placeholder="PHONE">
		</label>
		<label for="message">
			<textarea name="message" id="message" rows="6" placeholder="MESSAGE"></textarea>
		</label>
		<div class="g-recaptcha" data-sitekey="<?php echo $options['recaptcha_public_key']; ?>"></div>
		<div class="msg-box"></div>
		<input type="submit" value="Submit">
	</form>
<?php return ob_get_clean();
}

add_shortcode('mm4-cf', 'mm4_you_contact_form');

// Add our server-side mail processing script to the "thank you" page
function mm4_you_contact_form_thank_you_page() {
	global $post;
	$ID = $post->ID;
	$options = get_option( 'mm4-you-wp-contact-form-with-recaptcha-options', array() );
	$ty_page = $options['thank_you_page_id'];
	if( $ty_page && $ID == $ty_page ) {
		require __DIR__ . '/../admin/mm4-you-wp-contact-form-with-recaptcha-contact.php';
	}
}
add_action('wp', 'mm4_you_contact_form_thank_you_page', 1);