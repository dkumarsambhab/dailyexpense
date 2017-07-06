<?php
	if(isset($_POST["email"])){
		require_once "UserLogin.php";
		
		$ul=new userLogin();
		$email=$_POST["email"];
		
		echo $ul->getPassByEmail($email);
	}
?>