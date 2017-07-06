<?php
	require_once "userDao.php";
	class userDisplay
	{
		function getNameByEmail($email)
		{
			$u=new userDao();
			$name=$u->getNameByEmail($email);
			return $name;
		}
	}
?>