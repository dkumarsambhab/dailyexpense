<?php
	require_once "infoDao.php";
	class displayInfoHandler
	{
		function getTodayExpense($email)
		{
			$id=new infoDao();
			return $id->getTodayExpense($email);
		}
		
		function getCurrentMonthExpense($email)
		{
			$id=new infoDao();
			return $id->getCurrentMonthExpense($email);
		}
		
		function getDateWiseExpense($email,$date)
		{
			$id=new infoDao();
			return $id->getDateWiseExpense($email,$date);
		}
		
		function getMonthWiseExpense($email,$date)
		{
			$id=new infoDao();
			return $id->getMonthWiseExpense($email,$date);
		}
		
		function getBetweenDateExpense($email,$from_date,$to_date)
		{
			$id=new infoDao();
			return $id->getBetweenDateExpense($email,$from_date,$to_date);
		}
		
		function getTodayInfo($email)
		{
			$id=new infoDao();
			return $id->getTodayInfo($email);		
		}
		
		function getInfo($info_id)
		{
			$id=new infoDao();
			return $id->getInfo($info_id);
		}
		
		function updateInfo($info_id,$purpose,$price)
		{
			$id=new infoDao();
			$id->updateInfo($info_id,$purpose,$price);		
		}
	}
?>