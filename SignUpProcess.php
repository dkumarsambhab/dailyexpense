<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Expense</title>
<link rel="shortcut icon" type="image/x-icon" href="image.png" />
</head>

<body>
<?php

	require_once "UserRegistration.php";
	require_once "signup_tempDao.php";
	
	//check whether fields are blank or not??	
	if(empty($_GET["name"]) || empty($_GET["email"]) ||empty($_GET["pass"]) ||empty($_GET["phone"]))
	{
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		return;
	}
		
	
	$name=$_GET["name"];
	$email=$_GET["email"];
	$pass=$_GET["pass"];
	$phone=$_GET["phone"];	
	
	//check email format
	if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		return;
	}
	
	//check phone no format
	if (filter_var($phone, FILTER_VALIDATE_INT)==false || strlen($phone)!=10) {
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		return;
	}
	//check name format
	if (!preg_match('/^[A-Za-z -]*$/', $name)) {
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		return;
	}
	//check password format
	if (!preg_match('/^[A-Za-z0-9_.@ -]*$/', $pass)) {
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		return;
	}
	
	$std=new signup_tempDao();
	if($std->isEmailSignedUp($email))
	{
		if($std->isEmailNew($email))
		{
			$ur=new userRegistration();
			$ur->addUser($name,$email,$pass,$phone);
			
			//delete it from temp table
			$std->delete($email);
			
			echo "<script>alert('Registration Successful!!'); location.href='login.php';</script>";
		}
		else
		{
			echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Please Go Through the SignUP Process!!'); location.href='login.php';</script>";
	}
	
	
?>

</body>
</html>