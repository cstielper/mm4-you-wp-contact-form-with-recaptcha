<?php
$options = get_option( 'mm4-you-wp-contact-form-with-recaptcha-options', array() );

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$recipients = $options["to_address"];
	//$recipients = 'cstielper@mm4solutions.com';
	$email_from = $options["from_address"];
	$name_from = $options["from_name"];
	$subject = $options["subject_line"];
	$secret_key = $options['recaptcha_private_key'];
	$captcha = $_POST['g-recaptcha-response'];
	
	$name = stripslashes_deep(sanitize_text_field($_POST["first-name"]));
	$email= stripslashes_deep(sanitize_email($_POST["email-address"]));
	$phone = stripslashes_deep(sanitize_text_field($_POST["primary-phone"]));
	$message = stripslashes_deep(wpautop(esc_textarea($_POST["message"])));
	
	if(!$captcha){
		output_error( 'Please go back and check the spam protection checkbox.' );
		exit();
	}
	
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);

	$message = "
		<!DOCTYPE html>
		<html>
			<head>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<meta http-equiv='X-UA-Compatible' content='ie=edge'>
			</head>
			<body>
				<div style='background-color: #f7f7f7; font-family: sans-serif; padding: 20px;'>
					<h3>You have received a form submission:</h3>	
					<em>Name:</em> $name<br>
					<em>Email:</em> $email<br>
					<em>Phone:</em> $phone<br>
					<br>
					$message
				</div>
			</body>
		</html>
	";

	$headers[] = 'From: ' . $name_from . ' <' . $email_from . '>' . "\r\n";
	$headers[] = 'MIME-Version: 1.0' . "\r\n";
  $headers[] = 'Content-type: text/html; charset="UTF-8' . "\r\n";
	
	if($response.success == false) {
		output_error( 'We\'re sorry, but you appear to be a spambot.' );
		exit();
	} else {
		wp_mail( $recipients, $subject, $message, $headers );
	}
} else {
	output_error( 'We\'re sorry, but this page cannot be accessed directly.' );
	exit();
}

function output_error( $error ) { ?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta http-equiv='X-UA-Compatible' content='ie=edge'>
			<title>Error</title>
		</head>
		<body style='background-color: #ececec; font-family: sans-serif; padding: 20px;'>
			<div>
				<h3><?php echo $error; ?></h3>	
			</div>
		</body>
	</html>
<?php }