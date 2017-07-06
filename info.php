<?php
	class info
	{
		private $id;
		private $info_id;
		private $email;
		private $date1;
		private $price;
		private $purpose;
		
		function setId($id)
		{
        	$this->id= $id;
      	}      
		function getId()
		{
			return $this->id;
		}
		
		function setInfo_Id($info_id)
		{
        	$this->info_id= $info_id;
      	}      
		function getInfo_Id()
		{
			return $this->info_id;
		}
		
		function setEmail($email)
		{
        	$this->email= $email;
      	}      
		function getEmail()
		{
			return $this->email;
		}
		
		function setDate($date)
		{
        	$this->date1= $date;
      	}      
		function getDate()
		{
			return $this->date1;
		}
		
		function setPrice($price)
		{
        	$this->price= $price;
      	}      
		function getPrice()
		{
			return $this->price;
		}
		
		function setPurpose($purpose)
		{
        	$this->purpose= $purpose;
      	}      
		function getPurpose()
		{
			return $this->purpose;
		}
	}
?>