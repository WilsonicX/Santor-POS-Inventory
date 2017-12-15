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
<!DOCTYPE html>
<html>
<head>	
	<title>Homepage</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
	<style>
			/* Sticky footer styles
		-------------------------------------------------- */
		html {
		  position: relative;
		  min-height: 100%;
		}
		body {
		  /* Margin bottom by footer height */
		  margin-bottom: 60px;
		}
		.footer {
		  position: absolute;
		  bottom: 0;
		  width: 100%;
		  /* Set the fixed height of the footer here */
		  height: 60px;
		  line-height: 60px; /* Vertically center the text there */
		  background-color: #d3d3d3;
		}
	</style>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Welcome!</h2>
</div>

<div class="container text-center">
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-list" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<a class="btn btn-primary" href="stock_view.php" style=" margin-bottom:50px;">View Stocks</a>
		</div>
	</div>
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-shopping-cart" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<form name="form1" name="newTransaction" method="post" action="index.php">
				<input type="submit" class="btn btn-primary" value="Make a Transaction" name="newTransaction" style=" margin-bottom:50px;">
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363">
			<span class="glyphicon glyphicon-duplicate" style="font-size: 100px; margin-top:50px;"></span><br><br>
			<a class="btn btn-primary" href="history_view.php" style=" margin-bottom:50px;">View Transaction History</a>
		</div>
	</div>
	
	<div class="col-md-12" style="margin-top:2em;">
		<div class="col-md-12" style="background-color:#d3d3d3; border-style: none; border-radius:5px; box-shadow: 7px 7px 10px #636363"">
			<h3>Notifications</h3>
			
			
			<?php
				$sql = "SELECT * FROM tbl_stocks WHERE stock_quantity<=10";
				$query = $dbConn->prepare($sql);
				$query->execute();
				if($query->rowCount()<=0)
					{
						echo '
								<div class="alert alert-info" style="box-shadow: 1px 1px 3px #636363">
									<strong>Nothing to see here.</strong> You have no stocks with low quantity.
								</div>
							';
					}
					else
					{
						while($row = $query->fetch(PDO::FETCH_ASSOC))
						{
							$quan = $row['stock_quantity']+0;
							echo '
								<div class="alert alert-danger" style="box-shadow: 1px 1px 3px #636363">
									<strong>Low stock alert!</strong> Your stock of <strong>'.$row['stock_name'].'</strong> is currently at a low quantity ('.$quan.' '.$row['stock_unit'].').
								</div>
							';
						}
					}
				
			?>
		</div>
	</div>
</div>

<!--<footer class="footer text-center">
      <div class="container">
        <span class="text-muted">System created for SANTOR HARDWARE by Johann Bulandos
		(<a href="http://www.johannbulandos.com/" target="_blank">www.johannbulandos.com</a>)</span>
      </div>
</footer>-->
</body>
</html>
