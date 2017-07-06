<?php
	class DataBaseDao
	{
		function getConnection()
		{
			$servername="localhost";
			$username="mydailye_xpense";
			$password="kumar.bdn.123";
			$db="mydailye_kumar";
			$conn=mysqli_connect($servername,$username,$password,$db);
			
			if(!$conn)
			{
				die(mysqli_connect_error());
			}
			return $conn;
		}
		
	}
?>