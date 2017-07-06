<?php
	if(isset($_POST["email"])){
		require_once "userDao.php";
		
		$email=$_POST["email"];
		$name="Nothing";
		$ud=new userDao();
		$pass=$ud->getPassByEmail($email);
		
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 2;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "kumar.bdn.123@gmail.com";
		$mail->Password = "Kumar@bdn@123";
		$mail->setFrom('kumar.bdn.123@gmail.com', 'Daily Expense');
		$mail->addReplyTo($email, $name);//
		$mail->addAddress($email, $name);//
		$mail->Subject = 'Daily Expense Account Password Forgot';	//Daily Expense Subject
		$mail->Body="Password is ".$pass;	//
		$mail->AltBody = 'Welcome!!';
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
?>