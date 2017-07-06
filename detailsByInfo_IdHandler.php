<?php
	if(isset($_POST["info_id"])){
		require_once "displayInfoHandler.php";
		
		$di=new displayInfoHandler();
		echo $di->getInfo($_POST["info_id"]);
	}
?>