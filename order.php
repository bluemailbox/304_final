<?php
include 'auth.php';
session_start();
include "header.php";

	// Get customer id
	$custId = "";
	if(isset($_GET['customerId'])){
		$custId = $_GET['customerId'];
	} else {
		die("<h1>Invalid customer id.  Go back to the previous page and try again.</h1>");
	}

	$payment = "";
	if(isset($_GET['payment'])){
		$payment = $_GET['payment'];
	} else {
		die("<h1>Invalid payment info.  Go back to the previous page and try again.</h1>");
	}

	$address = "";
	if(isset($_GET['address'])){
		$address = $_GET['address'];
	} else {
		die("<h1>Invalid address.  Go back to the previous page and try again.</h1>");
	}

	$pin = "";
	if(isset($_GET['pin'])){
		$pin = $_GET['pin'];
	} else {
		die("<h1>Invalid pin.  Go back to the previous page and try again.</h1>");
	}

	session_start();
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="mystyle.css">
<title>Ray's Grocery Order Processing</title>
</head>
<body>

<?php
	$productList = null;
	if (isset($_SESSION['productList'])){
		$productList = $_SESSION['productList'];
	} else {
		die("<h1>Your shopping cart is empty!</h1>");
	}

	if(!is_numeric($custId)){
		die("<h1>Invalid customer id.  Go back to the previous page and try again.</h1>");
	}

	if(!is_numeric($payment) || strlen($payment) > 16 || strlen($payment) < 16){
		die("<h1>Invalid payment info.  Go back to the previous page and try again.</h1>");
	}

	if(!is_string($address)){
		die("<h1>Invalid address.  Go back to the previous page and try again.</h1>");
	}

	if(!is_numeric($pin) || strlen($pin) < 3 || strlen($pin) > 3){
		die("<h1>Invalid pin.  Go back to the previous page and try again.</h1>");
	}
	
    $custId = intval($custId);
    $sql = "SELECT customerId, firstName+' '+lastName as cname FROM Customer WHERE customerId = ?";	
	

	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);

	$pstmt = sqlsrv_query($con, $sql, array( $custId ));
	
	$orderId=0;
	$custName = "";

		if($rst = sqlsrv_fetch_array( $pstmt, SQLSRV_FETCH_ASSOC)) {
			$custName = $rst['cname'];

			// Enter order information into database
			$orderDate = date('Y-m-d H:i:s');			
            $sql2 = "INSERT INTO OrderSummary (customerId, totalAmount, orderDate) OUTPUT INSERTED.orderId VALUES(?, 0, ?);";

			$pstmt2 = sqlsrv_query($con, $sql2, array($custId, $orderDate));
			if(!sqlsrv_fetch($pstmt2)){
			    if( ($errors = sqlsrv_errors() ) != null) {
			        foreach( $errors as $error ) {
			            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
			            echo "code: ".$error[ 'code']."<br />";
			            echo "message: ".$error[ 'message']."<br />";
			        }
			    }
				die( print_r( sqlsrv_errors(), true));
			}
			
			$orderId = sqlsrv_get_field($pstmt2,0);			
			
			echo("<h1>Your Order Summary</h1>");
      	  	echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");

        	$total =0;
        	foreach ($productList as $id => $prod) {
                echo("<tr><td>".$prod['id']."</td>");
                echo("<td>".$prod['name']."</td>");
				echo("<td align=\"center\">".$prod['quantity']."</td>");
                $price = doubleval($prod['price']);
				echo("<td align=\"right\">$". number_format($price, 2)."</td>");
               	echo("<td align=\"right\">$". number_format($price*$prod['quantity'], 2)."</td></tr>");
                echo("</tr>");
                $total = $total +$price*$prod['quantity'];

				$sql3 = "INSERT INTO OrderProduct VALUES(?, ?, ?, ?)";
				$pid = intval($prod['id']);
				sqlsrv_query($con, $sql3, array($orderId, $pid, $prod['quantity'], $prod['price']) );
        	}
        	echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td>" .
                       	"<td aling=\"right\">$" . number_format($total, 2)."</td></tr>");
        	echo("</table>");

			// Update order total
			$sql4 = "UPDATE OrderSummary SET totalAmount=? WHERE orderId=?";
			sqlsrv_query($con, $sql4, array( $total, $orderId));

			echo("<h1>Order completed.  Will be shipped soon...</h1>");
			echo("<h1>Your order reference number is: ".$orderId."</h1>");
			echo("<h1>Shipping to customer: ".$custId." Name: ".$custName. " At address: " .$address. " By card # " .$payment. "</h1>");

			echo("<h2><a href=\"index.php\">Return to shopping</a></h2>");
			
			// Clear session variables (cart)
			$_SESSION['productList'] = null;
		} else {
			die("<h1>Invalid customer id.  Go back to the previous page and try again.</h1>");
		}
		sqlsrv_close($con);
?>
</body>
</html>

