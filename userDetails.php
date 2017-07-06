<?php
	require_once "userDao.php";
	require_once "user.php";
	
	$email=$_POST["email"];
	
	$ud=new userDao();
	$user=$ud->getUserDetails($email);
	
	$str="";
	$name=$user->getName();
	$pass=$user->getPass();
	$phone=$user->getPhone();
	
	$str=$str.'{"name":"'.$name.'","pass":"'.$pass.'","phone":'.$phone.'}';
	
	echo '{"info":['.$str.']}';
?>