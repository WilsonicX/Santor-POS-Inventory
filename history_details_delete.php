<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$id = $_GET['id'];
$itemid = $_GET['item_id'];

//deleting the row from table and adding back stocks
$sql4 = "SELECT * FROM tbl_transaction_items WHERE item_id = :id ";
				$query4 = $dbConn->prepare($sql4);
				$query4->execute(array(':id' => $itemid));
while($row4 = $query4->fetch(PDO::FETCH_ASSOC))
		{
			$sql2 = "UPDATE `tbl_stocks` SET `stock_quantity` = `stock_quantity` + :item_quantity WHERE `stock_name` = :item_name;";
			$query2 = $dbConn->prepare($sql2);
			$query2->execute(array(':item_quantity' => $row4['item_quantity'], ':item_name' => $row4['item_name']));
			
			$sql3 = "UPDATE `tbl_transaction` SET `transaction_total` = `transaction_total` - :item_total, `transaction_change` = transaction_change + :item_total WHERE `transaction_id` = :trans_id;";
			$query3 = $dbConn->prepare($sql3);
			$query3->execute(array(':item_quantity' => $row4['item_quantity'], ':trans_id' => $row4['transaction_id'], ':item_total' => $row4['item_total']));
			
			$sql = "DELETE FROM tbl_transaction_items WHERE item_id=:id";
			$query = $dbConn->prepare($sql);
			$query->execute(array(':id' => $_GET['item_id']));
		}

//redirecting to the display page (index.php in our case)
header("Location:history_details.php?id=".$id);
?>
