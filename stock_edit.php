<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	
	$stock_id = $_POST['id'];
	
	$stock_name=$_POST['stock_name'];
	$stock_price=$_POST['stock_price'];
	$stock_supnum=$_POST['supp_num'];
	$stock_supname=$_POST['supp_name'];
	$unit = $_POST['stock_unit'];
	
	$base = $_POST['base_price'];
	
	// checking empty fields
		
	//updating the table
	$sql = "UPDATE tbl_stocks SET stock_name=:stock_name, stock_price=:stock_price, stock_base=:stock_base, stock_unit=:stock_unit, stock_supname=:stock_supname, stock_supnum=:stock_supnum WHERE stock_id=:stock_id";
	$query = $dbConn->prepare($sql);
			
	$query->bindparam(':stock_id', $stock_id);
	$query->bindparam(':stock_name', $stock_name);
	$query->bindparam(':stock_price', $stock_price);
	$query->bindparam(':stock_base', $base);
	$query->bindparam(':stock_supname', $stock_supname);
	$query->bindparam(':stock_supnum', $stock_supnum);
	$query->bindparam(':stock_unit', $unit);
	$query->execute();
	
	// Alternative to above bindparam and execute
	// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));
			
	//redirectig to the display page. In our case, it is index.php
	echo "<script type='text/javascript'>
	alert('Record added successfuly.');
	location = 'stock_edit.php?id=".$stock_id."';
  </script>";
}

if(isset($_POST['newstock']))
{	
	$id = $_POST['id'];
	
	$date=$_POST['date'];
	$quantity=$_POST['quantity'];
	$notes=$_POST['notes'];
	
	
	$sql = "INSERT INTO tbl_new_stock(new_date, new_quantity, new_notes, stock_id) VALUES(:new_date, :new_quantity, :new_notes, :stock_id)";
	$query = $dbConn->prepare($sql);
	$query->bindparam(':new_date', $date);
	$query->bindparam(':new_quantity', $quantity);
	$query->bindparam(':new_notes', $notes);
	$query->bindparam(':stock_id', $id);
	$query->execute();
	
	// checking empty fields
		
	//updating the table
	$sql = "UPDATE tbl_stocks SET stock_quantity=stock_quantity+:quantity WHERE stock_id=:stock_id";
	$query = $dbConn->prepare($sql);
			
	$query->bindparam(':stock_id', $id);
	$query->bindparam(':quantity', $quantity);
	$query->execute();
	
	// Alternative to above bindparam and execute
	// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));
			
	//redirectig to the display page. In our case, it is index.php
	echo "<script type='text/javascript'>
	alert('Record added successfuly.');
	location = 'stock_edit.php?id=".$id."';
  </script>";
}
?>
<?php
//getting id from url
$stock_id = $_GET['id'];

//selecting data associated with this particular id
$sql = "SELECT * FROM tbl_stocks WHERE stock_id=:stock_id";
$query = $dbConn->prepare($sql);
$query->execute(array(':stock_id' => $stock_id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$stock_name = $row['stock_name'];
	$stock_price = $row['stock_price'];
	$stock_quantity = $row['stock_quantity'];
	$stock_unit = $row['stock_unit'];
	$supname = $row['stock_supname'];
	$supnum = $row['stock_supnum'];
	$unit = $row['stock_unit'];
	$base = $row['stock_base'];
	
}
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Edit Data</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Update Stock Info</h2>
</div>
<div class="container-fluid col-md-4">
	<form name="form1" method="post" action="stock_edit.php">
		<table border="0">
			<tr> 
				<td>Item Name </td>
				<td><input class="form-control" type="text" required name="stock_name" value="<?php echo $stock_name;?>"></td>
			</tr>
			<tr> 
				<td>Base Price </td>
				<td><input class="form-control" type="number" step="0.01" min="0" required name="base_price" value="<?php echo $base;?>"></td>
			</tr>
			<tr> 
				<td>Retail Price </td>
				<td><input class="form-control" type="number" step="0.01" min="0" required name="stock_price" value="<?php echo $stock_price;?>"></td>
			</tr>
			<tr> 
				<td>Quantity </td>
				<td><input class="form-control" type="text" readonly required name="stock_quantity" value="<?php echo $stock_quantity;?>"></td>
			</tr>
			<tr>
				<td>Unit Type</td>
				<td><input class="form-control" type="text" required name="stock_unit" value="<?php echo $stock_unit;?>"></td>
			</tr>
			<tr> 
				<td>Supplier Name</td>
				<td><input type="text" required name="supp_name" class="form-control" value="<?php echo $supname;?>"</td>
			</tr>
			<tr> 
				<td>Supplier Number</td>
				<td><input type="text" required name="supp_num" class="form-control" value="<?php echo $supnum;?>"</td>
			</tr><br>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><br><a class="btn btn-danger" href="stock_view.php">Cancel</a>  | <input type="submit" name="update" value="Update" class="btn btn-success"></td>
			</tr>
		</table>
	</form>
</div>

<div class="container-fluid col-md-8">
		<h3>Stock History</h3>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Quantity Added</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<form name="form2" method="post" action="stock_edit.php">
		<tr>
			<td><input class="form-control" type="date" name="date" required></td>
			<td><input class="form-control" type="number" name="quantity" step="0.01" min="0" placeholder="Quantity" required></td>
			<td><input class="form-control" type="text" name="notes" placeholder="Notes"><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
			<td><input class="btn btn-info" type="submit" name="newstock" value="Submit"></td>
		</tr>
		</form>
		<?php
		$sql = "SELECT * FROM tbl_new_stock WHERE stock_id=:stock_id ORDER BY new_date desc LIMIT 20";
		$query = $dbConn->prepare($sql);
		$query->bindparam(':stock_id', $_GET['id']);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
		echo "	<tr>
				<td>".$row['new_date']."</td>
				<td>".$row['new_quantity']."</td>
				<td>".$row['new_notes']."</td>
				<td></td>
			</tr>";
		}
		?>
	</tbody>
</table>
</div>
</body>
</html>