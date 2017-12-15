<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table and adding back stocks
$sql4 = "SELECT * FROM tbl_transaction_items WHERE transaction_id = :id ";
				$query4 = $dbConn->prepare($sql4);
				$query4->execute(array(':id' => $id));
while($row4 = $query4->fetch(PDO::FETCH_ASSOC))
		{	
			$sql2 = "UPDATE `tbl_stocks` SET `stock_quantity` = `stock_quantity` + :item_quantity WHERE `stock_name` = :item_name;";
			$query2 = $dbConn->prepare($sql2);
			$query2->execute(array(':item_quantity' => $row4['item_quantity'], ':item_name' => $row4['item_name']));
			
			$sql = "DELETE FROM tbl_transaction WHERE transaction_id=:id";
			$query = $dbConn->prepare($sql);
			$query->execute(array(':id' => $id));
		}
		
$sql3 = "DELETE FROM tbl_transaction WHERE transaction_id=:id";
			$query3 = $dbConn->prepare($sql3);
			$query3->execute(array(':id' => $id));

//redirecting to the display page (index.php in our case)
header("Location:history_view.php");
?>
