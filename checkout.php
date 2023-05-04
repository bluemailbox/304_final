<?php
include 'auth.php';
session_start();
include "header.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="mystyle.css">
<title>Checkout page</title>
</head>
<body>

<h1>Enter your Customer ID, Payment Information and Shipping address to complete the transaction:</h1>

<form method="get" action="order.php">
<table style="display:inline">
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Customer Id:</font></div></td>
	<td><input type="text" name="customerId"  size=50 maxlength=2></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Card number:</font></div></td>
	<td><input type="text" name="payment" size=50 maxlength="16"></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Card CCV:</font></div></td>
	<td><input type="text" name="pin" size=50 maxlength="3"></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Shipping Address:</font></div></td>
	<td><input type="text" name="address" size=50></td>
</tr>
</table>
<br/>
<input type="submit" name="Submit" value="Checkout"><input type="reset" value="Reset">
</form>




</body>
</html>

