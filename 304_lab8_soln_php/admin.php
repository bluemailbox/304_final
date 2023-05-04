<?php
include 'adminauth.php';
session_start();
include "header.php";
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Administrator Page</title>
</head>
<body>

<?php
$adminUsername = $_SESSION['authenticatedAdmin'];

echo("<h3>Administrator Sales Report by Day</h3>");

$sql = "SELECT year(orderDate), month(orderDate), day(orderDate), SUM(totalAmount) FROM OrderSummary GROUP BY year(orderDate), month(orderDate), day(orderDate)";
include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$pstmt = sqlsrv_query($con, $sql);

echo("<table class=\"table\" border=\"1\">");
echo("<tr><th>Order Date</th><th>Total Order Amount</th></tr>");	
while(sqlsrv_fetch($pstmt)) {
    echo("<tr><td>".sqlsrv_get_field($pstmt, 0)."-".sqlsrv_get_field($pstmt, 1)."-".sqlsrv_get_field($pstmt, 2)."</td><td>$".number_format(sqlsrv_get_field($pstmt, 3),2)."</td></tr>");
}
echo("</table><br><br>");
echo("<h2>List of Warehouses:</h2>");
$sql3 = "SELECT warehouseId, warehouseName FROM warehouse W ORDER BY warehouseId ASC";
$pstmt3 = sqlsrv_query($con, $sql3);
$sql4 = "SELECT I.productId, quantity, productName FROM productinventory I, product P WHERE warehouseId = ? AND I.productId = P.productId ORDER BY productId ASC";
$pstmt4 = sqlsrv_query($con, $sql4);

echo("<table class=\"table\" border=\"1\">");
echo("<h2>Current Warehouses:</h2>");
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
echo("</table><br>");

$sql2 = "SELECT customerId, firstName, lastName, email, phonenum, C.address a, city, C.state s, postalCode, country, userid, password FROM customer C ORDER BY customerId ASC";
$pstmt2 = sqlsrv_query($con, $sql2);
echo("<h2>List of Customers:</h2>");
echo("<table class=\"table\" border=\"1\">");
echo("<tr><th>Registered Customers:</th></tr>");
echo("<tr><th>ID</th><th>User Id</th><th>Name</th><th>Email</th><th>Number</th><th>Address</th><th>City</th><th>State</th><th>Country</th><th>PostalCode</th></tr>");
while($rst=sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC)) {
    echo("<tr><td><a href=\"editcust.php?cid=" . $rst['customerId'] . "\">Edit Customer</a></td><td>". $rst['userid'] . "</td><td>". $rst['firstName'] . " " . $rst['lastName'] . "</td><td>". $rst['email'] . "</td><td>". $rst['phonenum'] . "</td><td>". $rst['a'] . "</td><td>". $rst['city'] . "</td><td>" . $rst['s'] . "</td><td>". $rst['country'] . "</td><td>". $rst['postalCode'] . "</td></tr>");    
}

echo("/<table>");

echo("<h2><a href=\"addprod.php\">Add Products</a></h2>"); //add product button
echo("<h2><a href=\"editprods.php\">Edit Products</a></h2>"); //update product button
echo("<h2><a href=\"delprod.php\">Delete Product</a></h2>"); //delete product button

echo("<h2><a href=\"addcust.php\">Add Customer</a></h2>"); //add customer button

echo("<h2><a href=\"addware.php\">Add Warehouse</a></h2>"); //add warehouse button
echo("<h2><a href=\"editware.php\">Edit Warehouse</a></h2>"); //edit warehouse button


sqlsrv_close($con);
?>
