<?php
	require "info_idDao.php";
	
	class info_Id_Data{
		
		function insertData($info_id)
		{
			$dao=new info_idDao();
			$dao->insertData($info_id);
		}
		
		function getData()
		{
			$dao=new info_idDao();
			return $dao->getData();			 
		}
		
	}
?>