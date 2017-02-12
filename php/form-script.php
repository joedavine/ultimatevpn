<?php

$haserror = false;
$sent = false;

if(isset($_POST['submitform'])) {
	$first_name = trim(htmlspecialchars($_POST['first-name'], ENT_QUOTES));
	$last_name = trim(htmlspecialchars($_POST['last-name'], ENT_QUOTES));
	$email = trim($_POST['email']);
	$telephone = trim(htmlspecialchars($_POST['telephone'], ENT_QUOTES));
	$DOB = trim(htmlspecialchars($_POST['dob'], ENT_QUOTES));
	$postcode = trim(htmlspecialchars($_POST['postcode'], ENT_QUOTES));

	$fieldsArray = array(
		'first name' => $first_name,
		'last name' => $last_name,
		'email' => $email,
		'telephone' => $telephone,
		'Date of Birth' => $DOB,
		'postcode' => $postcode,
	);

	$errorArray = array();

	foreach($fieldsArray as $key => $val) {
		switch($key) {
			case 'first name':
			case 'last name':
			case 'telephone':
			case 'Date of Birth':
			case 'postcode':
				if(empty($val)) {
					$hasError = true;
					$errorArray[$key] = " field was left empty.";
				}
				break;
			case 'email':
				if(!empty($email)) {
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$hasError = true;
						$errorArray[$key] = "Invalid email address was entered";
					} else {
						$email = filter_var($email, FILTER_SANITIZE_EMAIL);
					}
				}
				break;
		}
	}

	if($hasError !== true) {
		require 'php/PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();                                              // Set mailer to use SMTP
		$mail->Host = 'smtp-relay.sendinblue.com';  				          // Specify main and backup SMTP servers
		$mail->Port = 587;                                            // Set the SMTP port
		$mail->SMTPAuth = true;                                       // Enable SMTP authentication
		$mail->Username = 'petprotect@infinitewebsolutions.uk.com';   // SMTP username
		$mail->Password = 'D6xZv5s1kPqBjEcg';   			                // SMTP password
		$mail->SMTPSecure = 'tls';                                    // Enable encryption, 'ssl' also accepted

		$mail->From = 'pet_quotes@eqba.uk';
		$mail->FromName = 'Protected Pet Website';
		$mail->addAddress('mb@eqba.uk');     		  // Add a recipient

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Protected Pet Quote Enquiry';
		$mail->Body    = "<html><body>
											First Name: $first_name<br>
											Last Name: $last_name<br>
											Email: $email<br>
											Telephone: $telephone<br>
											Date of Birth: $DOB<br>
											Postcode: $postcode<br>
											</body></html>";

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$sent = true;
			unset($first_name);
			unset($last_name);
			unset($email);
			unset($telephone);
			unset($DOB);
			unset($postcode);
		}
	}

	if($sent === true) {
    	header('Location: http://www.protectedpet.co.uk/thank-you.php');
		exit;
	}
}

?>
