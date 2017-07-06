<?php
	if(isset($_POST["email"])){
		require_once "DataBaseDao.php";
		
		$email=$_POST["email"];
		
		$db=new DataBaseDao();
		$conn=$db->getConnection();
					
		$sql = "select * from user where email='$email'";
		$result=mysqli_query($conn, $sql);
	
		if (mysqli_num_rows($result)==0) {		
	    	echo "OK";
			mysqli_close($conn);
		} else {
	    	echo "Email is already registered";
			mysqli_close($conn);
		}
	}
?>