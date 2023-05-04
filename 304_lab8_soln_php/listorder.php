<?php
include 'auth.php';
include "header.php";
session_start();
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<title>Order Listing</title>
</head>
<body>

<h1>Order List</h1>

<?php
$webUsername = $_SESSION['authenticatedUser'];
$sql = "SELECT orderId, O.CustomerId, totalAmount, firstName+' '+lastName as cname, orderDate FROM OrderSummary O, Customer C WHERE O.customerId = C.customerId AND userid = ?";

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

$pstmt = sqlsrv_query($con, $sql, array($webUsername));
echo("<table border=\"1\"><tr><th>Order Id</th><th>Order Date</th><th>Customer Id</th><th>Customer Name</th><th>Total Amount</th></tr>");

// Use a PreparedStatement as will execute many times
$orderId = 0;
$pstmt2 = sqlsrv_prepare($con, "SELECT productId, quantity, price FROM OrderProduct WHERE orderId=?",array(&$orderId));

while ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) {
    $orderId = $rst['orderId'];
    $orderDate = $rst['orderDate']; 
	echo("<tr><td>".$orderId."</td>");
	echo("<td>".$orderDate->format('Y-m-d H:i:s')."</td>");
	echo("<td>".$rst['CustomerId']."</td>");
	echo("<td>".$rst['cname']."</td>");
	echo("<td>$".number_format($rst['totalAmount'],2)."</td>");
	echo("</tr>");

	// Retrieve all the items for an order	
	sqlsrv_execute($pstmt2);
	/*
	if( ($errors = sqlsrv_errors() ) != null) {
	    foreach( $errors as $error ) {
	        echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
	        echo "code: ".$error[ 'code']."<br />";
	        echo "message: ".$error[ 'message']."<br />";
	    }
	}
	*/
	echo("<tr align=\"right\"><td colspan=\"5\"><table border=\"1\">");
	echo("<th>Product Id</th> <th>Quantity</th> <th>Price</th></tr>");
	while ($rst2 = sqlsrv_fetch_array( $pstmt2, SQLSRV_FETCH_ASSOC)) {	  
		echo("<tr><td>".$rst2['productId']."</td>");
		echo("<td>".$rst2['quantity']."</td>");
		echo("<td>$" . number_format($rst2['price'],2)."</td></tr>");
	}
	echo("</table></td></tr>");
}
echo("</table>");
sqlsrv_free_stmt($pstmt2);
sqlsrv_close($con);
?>
</body>
</html>