<?php
	
	if(isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["purpose"])){
		$name=$_POST["name"];
		$email=$_POST["email"];
		$purpose=$_POST["purpose"];
		
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 2;
		$mail->Host = 'mydailyexpense.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "info@mydailyexpense.com";
		$mail->Password = "kumar.bdn.123";
		$mail->setFrom('info@mydailyexpense.com', 'My Daily Expense');
		$mail->addReplyTo('support@mydailyexpense.com', 'My Daily Expense');//
		$mail->addAddress('support@mydailyexpense.com', 'My Daily Expense');//
		$mail->Subject = "Contact US from $email";	//Daily Expense Subject
		$mail->Body="PURPOSE : $purpose <br>".
					"NAME : $name <br>".
					"EMAIL : $email";
		//$mail->Body="PURPOSE : $purpose <br>".
					"NAME : $name <br>".
					"EMAIL : $email";
		$mail->AltBody = 'Welcome!!';
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
?>