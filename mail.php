<?php
	
	if(isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["phone"])){
		$name=$_POST["name"];
		$email=$_POST["email"];
		$pass=$_POST["pass"];
		$phone=$_POST["phone"];
		
		require_once "signup_tempDao.php";
		$std=new signup_tempDao();
		$std->insert($email);
		
		
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
		$mail->addReplyTo($email, $name);//
		$mail->addAddress($email, $name);//
		$mail->Subject = 'Daily Expense Account Activation';	//Daily Expense Subject
		$mail->Body="<a href='https://www.mydailyexpense.com/SignUpProcess.php?name=$name&email=$email&pass=$pass&phone=$phone'>Activate</a>";	//
		$mail->AltBody = 'Welcome!!';
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
?>