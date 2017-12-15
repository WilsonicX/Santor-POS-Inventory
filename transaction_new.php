<?php
date_default_timezone_set('Asia/Singapore');
include('db.class.php'); // call db.class.php
include('config.php');
$mydb = new db(); // create a new object, class db()

 if (isset($_POST['submit'])) 
{
	$item_name=$_POST['item_name'];
	$item_price=floatval($_POST['item_price']);
	$item_quantity=$_POST['item_quantity'];
	$item_total=$item_price*$item_quantity;
	$item_unit=$_POST['item_unit'];
	$trans_id=$_GET['trans_id'];
	
	$sql2 = "SELECT stock_quantity FROM tbl_stocks WHERE stock_name=:item_name";
					$query2 = $dbConn->prepare($sql2);
					$query2->execute(array(':item_name' => $item_name));

	while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
	{
		if ($row2['stock_quantity'] >= $item_quantity)
		{
			$query = $mydb->execute('INSERT INTO tbl_transaction_items (item_name, item_price, item_quantity, item_unit, item_total, transaction_id, item_date) VALUES ("'.$item_name.'","'.(float)$_POST['item_price'].'","'.$item_quantity.'","'.$item_unit.'","'.$item_total.'","'.$trans_id.'", now())');
			header("Location:transaction_new.php?trans_id=".$_GET['trans_id']."");
		}
		else
		{
			echo "<script>alert('You do not have enough stocks of that item.');self.history.back();</script>";
		}
	}
	
}
       
?>

<!DOCTYPE html>
<html>
<head>
<title>New Transaction</title>
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
	   url:"transaction_fetch.php",
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


	function showRow(row)
	{
		var x=row.cells;
		document.getElementById("itemID").value = x[0].innerHTML;
		document.getElementById("itemPrice").value = x[2].innerHTML;
		document.getElementById("itemUnit").value = x[4].innerHTML;
	}

	
	
	
</script>


<style>
table ,tr td{
    border:1px solid red
}
tbody {
    display:block;
    height:200px;
    overflow:auto;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;/* even columns width , fix width of table too*/
}
thead {
    width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
}
table {
    width:400px;
}
</style>


</head>
<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>New Transaction</h2>
</div>
<div class="container-fluid">
<div clas="col-md-12">
	<a class="btn btn-warning" href="transaction_cancel.php?trans_id=<?php echo $_GET['trans_id']?>" onClick="return confirm('Are you sure you want to cancel the transaction?')">Cancel</a>
</div>
		<div class="col-sm-6">
		<h4>Transaction Number: <?php echo $_GET['trans_id']?></h4>
		
		<div class=".col-md-6">
          <div class="bs-example">
         
		 
		 <div class="form-group">
           <div class="input-group">
            <span class="input-group-addon">Search</span>
            <input type="text" name="search_text" id="search_text" placeholder="Search for Product" class="form-control" />
           </div>
         </div>
		 
		

	      </div>
        </div>
			
		
		
		
		
				<table class="table table-striped table-bordered table-hover" id="main">
				<thead>
				  <tr>
					<th>Item Name</th>
					<th>Base Price</th>
					<th>Retail Price</th>
					<th>Stocks Left</th>
					<th>Unit Type</th>
				  </tr>
				</thead>
				
				
				<tbody id="result">
					
				</tbody>
				</table>
			<div class="paging_link"></div>
		</div>
		<div class="col-sm-6">
			<form class="form-horizontal" method="post">
				<div class="form-group">
				<label class="control-label col-sm-2">Item Name:</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="itemID" required name="item_name" readonly>
				</div>
				<label class="control-label col-sm-2">Price (₱):</label>
				<div class="col-sm-2">
				  <input type="number" class="form-control" id="itemPrice" required name="item_price"  readonly>
				</div>
			  
				<label class="control-label col-sm-2">Quantity:</label>
				<div class="col-sm-2"> 
				  <input type="number" min="0.01" step="0.01" class="form-control" id="itemQuantity" required name="item_quantity">
				</div>
				<label class="control-label col-sm-1">Unit:</label>
				<div class="col-sm-2"> 
				  <input type="text" class="form-control" id="itemUnit" required name="item_unit" readonly>
				</div>
				<button type="submit" class="btn btn-success" name="submit">Add</button>
				</div>
			  
			</form>
			
			
			<table class="table table-striped table-bordered table-hover" id="main">
				<thead>
				  <tr>
					<th>Stock Name</th>
					<th>Price (₱)</th>
					<th>Quantity</th>
					<th>Unit</th>
					<th>Total</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					$sql = "SELECT * FROM tbl_transaction_items WHERE transaction_id=". $_GET['trans_id'] ."";
					$query = $dbConn->prepare($sql);
					$query->execute(array(':stock_id' => $_GET['trans_id']));

					if($query->rowCount()<=0)
					{
						echo '<tr>' . 
							'<td>No</td>' . 
							'<td>items</td>' .
							'<td>added</td>' .
							'<td></td>' .
							'<td style="font-weight:bold;color:red;"></td>' .
							'<td></td>' .
							'</tr>';
					}
					else
					{
						while($row = $query->fetch(PDO::FETCH_ASSOC))
						{
							$item_quantity = $row['item_quantity'] + 0;
							$item_total = $row['item_total'] + 0;
							$item_price = $row['item_price'] + 0;
							echo '<tr>' . 
							'<td>' . $row['item_name'] . '</td>' . 
							'<td>' . $item_price . '</td>' .
							'<td>' . $item_quantity . '</td>' .
							'<td>' . $row['item_unit'] . '</td>' .
							'<td style="font-weight:bold;color:red;">' . $item_total . '</td>' .
							'<td><a href="transaction_item_delete.php?item_id='.$row['item_id'].'&trans_id='.$_GET['trans_id'].'"><span class="glyphicon glyphicon-remove"></span></a></td>' .
							'</tr>';
						}

					}
			    ?>
				</tbody>
			</table>
			
			<div class="col-md-12 text-right">
			
			<?php
				$sql = "SELECT item_id,SUM(item_total) as trans_total, transaction_id FROM tbl_transaction_items WHERE transaction_id = :transaction_id GROUP BY transaction_id";
				$query = $dbConn->prepare($sql);
				$query->execute(array(':transaction_id' => $_GET['trans_id']));

				while($row = $query->fetch(PDO::FETCH_ASSOC))
				{
					$transaction_total = $row['trans_total'];
				}
			?>
				<form action="transaction_pre_print.php" method="post" name="change_compute" id="change_compute">
					<div class="col-md-8">
						<h3>Amount Due:</h3>
					</div>
					<div class="col-md-4" style="margin-top:20px">
						<input type="number" class="form-control" id="trans_total" required name="trans_total" value="<?php echo $transaction_total; ?>" readonly>
					</div>
					<div class="col-md-8">
						<h3>Cash Given:</h3>
					</div>
					<div class="col-md-4" style="margin-top:20px">
						<input type="number" step="0.01" min="0" required name="cash_given" id="cash_given" class="form-control">
					</div>
					<div class="col-md-8" style='font-weight:bold; color:#f44242'>
						<h3>Change:</h3>
					</div>
					<div class="col-md-4">
						<h3 class='display' id='display' style='font-weight:bold; color:#f44242'>0.00</h3>
					</div>
					<div class="col-md-8">
						<h3>Customer:</h3>
					</div>
					<div class="col-md-4" style="margin-top:20px">
						<input type="text" required name="customer_name" id="customer_name" class="form-control">
					</div>
					<div class="col-md-12" style="margin-top:20px">
					<input type="hidden" class="form-control" id="trans_id" name="trans_id" value="<?php echo $_GET['trans_id']; ?>">
					<input type="submit" class="btn btn-success" value="Finish Transaction" name="printReciept" style="margin-top:20px">
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
<script>
$("#cash_given").keyup(function() {
		var inputBox2 = +document.getElementById('trans_total').value;
		var inputBox = $(this).val();
		if(inputBox != '')
		{
			var sum = +inputBox - +inputBox2;
			document.getElementById('display').innerHTML = sum.toFixed(2);;
		}
		else
		{
			document.getElementById('display').innerHTML = (0).toFixed(2);
		}
	  })
</script>
</body>
</html>