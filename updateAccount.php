<?php
	
	session_start();
	if(!isset($_SESSION["email"]))
	{
		header("Location: ../Login/");
		return;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Expense</title>
<link rel="shortcut icon" type="image/x-icon" href="../image.png" />
<script src="../jquery.js"></script>
<style>
	h1{
		text-align:center;
		font-size:3vmax;
		font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
		font-style:oblique;
	}
	hr{
		margin-left:5vw;
		margin-right:5vw;
	}
	#container{
		text-align:center;		
	}
	#middle{
		font-size:2vmax;
	}	
	#error,#success{
		display:none;
	}
	#error{
		color:#F00;
	}
	#success{
		color:#0F0;
	}
	#loading{
		left:50%;
		top:50%;
		position:fixed;
		display:none;
	}
</style>
<script>
$(document).ready(function() {
	
	var email=$("#email").val();
	//default form fill up
	$.ajax({
		method:'post',
		url:'../userDetails.php',
		data:{
			email:email,
		},
		error:function(jqXHR,textStatus,errorThrown){$("#error").show();document.getElementById("error").innerHTML="Sorry!! There is a problem";},
		success:function(data)
		{
			//alert(data);
			var obj=JSON.parse(data);
			var name1=obj.info[0].name;
			var pass1=obj.info[0].pass;
			var phone1=obj.info[0].phone;
			
			$("#name").val(name1);
			$("#phone").val(phone1);
			$("#pass").val(pass1);
			$("#email2").val(email);
		}
	});	//end of ajax method
	
	
    //allow only numbers in phone
	$("#phone").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        	return false;
    	}
    });
	//log out
	$("#lout").click(function() {
        var r=confirm("Are You sure to logout??");
		if(r==true)
		{
			$.ajax({
				method:"post",
				url:"../logoutHandler.php",
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");},
				success: function(data)
				{
					location.href="../";
				}
			});
		}
    });//end of click event	
	
	//all fields are required
	$("#update").click(function() {
		var pass=$("#pass").val();
		var phone=$("#phone").val();
		var name=$("#name").val();
		
        if(phone=="" || pass=="")
		{
			$("#error").show();
			$("#success").hide();
			$("#error").text("All Fields are Required!!");
		}
		else
		{
			$("#error").hide();
			$("#success").show();
			
			$.ajax({
				method:"post",
				url:"../UserUpdateHandler.php",
				data:{
					email:email,
					pass:pass,
					name:name,
					phone:phone
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{
					$("#loading").hide();
					$("#success").text("Update is Successful!!");
				}
			});
		}
    });//end of click
});
</script>
</head>

<body>

<?php
		require_once "userDisplay.php";
		$ud=new userDisplay();
		$name=$ud->getNameByEmail($_SESSION["email"]);
?>
<h1><?php echo $name; ?></h1>
<hr />
<br />

<div id="container">

<button onclick="location.href='../Main/'">Home</button>
<button id="lout">Log Out</button><br /><br />

<div id="middle">
<table border="1" align="center">
<tr>
<th colspan="2">Update Information</th>
</tr>
<tr>
<td>Name</td>
<td><input type="text" id="name" value="" readonly size="25" /></td>
</tr>
<tr>
<td>Email</td>
<td><input type="text" id="email2" value="" readonly size="25" /></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" id="pass" size="25" /></td>
</tr>
<tr>
<td>Phone</td>
<td><input type="text" id="phone" maxlength="10" size="25" /></td>
</tr>
<tr>
<th colspan="2"><button id="update">Update</button></th>
</tr>
<tr>
<td id="error" colspan="2"></td>
</tr>
<tr>
<td id="success" colspan="2"></td>
</tr>
</table>
</div>
</div>
<div id="loading"><img src="../loading.GIF" />
<input type="hidden" id="email" value="<?php echo $_SESSION["email"] ?>" />
</body>
</html>