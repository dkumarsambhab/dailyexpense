<?php
	require_once "userDao.php";
	
	class userUpdate{
		
		function update(user $usr)
		{
			$ud=new userDao();
			$ud->update($usr);
		}
	}
?>