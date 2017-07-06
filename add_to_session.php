<?php
	$email=$_POST["email"];
	
	session_start();
	$_SESSION["email"]=$email;
	
	//add username to cookie
	setcookie("email",$email,time()+60*60*24*30);
?>