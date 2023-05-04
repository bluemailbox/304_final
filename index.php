<?php
session_start();
include "header.php";
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="mystyle.css">
<head>
        <title>Danny DeCheeto's VideoGame store</title>
</head>
<body>
<img src="img/decheeto2.png" class = "leftpic" alt="Get your mouse off me!" width="300" height="200"> 
<img src="img/decheeto2.png" class = "rightpic" alt="Get your mouse off me!" width="300" height="200">
        <h2 align = "center">Welcome! Danny DeCheeto's VideoGame store is all about gaming for gamers. Danny DeCheeto’s World of Video Games provides a unique experience to satisfy all gamer shopping needs!</h2>
<?php    

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT TOP 3 productId, AVG(reviewRating) AS RR FROM review GROUP BY productId ORDER BY RR DESC ";
$pstmt = sqlsrv_query($con, $sql, array());

$productId = 0;
$pstmt2 = sqlsrv_prepare($con, "SELECT productId, productName, productPrice, productImageURL FROM product WHERE productId=?",array(&$productId));

echo("<h1 style='text-align:center;'>Highest rated products:</h1>");

while ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) {
        $productId = $rst['productId'];
        sqlsrv_execute($pstmt2);
        while ($rst2 = sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC)) {	
        echo("<h1 style='text-align:center;'><a href=\"product.php?id=" . $rst2['productId'] . "\">" . $rst2['productName'] . "</a></h1>");
        echo("<table class='center' style='width:40%'><tr>");
        echo("<th>Price:</th><td>$" . number_format($rst2['productPrice'],2) . "</td></tr><tr><th>Rating:</th><td>" . $rst['RR'] . "</td></tr>");

        $imageLoc = $rst2['productImageURL'];
        if ($imageLoc != null)
            echo("<img src=\"".$imageLoc."\" class='center'>");
            echo("</table>");
        }
}    
    sqlsrv_free_stmt($pstmt2);
sqlsrv_close($con);
?>
</body>
</head>