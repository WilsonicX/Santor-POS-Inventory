<?php
//Artworks of Scanhead   HNU 2017
include('db.class.php'); // call db.class.php
$mydb = new db(); // create a new object, class db()

$conn = $mydb->connect();

if(isset($_POST["query"]))
{

$q = $_POST["query"];
	
$results = $conn->prepare("SELECT * FROM tbl_stocks WHERE stock_name LIKE '%" . $q . "%'
OR stock_price LIKE '%".$q."%'
");
$search = 1;

}
else
{
 
 $results = $conn->prepare("SELECT * FROM tbl_stocks ");
 $search = 0;
 
}

$results->execute();
while($row = $results->fetch(PDO::FETCH_ASSOC))
{
	if ($search == 1)
	{
		$stock_quantity = $row['stock_quantity'] + 0;
		 echo '<tr onclick="javascript:showRow(this);">' . 
		'<td>' . $row['stock_name'] . '</td>' . 
		'<td>' . $row['stock_base'] . '</td>' .
		'<td>' . $row['stock_price'] . '</td>' .
		'<td style="font-weight:bold;color:red;">' . $stock_quantity . '</td>' .
		'<td>' . $row['stock_unit'] . '</td>' .
		'</tr>';
	}
	else
	{
		//do nothing
	}
} 


?>