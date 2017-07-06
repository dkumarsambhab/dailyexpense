<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Expense</title>
<link rel="shortcut icon" type="image/x-icon" href="image.png" />
<script src="jquery.js"></script>
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
		text-align:center;
		font-size:2.5vmax;
	}
	#contact{
		cursor:pointer;
		text-decoration:underline;
		color:#00F;		
	}
	#contact:visited{
		color:#00F;
	}
	#contact:link{
		color:#00F;
	}
	#contact:hover{
		color:#00F;
	}
	#contact:active{
		color:#F00;
	}
	#c{
		display:none;
		margin-top:2vh;
	}
	#success{
		color:#0F0;
	}
	#error{
		color:#F00;
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

$(document).ready(function(e) {
    $("#contact").click(function(e) {
        $("#c").show();
    });
	
	//allow only a-z,A-Z and white space
	$("#name").keypress(function(e) {
       if((e.which<65 || e.which>90) && (e.which<97 || e.which>122) && e.which!=0 &&e.which!=32)
			return false;
		//alert(e.which);
    });
	
	//allow only a-z,A-Z and white space
	$("#purpose").keypress(function(e) {
       if((e.which<65 || e.which>90) && (e.which<97 || e.which>122) && e.which!=0 &&e.which!=32)
			return false;
		//alert(e.which);
    });
	
	$("#cu").click(function(e) {
        var name=$("#name").val();
		var email=$("#email").val();
		var purpose=$("#purpose").val();
		
		if(name=="" || email=="" || purpose=="")
		{
			$("#error").show();
			$("#success").hide();
			$("#error").text("All Fields are Required!!");
		}
		else
		{
			if(validateEmail(email)){
				$.ajax({
								method:'post',
								url:'ContactUs.php',
								data:{
									name:name,
									email:email,
									purpose:purpose
								},
								beforeSend: function() {
								$("#loading").show();
							},
								
								error:function(jqXHR,textStatus,errorThrown){document.getElementById("error").innerHTML="Sorry!!  								 			 							There is a problem";$("#loading").hide();},
								
								success:function(data)
								{
									//location.href="main_page.php";
									$("#loading").hide();
									$("#error").hide();
									$("#success").show();
									$("#success").text("Thank you. We have received your Request.");
								}
						   });	//end ofajax method
				}//end of if
			else
			{
				$("#error").show();
				$("#success").hide();
				$("#error").text("Check Email Format!!");
			}
		}
    });
});
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
<h1>My Expense</h1>
<hr />
<br />
<div id="main">
<a href="Login/">Login</a><br /><br />
<a href="SignUp/">Sign Up</a><br /><br />
<div id="contact">Contact Us</div><br />
<div id="c">
Enter Name <br /><input type="text" id="name" /><br />
Enter Email <br /> <input type="text" id="email" /><br />
Enter Purpose <br /> <textarea id="purpose" rows="6" cols="20" placeholder="If user. Please mention that!!"></textarea><br />
<div id="success"></div>
<div id="error"></div>
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="cu">Contact</button>
</div>
</div><!-- End of main container-->

<div id="loading"><img src="loading.GIF" /></div>
</body>
</html>
