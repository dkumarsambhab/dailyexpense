<?php
	require_once "userDisplay.php";
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
<script src="../jquery-ui.js"></script>
<link href="../jquery-ui.css" rel="stylesheet">
<script>
$(document).ready(function() {
	$("#dws_y").datepicker({
		dateFormat:"yy-mm-dd"	
	});	
	$("#btw_f_y").datepicker({
		dateFormat:"yy-mm-dd"	
	});
	$("#btw_t_y").datepicker({
		dateFormat:"yy-mm-dd"	
	});
	$("#mws_y").datepicker({
				 dateFormat: 'yy-mm'
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

	
	$("#dw").click(function() {
        $("#datewise").show();
		$("#monthwise").hide();
		$("#btw").hide();
    });
	
	$("#mw").click(function() {
        $("#monthwise").show();
		$("#datewise").hide();
		$("#btw").hide();
    });
	
	$("#bt").click(function() {
        $("#datewise").hide();
		$("#monthwise").hide();
		$("#btw").show();
    });

/*-----------------------------------------------DATE WISE-------------------------------------------------------------------*/	
	$("#dws").click(function() {
        var dws_y=$("#dws_y").val();
		
				
		$.ajax({
				method:"post",
				url:"../dateWiseExpense.php",
				data:{
					year:dws_y,
					email:email
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{	
					$("#loading").hide();
					if(data!='{"info":[]}')
					{	
						var obj = JSON.parse(data);
						var out = "<table align=center cellspacing=5 cellpadding=5 border=2><tr><th  colspan=3>Display Data</th></tr><tr><th>Date</th><th>Purpose</th><th>Price</th></tr>";
						var length=obj.info[0].len;
						var i;
						var sum=0;
						
						for(i=0;i<length;i++)
						{
							sum+=obj.info[i].price;
							out += '<tr><td>'+obj.info[i].date1+' </td><td>'+obj.info[i].purpose+' </td><td>'+obj.info[i].price+'</td></tr>';
						}
						
						out+="<tr><th colspan=3>Total Expense Rs."+sum+"</th></tr>";
						out=out+"</table>";
						
						$("#showdata").html(out);
					}
					else
					{
						$("#showdata").text("Total Expense Rs.0");
					}
					
				}
		});//end of ajax method
    });//end of click

/*-----------------------------------------------MONTH WISE-------------------------------------------------------------------*/	
	$("#mws").click(function() {
        var dws_y=$("#mws_y").val();
		$("#mws_y").removeClass("ui-datepicker-calendar");		
		$.ajax({
				method:"post",
				url:"../monthWiseExpense.php",
				data:{
					year:dws_y,
					email:email
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{	
					$("#loading").hide();
					if(data!='{"info":[]}')
					{	
						var obj = JSON.parse(data);
						var out = "<table cellspacing=5 cellpadding=5 border=2 align=center><tr><th  colspan=3>Display Data</th></tr><tr><th>Date</th><th>Purpose</th><th>Price</th></tr>";
						var length=obj.info[0].len;
						var i;
						var sum=0;
						
						for(i=0;i<length;i++)
						{
							sum+=obj.info[i].price;
							out += '<tr><td>'+obj.info[i].date1+' </td><td>'+obj.info[i].purpose+' </td><td>'+obj.info[i].price+'</td></tr>';
						}
						
						out+="<tr><th colspan=3>Total Expense Rs."+sum+"</th></tr>";
						out=out+"</table>";
						
						$("#showdata").html(out);
					}
					else
					{
						$("#showdata").text("Total Expense Rs.0");
					}
					
					$("#mws_y").addClass("ui-datepicker-calendar");
					
				}
		});//end of ajax method
    });//end of click
	
/*-----------------------------------------------BETWEEN TWO DATES--------------------------------------------------------------*/		
	$("#btn_btw").click(function() {
        var btw_f_y=$("#btw_f_y").val();
		var btw_t_y=$("#btw_t_y").val();
				
		$.ajax({
				method:"post",
				url:"../betweenDatesExpense.php",
				data:{
					f_y:btw_f_y,
					t_y:btw_t_y,
					email:email
				},
				beforeSend: function() {
								$("#loading").show();
							},
				error: function(jqXHR,textStatus,errorThrown){alert("Sorry!! There is a problem");$("#loading").hide();},
				success: function(data)
				{	
					$("#loading").hide();
					if(data!='{"info":[]}')
					{	
						var obj = JSON.parse(data);
						var out = "<table align=center cellspacing=5 cellpadding=5 border=2 ><tr><th  colspan=3>Display Data</th></tr><tr><th>Date</th><th>Purpose</th><th>Price</th></tr>";
						var length=obj.info[0].len;
						var i;
						var sum=0;
						
						for(i=0;i<length;i++)
						{
							sum+=obj.info[i].price;
							out += '<tr><td>'+obj.info[i].date1+' </td><td>'+obj.info[i].purpose+' </td><td>'+obj.info[i].price+'</td></tr>';
						}
						
						out+="<tr><th colspan=3>Total Expense Rs."+sum+"</th></tr>";
						out=out+"</table>";
						
						$("#showdata").html(out);
					}
					else
					{
						$("#showdata").text("Total Expense Rs.0");
					}
					
				}
		});//end of ajax method
    });//end of click
	
});
</script>
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
	a:hover{
		color:#6F0;
	}
	#container{
		text-align:center;		
	}
	#middle{
		text-align:center;		
	}
	#monthwise,#datewise,#btw{
		display:none;
	}
	#showdata{
		text-align:center;
	}
	#loading{
		left:50%;
		top:50%;
		position:fixed;
		display:none;
	}
</style>
</head>

<body>

<?php
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
<h1>My Expense</h1>
<hr />
<br />
<div id="container">
<div id="left">
<button onclick="location.href='../Main/'">Home</button>
<button id="lout">Log Out</button>
</div><br />

<div id="right">
<div id="tt"></div>
</div>
</div><!-- End of container--><br />

<div id="middle">
<button id="dw">Datewise</button>&nbsp;&nbsp;
<button id="mw">Monthwise</button>&nbsp;&nbsp;
<button id="bt">Between 2 Dates</button>
<br /><br /><br />

<!-- DATEEISE EXPENSE SHOW-->
<div id="datewise">
Select Date
<input type="text" id="dws_y" readonly="readonly" /><br />
<button id="dws">Search</button>
</div>

<!-- MONTHEISE EXPENSE SHOW-->
<div id="monthwise">
Select Month
<input type="text" id="mws_y" readonly="readonly"><br />
<button id="mws">Search</button>
</div>

<!-- BETWEEN TWO DATES-->
<div id="btw">
Select From Date
<input type="text" id="btw_f_y" readonly="readonly">
<br />
Select To Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" id="btw_t_y" readonly="readonly"><br />
<button id="btn_btw">Search</button>
</div>

</div><!-- End of Middle--><br />

<div id="showdata">Data Will be displayed Here</div>
<div id="loading"><img src="../loading.GIF" /></div>
<input type="hidden" id="email" value="<?php echo $_SESSION["email"] ?>" />
</body>
</html>