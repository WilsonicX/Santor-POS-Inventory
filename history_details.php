<?php
include('db.class.php'); // call db.class.php
$mydb = new db(); // create a new object, class db()

$trans_id = $_GET['id'];
$conn = $mydb->connect();
$results = $conn->prepare("SELECT * FROM tbl_transaction_items WHERE transaction_id = :trans_id");
$results->execute(array(':trans_id' => $trans_id));

?>

<!DOCTYPE html>
<html>
<head>	
	<title>Transaction Number <?php echo $_GET['id']; ?> Details</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h3>
			Transaction Number: <?php echo $_GET['id']; ?> | 
			<?php
				include_once('config.php');
				$sql4 = "SELECT * FROM tbl_transaction WHERE transaction_id = :id";
				$query4 = $dbConn->prepare($sql4);
				$query4->execute(array(':id' => $_GET['id']));
				while($row4 = $query4->fetch(PDO::FETCH_ASSOC))
				{
					echo "Total: ".$row4['transaction_total']." | Change: ".$row4['transaction_change']." | Customer: ".$row4['transaction_customer'];
				}
			?>
		</h3>
</div>
<div class="container-fluid">
		<a href="history_view.php" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a><br/><br/>

		<table class="table table-striped table-bordered table-hover" id="main">

		<thead>
			<tr>
				<td style="font-weight:bold">Item Name</td>
				<td style="font-weight:bold">Price</td>
				<td style="font-weight:bold">Quantity</td>
				<td style="font-weight:bold">Unit</td>
				<td style="font-weight:bold">Subtotal</td>
				<td style="font-weight:bold">Action</td>
			</tr>
		</thead>
		<div class="container">
		<tbody id="result">
		<?php
			while($row = $results->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr>";
				echo "<td>".$row['item_name']."</td>";
				echo "<td>₱ ".$row['item_price']."</td>";
				echo "<td>".$row['item_quantity']."</td>";	
				echo "<td>".$row['item_unit']."</td>";
				echo "<td>".$row['item_total']."</td>";
				echo "<td><a href=\"history_details_delete.php?id=$trans_id&item_id=".$row['item_id']."\" onClick=\"return confirm('Are you sure you want to delete this record? This cannot be undone.')\" title='Remove'><span class='glyphicon glyphicon-remove'></span></a></td>";	
			} 
		?>
		</tbody>
		</div>
		</table>
</div>
</body>
</html>
