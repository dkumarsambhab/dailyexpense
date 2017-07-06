<?php
	session_start();
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
	#lower{
		text-align:center;
	}
</style>
<script>
$(document).ready(function() {
    $("#Add").click(function() {
        var purpose=$("#purpose").val();
		var price=$("#price").val();
		var email=$("#email").val();
		
		if(purpose=="" || price=="")
		{
			$("#error").text("Both Fields are Required!!");
		}
		else
		{
			$.ajax({
				method:"post",
				url:"../addExpenseHandler.php",
				data:{
					email:email,
					purpose:purpose,
					price:price	
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){$("#error").text("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{
					$("#loading").hide();
					$("#success").text("Successfully Saved!!");
					$("#price").val("");
					$("#purpose").val("");
				}
			});
		}
    });
	
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
    });
	
	//allow only numbers in phone
	$("#price").keypress(function(e) {
		//alert(e.which);
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which!=46) {
        	return false;
    	}
    });
	
});
</script>
</head>

<body>
<?php
	require_once "userDisplay.php";

	if(!isset($_SESSION["email"]))
	{
		header("Location: ../Login/");
		return;
	}
?>

<?php
		$ud=new userDisplay();
		$name=$ud->getNameByEmail($_SESSION["email"]);
?>

<h1><?php echo $name; ?></h1>
<hr />
<br />

<div id="lower">
<input type="hidden" id="email" value="<?php echo $_SESSION["email"] ?>" />
Enter Purpose : <input type="text" id="purpose" /><br />
Enter Price : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="price" /><br /><br />
<button id="Add">Add Expense</button>
<button onclick="location.href='../Main/'">Home</button>
<button id="lout">Log Out</button>
<div id="error"></div>
<div id="success"></div>
</div>
<div id="loading"><img src="../loading.GIF" /></div>

</body>
</html>