<?php
	if(isset($_POST["email"]) && isset($_POST["price"]) && isset($_POST["purpose"])){
		require_once "infoDao.php";
		require_once "info.php";
		
		$email=$_POST["email"];
		$purpose=$_POST["purpose"];
		$price=$_POST["price"];
		
		$id=new infoDao();
		$in=new info();
		
		$in->setEmail($email);
		$in->setPurpose($purpose);
		$in->setPrice($price);
		
		$id->insert($in);
	}
	
?>