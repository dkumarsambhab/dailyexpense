<?php
	require_once "userUpdate.php";
	require_once "user.php";
	
	$uu=new userUpdate();
	$u=new user();
	
	$name=$_POST["name"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$pass=$_POST["pass"];
	
	$u->setName($name);
	$u->setEmail($email);
	$u->setPhone($phone);
	$u->setPass($pass);
	
	$uu->update($u);
?>