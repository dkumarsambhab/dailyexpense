<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="../jquery.js"></script>
<title>My Expense</title>
<link rel="shortcut icon" type="image/x-icon" href="../image.png" />
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
	#main{
		margin-left:35vw;
	}
	#error{
		color:#F00;
	}
	#success{
		color:#6F0;
	}
	#loading{
		left:50%;
		top:50%;
		position:fixed;
		display:none;
	}
</style>
<script>

function validateEmail(email)
{
	var expr=new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return expr.test(email);
}

$(document).ready(function(){
	//allow only numbers in phone
	$("#phone").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        	return false;
    	}
    });	
	//allow only a-z,A-Z and white space
	$("#name").keypress(function(e) {
       if((e.which<65 || e.which>90) && (e.which<97 || e.which>122) && e.which!=0 &&e.which!=32 && e.which != 8)
			return false;
		//alert(e.which);
    });
	
	//allow only a-z A-Z 0-9 . @ _ and white space
	$("#pass").keypress(function(e) {
		if((e.which<65 || e.which>90) && (e.which<97 || e.which>122) && e.which!=0 &&e.which!=32 && e.which != 8 && (e.which < 48 || e.which > 57) && e.which!=46 && e.which!=64 && e.which!=95)
			return false;
    });
	
	$("#btn").click(function(e) {
       var name=$("#name").val();
	   var email=$("#email").val();
	   var pass=$("#pass").val();
	   var phone=$("#phone").val();
	   
	   if(name=="" || email=="" || pass=="" || phone=="")
	   {
		   //$("#error").val("All Fields are required!!");
		   document.getElementById("error").innerHTML="All Fields are required!!";
	   }
	   else if(phone.length!=10)
	   {
		   document.getElementById("error").innerHTML="Phone No should be of 10 digit!!";
	   }
	   else
	   {
		   if(validateEmail(email)){
		   $.ajax({			   
				method:"post",
				url:"../unique_email_id_check.php",
				data:{
					email:email	
				},
				
							beforeSend: function() {
								$("#loading").show();
							},
				
				error: function(jqXHR,textStatus,errorThrown){document.getElementById("error").innerHTML="Sorry!! There is a     				problem";$("#loading").hide();},
				success:function(data)
				{
					
					if(data=="OK")
					{
						$.ajax({
							method:'post',
							url:'../mail.php',
							data:{
								name:name,
								email:email,
								pass:pass,
								phone:phone,
							},
							beforeSend: function() {
								$("#loading").show();
							},
							
							error:function(jqXHR,textStatus,errorThrown){document.getElementById("error").innerHTML="Sorry!! There is		                              a problem";$("#loading").hide();},
							
							success:function(data)
							{
								$("#name").val("");
								$("#phone").val("");
								$("#pass").val("");
								$("#email").val("");
								$("#loading").hide();
								document.getElementById("success").innerHTML="Success!! Check Email to complete sign up process.";
							}
		   				});	//end of 2nd ajax method
					}//end of if
					else
					{
						$("#loading").hide();
						document.getElementById("error").innerHTML="Email is already registered!!";
					}
					
				}
			});//end of 1st ajax method
		   }
		   else
		   	$("#error").text("Check Email Format");
		   
	   }	// end of else 	
	   
    });	//end of click
});	// end of script
</script>
</head>

<body>
<?php
	if(isset($_SESSION["email"]))
	{
		header("Location: ../Main/");
		return;
	}
?>
<h1>My Expense Sign Up</h1>
<hr />
<br />
<div id="main">
<div>
Enter Name <br /><input type="text" name="name" id="name"/><br />
Enter Email <br /><input type="email" name="email" id="email"/><br />
Enter Password <br /><input type="password" name="pass"  id="pass"/><br />
Enter Phone <br /><input type="text" name="phone"  id="phone" maxlength="10"/><br />
</div>
<div id="loading"><img src="../loading.GIF" /></div>
<div id="error"></div>
<div id="success"></div>
<button id="btn">Sign Up</button>
<button onclick="location.href='../'">Home</button>
</div>
</body>
</html>