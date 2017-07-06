<?php
	if(isset($_POST["email"])&& isset($_POST["year"])){
		require_once "displayInfoHandler.php";
		$year=$_POST["year"];
		$email=$_POST["email"];
		
		$date=$year;
		
		$di=new displayInfoHandler();
		echo $di->getDateWiseExpense($email,$date);
	}
?>