<?php
	
	require_once "user.php";
	require_once "userDao.php";

	class userLogin{
		
		function getPassByEmail($email)
		{
			$userDao=new userDao();
			
			return $userDao->getPassByEmail($email);
		}
	
	
	}
?>