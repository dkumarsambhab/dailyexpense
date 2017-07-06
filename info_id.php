<?php
	class info_id
	{		
		private $id;
		private $info_id;
		
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
	}
?>