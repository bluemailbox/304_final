<html>
<head>
<title>Shipment Processing Page</title>
</head>
<body>

<?php
$orId = (int)$_GET['orderId'];

if ($orId == null || $orId === "") {
    echo("<h1>Invalid order id.</h1>");
} else {
    include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $sql = "SELECT orderId, productId, quantity, price FROM orderproduct WHERE orderId = ?";	
    
	$pstmtg = sqlsrv_prepare($con, $sql, array($orId));
	sqlsrv_execute($pstmtg);
    $rst = sqlsrv_fetch_array($pstmtg, SQLSRV_FETCH_ASSOC);
    
    if (!$rst) {
   		echo("<h1>Invalid order id or no items in order.</h1>");
    } else {
        sqlsrv_begin_transaction($con);

        $sql = "INSERT INTO shipment (shipmentDate, warehouseId) VALUES (?, 1);";
        $pstmt = sqlsrv_prepare($con, $sql, array(date("Y-m-d H:i:s")));
        sqlsrv_execute($pstmt);

        $sqlq = "SELECT quantity FROM productinventory WHERE warehouseId = 1 and productId = ?";
        $prodId = null;
        $pstmtq = sqlsrv_prepare($con, $sqlq, array(&$prodId));
        $success = true;

        $sql = "UPDATE productinventory SET quantity = ? WHERE warehouseId = 1 and productId = ?";
        $available = null;
        $pstmt = sqlsrv_prepare($con, $sql, array(&$available, &$prodId));

        do {
            $prodId = $rst['productId'];
            $qty = $rst['quantity'];
            $resq = sqlsrv_execute($pstmtq);
            $rstq = sqlsrv_fetch_array($pstmtq, SQLSRV_FETCH_ASSOC);
            if (!$resq || $rstq['quantity'] < $qty) {
                // No inventory record
                echo("<h1>Shipment not done. Insufficient inventory for product id: ".$prodId."</h1>");
                $success = false;
                break;
            }

            // Update inventory record
            $inventory = $rstq['quantity'];
            $available = $inventory - $qty;
            sqlsrv_execute($pstmt);

            echo("<h2>Ordered product: ".$prodId." Qty: ".$qty." Previous inventory: ".$inventory." New inventory: ".($inventory-$qty)."</h2><br>");
        } while($rst = sqlsrv_fetch_array($pstmtg, SQLSRV_FETCH_ASSOC));

        // Commit or rollback
        if (!$success) {
            sqlsrv_rollback($con);
        } else {
            echo("<h1>Shipment successfully processed.</h1>");
            sqlsrv_commit($con);
        }
    }
	sqlsrv_close($con);
}
?>

<h2><a href="shop.html">Back to Main Page</a></h2>

</body>
</html>
