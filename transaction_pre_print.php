<?php
date_default_timezone_set('Asia/Singapore');
include_once('config.php');

 if (isset($_POST['printReciept'])) 
{
	$trans_total=$_POST['trans_total'];
	$trans_id=$_POST['trans_id'];
	$cash_given=$_POST['cash_given'];
	$customer_name=$_POST['customer_name'];
	
	
	if(empty($cash_given) || empty($trans_total))
	{	
		echo "<script type='text/javascript'>
        alert('Your transaction does not contain any items.');
        location = 'transaction_new.php?trans_id=". $trans_id ."';
      </script>";
	}
	else
	{
		if ($trans_total > $cash_given)
		{
			echo "<script type='text/javascript'>
			alert('The payment recieved is not enough.');
			location = 'transaction_new.php?trans_id=". $trans_id ."';
		  </script>";
		}
		else
		{
			$change = $cash_given - $trans_total;
			//echo "AA: ". $trans_total . " ".$trans_id." ".$change;
					
			$sql = "UPDATE tbl_transaction SET transaction_total=:trans_total, transaction_cash=:cash_given, transaction_change=:change, transaction_customer=:customer_name, transaction_date=now() WHERE transaction_id=:trans_id";
				$query = $dbConn->prepare($sql);
						
				$query->bindparam(':trans_id', $trans_id);
				$query->bindparam(':trans_total', $trans_total);
				$query->bindparam(':cash_given', $cash_given);
				$query->bindparam(':change', $change);
				$query->bindparam(':customer_name', $customer_name);
				$query->execute();
				
				
			$sql4 = "SELECT * FROM tbl_transaction_items WHERE transaction_id = :id ";
				$query4 = $dbConn->prepare($sql4);
				$query4->execute(array(':id' => $trans_id));
				while($row4 = $query4->fetch(PDO::FETCH_ASSOC))
						{	
							$sql2 = "UPDATE `tbl_stocks` SET `stock_quantity` = `stock_quantity` - :item_quantity WHERE `stock_name` = :item_name;";
							$query2 = $dbConn->prepare($sql2);
							$query2->execute(array(':item_quantity' => $row4['item_quantity'], ':item_name' => $row4['item_name']));
						}
		
			header("Location:transaction_print.php?trans_id=".$trans_id."&trans_change=". $change ."");	
		}
	}		
}
?>