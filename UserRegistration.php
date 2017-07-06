<?php

	require_once "user.php";
	require_once "userDao.php";

	class userRegistration{
		
		function addUser($name,$email,$pass,$phone){
			
			$userDao=new userDao();
			$user=new user();
			
			$user->setName($name);
			$user->setEmail($email);
			$user->setPass($pass);
			$user->setPhone($phone);
			
			$userDao->insert($user);
		}
		
		function getPassByEmail($email)
		{
			$userDao=new userDao();
			
			$userDao->getPassByEmail($email);
		}
	
	
	}
	
	
	
?>