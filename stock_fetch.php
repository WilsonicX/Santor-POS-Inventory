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
OR stock_quantity LIKE '".$q."'
");


}
else
{
 
	$results = $conn->prepare("SELECT * FROM tbl_stocks ORDER BY stock_id DESC");

}

$results->execute();
while($row = $results->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['stock_name']."</td>";
	echo "<td>₱ ".$row['stock_base']."</td>";
	echo "<td>₱ ".$row['stock_price']."</td>";
	echo "<td>".$row['stock_quantity']."</td>";	
	echo "<td>".$row['stock_unit']."</td>";	
	echo "<td>".$row['stock_supname']."</td>";	
	echo "<td>".$row['stock_supnum']."</td>";	
	echo "<td><a href=\"stock_edit.php?id=$row[stock_id]\" title='Edit'><span class='glyphicon glyphicon-pencil'></span></a> | <a href=\"stock_delete.php?id=$row[stock_id]\" onClick=\"return confirm('Are you sure you want to delete this record? This cannot be undone.')\" title='Delete'><span class='glyphicon glyphicon-remove'></span></a></td>";	
} 


?>