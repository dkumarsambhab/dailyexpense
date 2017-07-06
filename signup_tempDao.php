<?php
	require_once "DataBaseDao.php";

	class signup_tempDao
	{
		private $conn;
		
		function verifyEmail($email){
			return preg_replace("/[^0-9a-zA-Z.@_]/","",$email);
		}
		function verifyPhone($phone){
			return preg_replace("/[^0-9]/","",$phone);
		}
		
		function validateEmail($email){
			return filter_var($email,FILTER_VALIDATE_EMAIL);
		}
		
		public function insert($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$id=0;
			$email=$this->validateEmail($this->verifyEmail($email));
			
			$sql = "INSERT INTO signup_temp(id,email)VALUES (?,?)";

			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("is",$id,$email);
			 
				// Execute the statement.
				$stmt->execute();
				
				echo "New record created successfully";
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		public function delete($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$email=$this->validateEmail($this->verifyEmail($email));
			
			$sql = "delete from signup_temp where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s",$email);
			 
				// Execute the statement.
				$stmt->execute();
				
				echo "Delete successfully";
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		public function isEmailNew($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$email=$this->validateEmail($this->verifyEmail($email));
			
			$sql = "select email from user where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s", $email);
			 
				// Execute the statement.
				$stmt->execute();
				
				//store result
				$stmt->store_result(); 
				
				//count the rows
				$count=$stmt->num_rows;
				
				
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
				
				if($count==1)
					return false;
				else
					return true;
				
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		public function isEmailSignedUp($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$email=$this->validateEmail($this->verifyEmail($email));
			
			$sql = "select email from signup_temp where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s", $email);
			 
				// Execute the statement.
				$stmt->execute();
				
				//store result
				$stmt->store_result(); 
				
				//count the rows
				$count=$stmt->num_rows;
				
				
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
				
				if($count==1)
					return true;
				else
					return false;
				
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
	}
	
	//$s=new signup_tempDao();
	//$s->g("dkumarsambhab@gmail.com");
	
	
	
?>
