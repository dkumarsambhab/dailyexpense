<?php
	if(isset($_POST["info_id"]) && isset($_POST["price"]) && isset($_POST["purpose"])){
		require_once "displayInfoHandler.php";
		$di=new displayInfoHandler();
		$di->updateInfo($_POST["info_id"],$_POST["purpose"],$_POST["price"]);
	}
?>