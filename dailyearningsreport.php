<?php
	include_once("config.php");
	if(isset($_POST['datesubmit']))
	{	
		$date = $_POST['date'];
	}
?>

<!DOCTYPE html>
<html>
<head>	
	<title>Earnings Report (<?php echo $date; ?>)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>	
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Earnings Report for <?php echo $date ?></h2>
</div>
<a class="btn btn-danger" href="dailyearnings.php"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a>
<div class="col-md-12">
<div class="container-fluid col-md-6 text-center">
		<?php
		$sql = "SELECT SUM(transaction_total) as trans_total FROM tbl_transaction WHERE transaction_date LIKE '%".$date."%'";
		$query = $dbConn->prepare($sql);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
		echo "	<H3>Transaction Total: P".$row['trans_total']."</H3>";
		}
	?>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Date and Time</th>
			<th>Sale</th>
			<th>Customer Name</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = "SELECT * FROM tbl_transaction WHERE transaction_date LIKE '%".$date."%'";
		$query = $dbConn->prepare($sql);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
		echo "	<tr>
				<td>".$row['transaction_date']."</td>
				<td>".$row['transaction_total']."</td>
				<td>".$row['transaction_customer']."</td>
			</tr>";
		}
		?>
	</tbody>
</table>
</div>

<div class="container-fluid col-md-6 text-center">
		<h3>Items Sold for Today</h3>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Item</th>
			<th>Quantity</th>
			<th>Sale</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = "SELECT item_name, item_quantity, SUM(item_quantity) as quan, count(item_quantity) as cou FROM tbl_transaction_items WHERE item_date=:item_date GROUP BY item_name";
		$query = $dbConn->prepare($sql);
		$query->bindparam(':item_date', $date);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
		echo "	<tr>
				<td>".$row['item_name']."</td>
				<td>".$row['quan']."</td>
				<td>".$row['cou']."</td>
			</tr>";
		}
		?>
	</tbody>
</table>
</div>
</div>
</body>
</html>
