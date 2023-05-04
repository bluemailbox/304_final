<?php
include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }
    $sql3 = "SELECT warehouseId, warehouseName FROM warehouse W ORDER BY warehouseId ASC";
    $pstmt3 = sqlsrv_query($con, $sql3);
    $sql4 = "SELECT productId, quantity, price FROM productinventory WHERE warehouseId = ? ORDER BY productId ASC";
    $pstmt4 = sqlsrv_query($con, $sql4);
    
    echo("<table class=\"table\" border=\"1\">");
    while($rst3=sqlsrv_fetch_array($pstmt3, SQLSRV_FETCH_ASSOC)) {
    echo("<tr><th>Warehouse:</th><th><a href=\"editwarehouse.php?wId=" . $rst3['warehouseId'] . "\">Edit Warehouse:</a></th></tr>");   
    echo("<tr><th>ID</th><th>Name</th></tr>");
    echo("<tr><td>" . $rst3['warehouseId'] ."</td><td>" . $rst3['warehouseName'] ."</td></tr>");
    echo("<tr align=\"right\"><td colspan=\"5\"><table border=\"1\">");
    echo("<th>Product ID</th><th>Quantity</th><th>Price:</th></tr>");
    $pstmt4 = sqlsrv_query($con, $sql4, array($rst3['warehouseId']));
    while($rst4=sqlsrv_fetch_array($pstmt4, SQLSRV_FETCH_ASSOC)) {
        echo("<tr><td>" . $rst4['productId'] ."</td><td>" . $rst4['quantity'] ."</td><td>" . $rst4['price'] . "</td></tr>");
    
    }
    echo("</table>");
    }
    sqlsrv_close($con);
?>