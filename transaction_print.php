<?php
include('config.php');

	$trans_id=$_GET['trans_id'];
   
	$sql = "SELECT * FROM tbl_transaction_items WHERE transaction_id=:trans_id";
				$query = $dbConn->prepare($sql);
				$query->execute(array(':trans_id' => $trans_id));
					
	$sql2 = "SELECT item_id,SUM(item_total) as trans_total, transaction_id FROM tbl_transaction_items WHERE transaction_id =:trans_id GROUP BY transaction_id";
				$query2 = $dbConn->prepare($sql2);
				$query2->execute(array(':trans_id' => $trans_id));
	
	$sql3 = "SELECT * FROM tbl_transaction WHERE transaction_id=:trans_id";
				$query3 = $dbConn->prepare($sql3);
				$query3->execute(array(':trans_id' => $trans_id));

//print operation
require __DIR__ . '/escpos-php-mike42/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
try {
	// Enter the share name for your USB printer here
	$connector = new WindowsPrintConnector("POS-58");
	$printer = new Printer($connector);

	//Print some bold text
	$printer -> setFont(Printer::FONT_A);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setEmphasis(true);
	$printer -> text("SANTOR HARDWARE\nF.A.G. ENTERPRISES\n");
	$printer -> text("Rizal Street Barangay Santor\nBongabon Nueva Ecija\n\n");
	$printer -> text("==========================================\n");
	$printer -> setEmphasis(false);
	$printer -> feed();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$item_quantity = $row['item_quantity'] + 0;
			$item_price = $row['item_price'] + 0;
			$item_total = $row['item_total'] + 0;
			$printer -> text($item_quantity ." ".$row['item_unit']."   " . $row['item_name'] . " @ P". $item_price ." = P". $item_total . "\n");
		}
	$printer -> setEmphasis(false);
	$printer -> setJustification(Printer::JUSTIFY_RIGHT);
	while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
	{
		$trans_total = $row2['trans_total'] + 0;
		$printer -> text("\n\nAmount Due: P".$trans_total."\n");
	}
	while($row3 = $query3->fetch(PDO::FETCH_ASSOC))
	{
		$transaction_cash = $row3['transaction_cash'] + 0;
		$transaction_change = $row3['transaction_change'] + 0;
		$printer -> text("Cash: P".$transaction_cash."\n");
		$printer -> text("Change: P".$transaction_change."\n\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("\nDate: ".$row3['transaction_date']."");
		$printer -> text("\nCustomer Name: ".$row3['transaction_customer']."\n");
	}
	$printer -> text("Transaction Number: ".$trans_id."\n\n");
	$printer -> setEmphasis(true);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> text("==========================================\n\n");
	$printer -> text("THIS SERVES AS YOUR PROOF OF PURCHASE\n");
	$printer -> text("Thank you! Please come again.\n");
	$printer -> feed(4);
	
	//Close printer
	$printer -> close();
} catch(Exception $e) {
	echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}


header('Location: transaction_success.php?trans_id='.$trans_id.'&trans_change='.$_GET['trans_change'].'')
?>