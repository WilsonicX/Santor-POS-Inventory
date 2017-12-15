<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$item_id = $_GET['item_id'];
$trans_id = $_GET['trans_id'];

//deleting the row from table
$sql = "DELETE FROM tbl_transaction_items WHERE item_id=:item_id";
$query = $dbConn->prepare($sql);
$query->execute(array(':item_id' => $item_id));

//redirecting to the display page (index.php in our case)
header("Location:transaction_new.php?trans_id=".$trans_id."");
?>
