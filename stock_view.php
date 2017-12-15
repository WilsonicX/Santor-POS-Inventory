<!DOCTYPE html>
<html>
<head>	
	<title>Stocks</title>
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
			   url:"stock_fetch.php",
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
		<h2>Stocks</h2>
</div>
<div class="container-fluid">
		<a href="index.php" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a>
		<a href="stock_add.php" class="btn btn-info" role="button"><span class="glyphicon glyphicon-plus"></span> Add New Item</a>
		<a href="javascript:history.go(0)" class="btn btn-success" role="button"><span class="glyphicon glyphicon-refresh"></span> Refresh</a><br/><br/>

		<div class="form-group col-md-4">
           <div class="input-group">
            <span class="input-group-addon">Search</span>
            <input type="text" name="search_text" id="search_text" placeholder="Search by Name, Price or Quantity" class="form-control" />
           </div>
         </div>
		<table class="table table-striped table-bordered table-hover" id="main">

		<thead>
			<tr>
				<td style="font-weight:bold">Item Name</td>
				<td style="font-weight:bold">Base Price</td>
				<td style="font-weight:bold">Retail Price</td>
				<td style="font-weight:bold">Stocks Left</td>
				<td style="font-weight:bold">Unit Type</td>
				<td style="font-weight:bold">Supplier Name</td>
				<td style="font-weight:bold">Supplier Number</td>
				<td style="font-weight:bold">Action</td>
			</tr>
		</thead>
		<tbody id="result">
		
		</tbody>
		</table>
</div>
</body>
</html>
