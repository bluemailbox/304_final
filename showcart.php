<?php
// Get the current list of products
session_start();
include "header.php";
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<title>Your Shopping Cart</title>
</head>
<body>
<?php //display login info
	$webUsername = $_SESSION['authenticatedUser'];
	if ($webUsername) {
		echo("<h3 align=\"right\">Signed in as: " . $webUsername . "</h3>");
	}
?>

<?php //cart contents
$productList = null;
if(isset($_GET['delete'])){
	$delete = $_GET['delete'];}
if(isset($_GET['pid'])){
	$pid = $_GET['pid'];}
if (isset($_GET['Quantity'])){
	$quantity = $_GET['Quantity'];}
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
    foreach ($productList as $id => $prod) {
	    if($prod['id']==$delete) {
			unset($productList[$delete]); }	
		if($prod['id']==$pid) {
			$productList[$id]['quantity'] = $quantity; 
		}
	}
	$_SESSION['productList']=$productList;
}
if($_SESSION['productList']!=null){
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
	echo("<h1>Your Shopping Cart</h1>");
	echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th>");
	echo("<th>Price</th><th>Subtotal</th></tr>");
	
	$total =0;
	foreach ($productList as $id => $prod) {
		echo("<tr><td>". $prod['id'] . "</td>");
		echo("<td>" . $prod['name'] . "</td>");
		$price = $prod['price'];
?>
        <td align=\"center\"> <form method="get" action="showcart.php"><input type="int" name="Quantity" value=<?php echo($prod['quantity']);?>  size="2"></td>
		<input type="hidden" name="pid" value=<?php echo($prod['id']);?>  size="2">
<?php

		echo("<td align=\"right\">$" . number_format($price ,2) ."</td>");
		echo("<td align=\"right\">$" . number_format($prod['quantity']*$price, 2) . "</td>");
		echo("<td><a href=\"showcart.php?delete=".$prod['id']."\">Remove Item from Cart</a></td>");
?>
        <td><input type="submit" value="Update Quantity"></form></td>
<?php
		echo("</tr>");
		$total = $total +$prod['quantity']*$price;  
	}
	echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td><td align=\"right\">$" . number_format($total,2) ."</td></tr>");
	echo("</table>"); 

	echo("<h2><a href=\"checkout.php\">Check Out</a></h2>");
} else {
	echo("<H1>Your shopping cart is empty!</H1>");
}
$_SESSION['productList']=$productList;
} else {
	echo("<H1>Your shopping cart is empty!</H1>");
}
?>
<h2><a href="listprod.php">Continue Shopping</a></h2>
</body>
</html>