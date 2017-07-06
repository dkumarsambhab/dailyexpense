<?php
	if(isset($_POST["email"])){
		require_once "displayInfoHandler.php";
		
		$di=new displayInfoHandler();
		echo $di->getTodayInfo($_POST["email"]);
	}
?>