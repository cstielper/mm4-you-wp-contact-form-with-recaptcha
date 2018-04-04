<?php
$options = get_option( 'mm4-you-wp-contact-form-with-recaptcha-options', array() );

if(!$_POST) {
	echo 'This page cannot be accessed directly.';
	exit();
}
	
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$recipients = strip_tags($options["to_address"]);
	//$recipients = 'cstielper@mm4solutions.com';
	$email_from = strip_tags($options["from_address"]);
	$subject = strip_tags($options["subject_line"]);
	$secret_key = strip_tags($options['recaptcha_private_key']);
	$captcha = $_POST['g-recaptcha-response'];
	
	$name = strip_tags($_POST["first-name"]);
	$email= strip_tags($_POST["email-address"]);
	$phone = strip_tags($_POST["primary-phone"]);
	$message = strip_tags($_POST["message"]);
	
	if(!$captcha){
		echo 'Please go back and check the spam protection checkbox.';
		exit();
	}
	
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);

	$message="Name: " . $name . "<br>" . "Email: " . $email . "<br>" . "Phone: " . $phone . "<br>" . "Message: " . $message;

	$headers = array("From: Online Contact Form Submission <" . $email_from . ">", "Content-Type: text/html; charset=UTF-8");
	
	if($response.success == false) {
		echo 'We\'re sorry, but you appear to be a spambot.';
		exit();
	} else {
		//echo 'Success';
		wp_mail( $recipients, $subject, $message, $headers );
	}
}

?>