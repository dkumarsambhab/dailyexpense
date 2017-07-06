<?php
	if(isset($_POST["email"]) && isset($_POST["f_y"]) && isset($_POST["t_y"])){
		require_once "displayInfoHandler.php";
		$email=$_POST["email"];
		$f_y=$_POST["f_y"];
		$t_y=$_POST["t_y"];
		
		$from_date=$f_y;
		$to_date=$t_y;
		
		$di=new displayInfoHandler();
		echo $di->getBetweenDateExpense($email,$from_date,$to_date);
	}
?>