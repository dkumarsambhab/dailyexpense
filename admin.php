<?php
	class admin
	{
		private $id;
		private $name;
		private $email;
		private $pass;
		private $phone;
		
		function setId($id)
		{
        	$this->id= $id;
      	}      
		function getId()
		{
			return $this->id;
		}
		
		function setName($name)
		{
        	$this->name= $name;
      	}      
		function getName()
		{
			return $this->name;
		}
		
		function setEmail($email)
		{
        	$this->email= $email;
      	}      
		function getEmail()
		{
			return $this->email;
		}
		
		function setPass($pass)
		{
        	$this->pass= $pass;
      	}      
		function getPass()
		{
			return $this->pass;
		}
		
		function setPhone($phone)
		{
        	$this->phone= $phone;
      	}      
		function getPhone()
		{
			return $this->phone;
		}
	}
?>