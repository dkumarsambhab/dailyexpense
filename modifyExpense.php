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
	#error{
		color:#F00;
	}
	#success{
		color:#6F0;
	}
	
	#middle{
		text-align:center;
	}
	.u_btn{
		cursor:pointer;
	}
	.u_btn:hover{
		color:#F00;
	}
	#showdata{
		display:none;
		text-align:center;
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
	/*div{
		border-style: solid;
    border-color: red;
	}*/
</style>
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
				url:"../todayDetails.php",
				data:{
					email:email
				},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");},
				success: function(data)
				{
					if(data!='{"info":[]}')
					{
						var obj = JSON.parse(data);
						var out = "<table align=center cellspacing=5 cellpadding=5 border=2><tr><th  colspan=4>Display Data</th></tr><tr><th>Info_Id</th><th>Purpose</th><th>Price</th><th></th></tr>";
						var length=obj.info[0].len;
						var i;
						
						for(i=0;i<length;i++)
						{
							out += '<tr><td>'+obj.info[i].info_id+' </td><td>'+obj.info[i].purpose+' </td><td>'+obj.info[i].price+'</td><td><div class="u_btn" id='+obj.info[i].info_id+'>Update</div></td></tr>';
						}
						out=out+"</table>";
						
						$("#table").html(out);
					}else{
						$("#table").text("No Expense is Done Today!!");
					}
				}
	});//end of ajax method
	
	//METHOD FOR DYNAMIC CLICK EVENT ON DYNAMIC CLASS
	$('body').on('click','.u_btn',function(){
		var info_id=$(this).attr('id');
		
		$.ajax({
				method:"post",
				url:"../detailsByInfo_IdHandler.php",
				data:{
					info_id:info_id
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{//alert(data);
					$("#loading").hide();
					if(data!='{"info":[]}')
					{
						var obj=JSON.parse(data);
						var purpose=obj.info[0].purpose;
						var price=obj.info[0].price;
						
						$("#showdata").show();
						$("#purpose").val(purpose);
						$("#price").val(price);
						$("#info_id").val(info_id);
					}else{
						alert("Sorry There is a problem!!");
					}
				}
	});//end of ajax method
	});
	
	//allow only numbers in price
	$("#price").keypress(function(e) {
		//alert(e.which);
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which!=46) {
        	return false;
    	}
    });
	
	//update method
	$("#update").click(function(e) {
        var purpose=$("#purpose").val();
		var price=$("#price").val();
		var info_id=$("#info_id").val();
		
		if(purpose=="" || price=="")
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
				url:"../updateInfoHandler.php",
				data:{
					info_id:info_id,
					purpose:purpose,
					price:price
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{
					$("#loading").hide();
					$("#success").text(data);
				}
		});//end of ajax method
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

<div id="container">
<button onclick="location.href='../Main/'">Home</button>
<button id="lout">Log Out</button>
</div><br />

<!-- Table will be shown here-->

<div id="middle">
CHANGE IS ALLOWED ONLY FOR TODAY'S EXPENSE!!<br /><br />
<div id="table"></div>
</div><br /><br />

<div id="showdata">
<table align="center">
<tr>
<td>Info_Id</td>
<td><input type="text" id="info_id" readonly="readonly" /></td>
</tr>
<tr>
<td>Update Purpose</td>
<td><input type="text" id="purpose" /></td>
</tr>
<tr>
<td>Update Price</td>
<td><input type="text" id="price" /></td>
</tr>
<tr>
<td colspan="2"><button id="update">Update Expense</button></td>
</tr>
<tr>
<td colspan="2"><div id="error"></div></td>
</tr>
<tr>
<td colspan="2"><div id="success"></div></td>
</tr>
</table>
</div>

<div id="loading"><img src="../loading.GIF" /></div>
<input type="hidden" id="email" value="<?php echo $_SESSION["email"] ?>" />

</body>
</html>