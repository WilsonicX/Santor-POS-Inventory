
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['newTransaction']))
{	
		//updating the table
		$sql = "INSERT INTO tbl_transaction(transaction_total) VALUES(0.00)";
		$query = $dbConn->prepare($sql);
		$query->execute();
		
		$sql = "SELECT * FROM tbl_transaction ORDER BY transaction_id DESC LIMIT 1";
		$query = $dbConn->prepare($sql);
		$query->execute();

		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$transaction_id = $row['transaction_id'];
		}
				
		//redirectig to the display page. In our case, it is index.php
		header('Location: transaction_new.php?trans_id='.$transaction_id.'');
}
?>

<html>
<head>	
	<title>Success!</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Success!</h2>
</div>

<div class="container text-center">
	<h1 style="margin-bottom: 2em; font-weight: bold; color:#f44242;">Change: ₱<?php echo $_GET['trans_change']?></h1>
	<h1 style="margin-bottom: 2em;">Please select another action.</h1>
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-list" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<a class="btn btn-primary" href="stock_view.php" style=" margin-bottom:45px;">View Stocks</a><br><br>
		</div>
	</div>
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-shopping-cart" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<form name="form1" name="newTransaction" method="post" action="index.php">
				<input type="submit" class="btn btn-primary" value="Make Another Transaction" name="newTransaction" style=" margin-bottom:50px;">
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-duplicate" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<a class="btn btn-primary" href="history_view.php" style=" margin-bottom:45px;">View Transaction History</a><br><br>
		</div>
	</div>
</div>


</body>
</html>
