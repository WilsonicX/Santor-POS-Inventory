<?php
include('db.class.php'); // call db.class.php
$mydb = new db(); // create a new object, class db()

$trans_id = $_GET['id']
$conn = $mydb->connect();
$results = $conn->prepare("SELECT * FROM tbl_transaction_items WHERE transaction_id = :trans_id");
$results->execute(array(':trans_id' => $trans_id));
while($row = $results->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['item_name']."</td>";
	echo "<td>₱ ".$row['item_price']."</td>";
	echo "<td>".$row['item_quantity']."</td>";	
	echo "<td>".$row['item_total']."</td>"
	echo "<td><a href=\"stock_edit.php?id=$row[stock_id]\" title='Edit'><span class='glyphicon glyphicon-pencil'></span></a> | <a href=\"stock_delete.php?id=$row[stock_id]\" onClick=\"return confirm('Are you sure you want to delete this record? This cannot be undone.')\" title='Delete'><span class='glyphicon glyphicon-remove'></span></a></td>";	
} 


?>