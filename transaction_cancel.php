<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$transaction_id = $_GET['trans_id'];

//deleting the row from table
$sql = "DELETE FROM tbl_transaction WHERE transaction_id=:transaction_id";
$query = $dbConn->prepare($sql);
$query->execute(array(':transaction_id' => $transaction_id));

//redirecting to the display page (index.php in our case)
header("Location:index.php");
?>
