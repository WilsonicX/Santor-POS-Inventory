<!DOCTYPE html>
<html>
<head>	
	<title>Transaction History</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
	
	<script type="text/javascript">

			$(document).ready(function(){

			 load_data();

			 function load_data(query)
			 {
			  $.ajax({
			   url:"history_fetch.php",
			   method:"POST",
			   data:{query:query},
			   success:function(data)
			   {
				$('#result').html(data);
			   }
			  });
			 }
			 
			 $('#search_text').keyup(function(){
			  var search = $(this).val();
			  if(search != '')
			  {
			   load_data(search);
			  }
			  else
			  {
			   load_data();
			  }
			 });
			});

	</script>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Transaction History</h2>
</div>
<div class="container-fluid">
		<a href="index.php" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a> <a href="dailyearnings.php" class="btn btn-info" role="button"><span class="glyphicon glyphicon-file"></span> View Daily Report</a><br/><br/>

		<div class="form-group col-md-5">
           <div class="input-group">
            <span class="input-group-addon">Search</span>
            <input type="datetime-local" name="search_text" id="search_text" placeholder="Search by name, date or transaction number" class="form-control" />
           </div>
         </div>
		<table class="table table-striped table-bordered table-hover" id="main">

		<thead>
			<tr>
				<td style="font-weight:bold" style="width:10%">Number</td>
				<td style="font-weight:bold">Transaction Date and Time</td>
				<td style="font-weight:bold">Total</td>
				<td style="font-weight:bold">Customer Name</td>
				<td style="font-weight:bold">Action</td>
			</tr>
		</thead>
		<tbody id="result">
		
		</tbody>
		</table>
</div>
</body>
</html>
