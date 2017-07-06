<?php
	require_once "DataBaseDao.php";
	require_once "info_id.php";
	
	class info_idDao
	{
		private $conn;
		
		function verifyPhone($phone){	//because info_id and phone both contain only numbers
			return preg_replace("/[^0-9]/","",$phone);
		}
				
		function insertData($info_id)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$info_id=$this->verifyPhone($info_id);
			
			$sql = "update info_id set info_id=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("i", $info_id);
			 
				// Execute the statement.
				$stmt->execute();
				
				echo "Updated successfully";
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		function getData()
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$sql = "select info_id from info_id";
			$result=mysqli_query($this->conn, $sql);

			while($row=mysqli_fetch_assoc($result))
			{
				return $row["info_id"];
			}
			mysqli_close($this->conn);
		}
		
		
		
	}
?>
