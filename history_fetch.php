<?php
//Artworks of Scanhead   HNU 2017
include('db.class.php'); // call db.class.php
$mydb = new db(); // create a new object, class db()

$conn = $mydb->connect();

if(isset($_POST["query"]))
{

$q = $_POST["query"];
	
$results = $conn->prepare("SELECT * FROM tbl_transaction WHERE transaction_date LIKE '%" . $q . "%'
OR transaction_id LIKE '%".$q."%'
OR transaction_customer LIKE '%".$q."%' ORDER BY transaction_id DESC");
$results->execute();
while($row = $results->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['transaction_id']."</td>";
	echo "<td>".$row['transaction_date']."</td>";
	echo "<td>₱ ".$row['transaction_total']."</td>";
	echo "<td>".$row['transaction_customer']."</td>";
	echo "<td><a href=\"history_details.php?id=$row[transaction_id]\" title='View'><span class='glyphicon glyphicon-eye-open'></span></a> | <a href=\"history_delete.php?id=$row[transaction_id]\" onClick=\"return confirm('Are you sure you want to delete this record? This cannot be undone.')\" title='Delete'><span class='glyphicon glyphicon-remove'></span></a></td>";	
} 


}
else
{
	//do nothing
}



?>