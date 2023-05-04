<?php
session_start();
include "header.php";
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Game Store</title>
</head>
<body>

<h1>Search for the products you want to buy:</h1>

<form method="get" action="listprod.php">
<select size="1" name="categoryName">
  <option>All</option>
  <option>Consoles</option>
  <option>Accessories</option> 
  <option>Rouge-Like</option>
  <option>Local Multiplayer</option> 
  <option>Simulator</option> 
  <option>Violent</option> 
  <option>Horror</option> 
  <option>Online Multiplayer</option> 
  <option>Bullet Hell</option>
  <option>Simulator</option> 
  <option>Story Heavy</option> 
  <option>Survival</option> 
  <option>Platformer</option>  
  </select>
<input type="text" name="productName" size="50">
<input type="submit" value="Submit"><input type="reset" value="Reset"> (Leave blank for all products)
</form>


<?php
	// Get product/category name to search for
	$name = "";
	$category = "";
	if (isset($_GET['productName'])){
		$name = $_GET['productName'];
	}
	if (isset($_GET['categoryName'])){
		$category = $_GET['categoryName'];
	}
	$hasNameParam = $name != NULL && $name !== "";
	$hasCategoryParam = $category != NULL && $category !== "" && $category !== "All";
	$sql = "";
	$filter = "";

	if ($hasNameParam && $hasCategoryParam) {
		$filter = "<h2>Products containing '".$name."' in category: '".$category."'</h2>";
		$name = '%'.$name.'%';
		$sql = "SELECT productId, productImageURL, productName, productPrice, categoryName FROM Product P JOIN Category C ON P.categoryId = C.categoryId WHERE productName LIKE ? AND categoryName = ? ORDER BY P.productName ASC";
	} else if ($hasNameParam) {
		$filter = "<h2>Products containing '".$name."'</h2>";
		$name = '%'.$name.'%';
		$sql = "SELECT productId, productName, productImageURL, productPrice, categoryName FROM Product P JOIN Category C ON P.categoryId = C.categoryId WHERE productName LIKE ? ORDER BY P.productName ASC";
	} else if ($hasCategoryParam) {
		$filter = "<h2>Products in category: '".$category."'</h2>";
		$sql = "SELECT productId, productName, productImageURL, productPrice, categoryName FROM Product P JOIN Category C ON P.categoryId = C.categoryId WHERE categoryName = ? ORDER BY P.productName ASC";
	} else {
		$filter = "<h2>All Products</h2>";
		$sql = "SELECT productId, productName, productImageURL, productPrice, categoryName FROM Product P JOIN Category C ON P.categoryId = C.categoryId ORDER BY P.productName ASC";
	}

	echo($filter);

	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
	$pstmt = null;
	if ($hasNameParam) {
		if ($hasCategoryParam) {
			$pstmt = sqlsrv_prepare($con, $sql, array(&$name, &$category));
		} else {
			$pstmt = sqlsrv_prepare($con, $sql, array(&$name));
		}
	} else if ($hasCategoryParam) {
		$pstmt = sqlsrv_prepare($con, $sql, array(&$category));
	} else {
		$pstmt = sqlsrv_prepare($con, $sql, array());
	}

	sqlsrv_execute($pstmt);
	
	echo("<table><tr><th></th><th>Product Image</th><th>Product Name</th><th>Price</th></tr>");
	while ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) {
		echo("<tr><td><a href=\"addcart.php?id=" . $rst['productId'] . "&image" . $imageLoc . "&name=" . $rst['productName']. "&price=" . $rst['productPrice'] . "\">Add to Cart</a></td>");
		echo("<td><img src=\"".$rst['productImageURL']."\"style=\"width:150px;height:150px\"></td><td><a href=\"product.php?id=" . $rst['productId'] . "\">" . $rst['productName'] . "</a></td><td>$" . $rst['productPrice'] . "</td></tr>");
	}
	echo("</table>");
	
	sqlsrv_close($con);
?>
</body>
</html>