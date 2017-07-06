<?php

	require_once "DataBaseDao.php";
	require_once "info.php";
	require_once "Info_Id_Data.php";
	
	
	class infoDao
	{
		private $conn;
		
		function verifyPurpose($purpose){
			return preg_replace("/[^a-zA-Z' ]/","",$purpose);
		}
		function verifyEmail($email){
			return preg_replace("/[^0-9a-zA-Z.@_]/","",$email);
		}
		function verifyPrice($price){
			return preg_replace("/[^0-9.]/","",$price);
		}
		
		function validateEmail($email){
			return filter_var($email,FILTER_VALIDATE_EMAIL);
		}
		
		function insert(info $info)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();
			$iid=new info_Id_Data();
			
			$id=0;
			$info_id=$iid->getData()+1;
			$email=$this->validateEmail($this->verifyEmail($info->getEmail()));
			$price=$this->verifyPrice($info->getPrice());
			$purpose=$this->verifyPurpose($info->getPurpose());
			date_default_timezone_set("Asia/Kolkata");
			$date=date("Y-m-d");
			
			$iid->insertData($info_id); //update the table info_id
		 
			$sql = "INSERT INTO info VALUES (?,?,?,?,?,?)";
			
			if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("iissds", $id,$info_id,$email,$date,$price,$purpose);
			 
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
		
		function getTodayExpense($email)
		{
			$db=new DataBaseDao();
			$this->conn=$db->getConnection();	
			date_default_timezone_set("Asia/Kolkata");		
			$date=date("Y-m-d");
			$ans=0;
			$email=$this->validateEmail($this->verifyEmail($email));
			
			 $sql = "select sum(price) from info where email=? and date=?";
				
				if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("ss", $email,$date);
			 
				// Execute the statement.
				$stmt->execute();
				
				//store result
				$stmt->store_result(); 
				
				//count the rows
				$count=$stmt->num_rows;
				
				// Get the variables from the query.
				$stmt->bind_result($sum);
				
				
				// Fetch the data.
				$stmt->fetch();
				
				if($count>0 && $sum!=null)
					$ans=$sum;
				
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
				
				return $ans;
		}
			
			function getCurrentMonthExpense($email)
			{
				$db=new DataBaseDao();
				$this->conn=$db->getConnection();		
				date_default_timezone_set("Asia/Kolkata");	
				$date=date("m");
				$ans=0;
				$email=$this->validateEmail($this->verifyEmail($email));
				
				$sql = "select sum(price) from info where email=? and EXTRACT(MONTH FROM date)=?";
				 					
					if ($stmt = $this->conn->prepare($sql)) {
 
				// Bind the variables to the parameter as strings. 
				$stmt->bind_param("ss", $email,$date);
			 
				// Execute the statement.
				$stmt->execute();
				
				//store result
				$stmt->store_result(); 
				
				//count the rows
				$count=$stmt->num_rows;
				
				// Get the variables from the query.
				$stmt->bind_result($sum);
				
				
				// Fetch the data.
				$stmt->fetch();
				
				if($count>0 && $sum!=null)
					$ans=$sum;
				
				// Close the prepared statement.
				$stmt->close();
				mysqli_close($this->conn);
			}
			else{
				echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
				mysqli_close($this->conn);
			}
					
					return $ans;
				}
				
				function getDateWiseExpense($email,$date)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					$str="";
					$i=0;
					$email=$this->validateEmail($this->verifyEmail($email));
					
					 $sql = "select date,purpose,price from info where email='$email' and date='$date'";
					 $result=mysqli_query($this->conn,$sql);
			
						if($result)
						{
							$row_count=mysqli_num_rows($result);	//count the no of rows of data
							if($row_count>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									if($i==0){
										$str=$str.'{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}else{
										$str=$str.',{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}
								}
							}
							mysqli_close($this->conn);
						}
						else
						{
							echo mysqli_error($this->conn);
							mysqli_close($this->conn);
						}
						
						return '{"info":['.$str.']}';
				}
				
				function getMonthWiseExpense($email,$date)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					$str="";
					$i=0;
					$email=$this->validateEmail($this->verifyEmail($email));
					
					 $sql = "select date,purpose,price from info where email='$email' and date like '$date%'";
					 $result=mysqli_query($this->conn,$sql);
			
						if($result)
						{
							$row_count=mysqli_num_rows($result);	//count the no of rows of data
							if($row_count>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									if($i==0){
										$str=$str.'{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}else{
										$str=$str.',{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}
								}
							}
							mysqli_close($this->conn);
						}
						else
						{
							echo mysqli_error($this->conn);
							mysqli_close($this->conn);
						}
						
						return '{"info":['.$str.']}';
				}
				
				function getBetweenDateExpense($email,$from_date,$to_date)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					$str="";
					$i=0;
					$email=$this->validateEmail($this->verifyEmail($email));
					
					 $sql = "select date,purpose,price from info where email='$email' and date between '$from_date' and '$to_date' or date between '$to_date' and '$from_date'";
					 $result=mysqli_query($this->conn,$sql);
			
						if($result)
						{
							$row_count=mysqli_num_rows($result);	//count the no of rows of data
							if($row_count>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									if($i==0){
										$str=$str.'{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}else{
										$str=$str.',{"date1":"'.$row["date"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}
								}
							}
							mysqli_close($this->conn);
						}
						else
						{
							echo mysqli_error($this->conn);
							mysqli_close($this->conn);
						}
						
						return '{"info":['.$str.']}';
				}
				
				function getTodayInfo($email)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					date_default_timezone_set("Asia/Kolkata");		
					$date=date("Y-m-d");
					$str="";
					$i=0;
					$email=$this->validateEmail($this->verifyEmail($email));
					
					 $sql = "select info_id,purpose,price from info where email='$email' and date='$date'";
					 $result=mysqli_query($this->conn,$sql);
			
						if($result)
						{
							$row_count=mysqli_num_rows($result);	//count the no of rows of data
							if($row_count>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									if($i==0){
										$str=$str.'{"info_id":"'.$row["info_id"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}else{
										$str=$str.',{"info_id":"'.$row["info_id"].'","purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}
								}
							}
							mysqli_close($this->conn);
						}
						else
						{
							echo mysqli_error($this->conn);
							mysqli_close($this->conn);
						}
						
						return '{"info":['.$str.']}';
				}
				
				function getInfo($info_id)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					$str="";
					$i=0;
					
					 $sql = "select purpose,price from info where info_id=$info_id";
					 $result=mysqli_query($this->conn,$sql);
			
						if($result)
						{
							$row_count=mysqli_num_rows($result);	//count the no of rows of data
							if($row_count>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									if($i==0){
										$str=$str.'{"purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}else{
										$str=$str.',"purpose":"'.$row["purpose"].'","price":'.$row["price"].',"len":'.$row_count.'}';
										$i++;
									}
								}
							}
							mysqli_close($this->conn);
						}
						else
						{
							return mysqli_error($this->conn);
							mysqli_close($this->conn);
						}
						
						return '{"info":['.$str.']}';
				}
				
				function updateInfo($info_id,$purpose,$price)
				{
					$db=new DataBaseDao();
					$this->conn=$db->getConnection();
					
					$price=$this->verifyPrice($price);
					$purpose=$this->verifyPurpose($purpose);
					
					$sql = "update info set purpose=?,price=? where info_id=?";		
					
					if ($stmt = $this->conn->prepare($sql)) {
 
					// Bind the variables to the parameter as strings. 
					$stmt->bind_param("sdi", $purpose,$price,$info_id);
				 
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
				
	}
	
	$i=new infoDao();
	//echo $i->getCurrentMonthExpense("dkumarsambhab@gmail.com");
	//$email="dkumarsambhab@gmail.com";
	$price="50";
	$purpose="test1";
	/*$if=new info();
	$if->setEmail($email);
	$if->setPrice($price);
	$if->setPurpose($purpose);*/
	//$i->updateInfo(1552,$purpose,$price);
	
?>
