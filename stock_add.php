<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {	
	$name = $_POST['stock_name'];
	$price = $_POST['stock_price'];
	$quantity = $_POST['stock_quantity'];
	$unit = $_POST['stock_unit'];
	$base = $_POST['base_price'];
	$suppname = $_POST['supp_name'];
	$suppnum = $_POST['supp_num'];
		
	// checking empty fields
	if(empty($name) || empty($price) || empty($quantity)) {
				
		if(empty($name)) {
			echo "<font color='red'>nam cannot be empty.</font><br/>";
		}
		
		if(empty($price)) {
			echo "<font color='red'>pri cannot be empty.</font><br/>";
		}
		
		if(empty($quantity)) {
			echo "<font color='red'>quan cannot be empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
		
		$sql2 = "SELECT COUNT(*) FROM tbl_stocks WHERE stock_name = :stock_name";;
		$query2 = $dbConn->prepare($sql2);
		$query2->bindparam(':stock_name', $name);
		$query2->execute();
		while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
		{
			if ($row2['COUNT(*)'] == 1)
			{
				echo "<script type='text/javascript'>
					alert('A record with the same name already exists.');
				  </script>";
			}
			else
			{
				//insert data to database		
				$sql = "INSERT INTO tbl_stocks(stock_name, stock_base, stock_price, stock_quantity, stock_unit, stock_supname, stock_supnum) VALUES(:stock_name, :stock_base, :stock_price, :stock_quantity, :stock_unit, :stock_supname, :stock_supnum)";
				$query = $dbConn->prepare($sql);
				$query->bindparam(':stock_name', $name);
				$query->bindparam(':stock_base', $base);
				$query->bindparam(':stock_price', $price);
				$query->bindparam(':stock_quantity', $quantity);
				$query->bindparam(':stock_unit', $unit);
				$query->bindparam(':stock_supname', $suppname);
				$query->bindparam(':stock_supnum', $suppnum);
				$query->execute();
				
				// Alternative to above bindparam and execute
				// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));
				
				//display success message
				echo "<script type='text/javascript'>
				alert('Record added successfuly.');
				location = 'stock_view.php';
			  </script>";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Data</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Add New Stock</h2>
</div>
<div class="container-fluid">
	<form action="stock_add.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr> 
				<td>Item Name</td>
				<td><input type="text" required name="stock_name" class="form-control"</td>
			</tr>
			<tr> 
				<td>Base Price</td>
				<td><input type="number" step="0.01" min="0" required name="base_price" class="form-control"></td>
			</tr>
			<tr> 
				<td>Retail Price</td>
				<td><input type="number" step="0.01" min="0" required name="stock_price" class="form-control"></td>
			</tr>
			<tr> 
				<td>Quantity</td>
				<td><input type="number" step="0.01" min="0" required name="stock_quantity" class="form-control"></td>
			</tr>
			<tr>
				<td>Unit Type</td>
				<td><input class="form-control" type="text" required name="stock_unit"></td>
			</tr>
			<tr> 
				<td>Supplier Name</td>
				<td><input type="text" required name="supp_name" class="form-control"</td>
			</tr>
			<tr> 
				<td>Supplier Number</td>
				<td><input type="text" required name="supp_num" class="form-control"</td>
			</tr>
			<tr>
				<td><br><a class="btn btn-danger" href="stock_view.php">Cancel</a>  |  <input type="submit" name="Submit" value="Save" class="btn btn-success"></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>
