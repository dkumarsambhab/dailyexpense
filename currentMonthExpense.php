<?php
	require_once "displayInfoHandler.php";
	
	$di=new displayInfoHandler();
	echo $di->getCurrentMonthExpense($_POST["email"]);
?>