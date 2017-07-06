<?php
	require_once "user.php";
	require_once "DataBaseDao.php";

	class userDao
	{
		private $conn;
		
		function verifyName($name){
			return preg_replace("/[^a-zA-Z ]/","",$name);
		}
		function verifyEmail($email){
			return preg_replace("/[^0-9a-zA-Z.@_]/","",$email);
		}
		function verifyPassword($password){
			return preg_replace("/[^0-9a-zA-Z.@_ ]/","",$password);
		}
		function verifyPhone($phone){
			return preg_replace("/[^0-9]/","",$phone);
		}
		
		function validateEmail($email){
			return filter_var($email,FILTER_VALIDATE_EMAIL);
		}
		
		function insert(user $usr)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$id=0;
			$name=$this->verifyName($usr->getName());
			$email=$this->validateEmail($this->verifyEmail($usr->getEmail()));
			$pass=$this->verifyPassword($usr->getPass());
			$phone=$this->verifyPhone($usr->getPhone());
			
			$sql="insert into user(id,name,email,password,phone) values(?,?,?,?,?)";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("issss", $id,$name,$email,$pass,$phone);
			 
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
		
		function update(user $usr)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$id=0;
			$name=$this->verifyName($usr->getName());
			$email=$this->validateEmail($this->verifyEmail($usr->getEmail()));
			$pass=$this->verifyPassword($usr->getPass());
			$phone=$this->verifyPhone($usr->getPhone());
						
			$sql = "update user set phone=?,password=? where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("sss", $phone,$pass,$email);
			 
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
		
		function getPassByEmail($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
						
			$sql="select password from user where email=?";
			
			$email=$this->validateEmail($this->verifyEmail($email));
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s", $email);
			 
				// Execute the statement.
				$stmt->execute();
				//return $stmt->num_rows;
				$stmt->store_result();
				
				
				// Get the variables from the query.
				$stmt->bind_result($pass);
				
				
				// Fetch the data.
				$stmt->fetch();
								
				if($stmt->num_rows==1)
					return $pass;
				else
					return "Please Register First!!";
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		function getNameByEmail($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			
			$email=$this->validateEmail($this->verifyEmail($email));
						
			$sql="select name from user where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s", $email);
			 
				// Execute the statement.
				$stmt->execute();
				
				// Get the variables from the query.
				$stmt->bind_result($name);
				
				
				// Fetch the data.
				$stmt->fetch();
				
				return $name;
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
		}
		
		function getUserDetails($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			$user=new user();
			$email=$this->validateEmail($this->verifyEmail($email));
			
			$sql="select name,email,password,phone from user where email=?";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("s", $email);
			 
				// Execute the statement.
				$stmt->execute();
				
				// Get the variables from the query.
				$stmt->bind_result($name,$email,$pass,$phone);
				
				
				// Fetch the data.
				//$stmt->fetch();
				
				/* fetch values */
				while ($stmt->fetch()) {
					$user->setName($name);
					$user->setEmail($email);
					$user->setPass($pass);
					$user->setPhone($phone);
				}
			 
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			 
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
						
			return $user;
		}
		
		
		 
	
	
	}
	
	
?>
