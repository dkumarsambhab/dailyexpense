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
<script>
$(document).ready(function() {
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
	
	//start default event
	var email=$("#email").val();
	$.ajax({
				method:"post",
				url:"../todayExpense.php",
				data:{
					email:email
				},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");},
				success: function(data)
				{
					if(data!=0)
						$("#tt").text("Todays' Toal Expense : Rs."+data);
					else
						$("#tt").text("Todays' Toal Expense : Rs.0");
				}
	});//end of ajax method
	
	$.ajax({
				method:"post",
				url:"../currentMonthExpense.php",
				data:{
					email:email
				},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");},
				success: function(data)
				{
					if(data!=0)
						$("#mt").text("This Month's Total Expense : Rs."+data);
					else
						$("#mt").text("This Month's Total Expense : Rs.0");
				}
	});//end of ajax method
	
});
</script>
<style>
	a:hover{
		color:#6F0;
	}
	#container{
		font-size:2.5vmax;
		text-align:center;
	}
	/*#left{
		text-align:center;
	}
	#lower{
		margin-left:15vw;
	}*/
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
</style>
</head>

<body>

<?php
	require_once "userDisplay.php";

	if(!isset($_SESSION["email"]))
	{
		header("Location: '../Login/'");
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
<div id="container">
<div id="left">
<a href="../Add/">Add Expense</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../Check/">Check Expense</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../Modify/">Modify Expense</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../Update/">Modify Account</a><br /><br />
</div><br /><br />

<div id="lower">
<button id="lout">Log Out</button><br /><br /><br />
<div id="tt"></div>
<div id="mt"></div>
</div>
</div><!-- End of container-->

<input type="hidden" id="email" value="<?php echo $_SESSION["email"] ?>" />

</body>
</html>