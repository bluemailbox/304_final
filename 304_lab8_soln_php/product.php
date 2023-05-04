<?php
session_start();
include "header.php";
?>
<html>
<head>
<title>Danny Decheetos Gamers R Us - Product Information</title>
</head>
<body>

<?php
$productId = $_GET['id'];

$sql = "SELECT productId, productName, productPrice, productImageURL, productDesc FROM Product P WHERE productId = ?";

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}
$pstmt = sqlsrv_prepare($con, $sql, array($productId));

$result = sqlsrv_execute($pstmt);

if (!$result) {
    echo("Invalid product");
} else { 
    $rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);
    echo("<h1 style='text-align:center;'>" . $rst['productName'] . "</h1>");
		
    echo("<table><tr>");
    echo("<th>Id:</th><td>" . $rst['productId'] . "</td></tr>"				
            . "<tr><th>Price:</th><td>$" . number_format($rst['productPrice'],2) . "</td></tr>");

    //retrieve product rating
    $sql2 = "SELECT AVG(reviewRating) RR, productId FROM Review R WHERE productId = ? GROUP BY productId";
    $pstmt2 = sqlsrv_prepare($con, $sql2, array($productId));
    $result2 = sqlsrv_execute($pstmt2);
    if (!$result2) {
        echo("No Ratings");
    }else{
        $rst2 = sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC);
        echo("<tr><th>Rating:</th><td>" . $rst2['RR'] . "/10</td></tr>");
    } 
    // Retrieve product description
    echo("<tr><th>Description:</th><td>" . $rst['productDesc'] . "</td></tr>");
    
    //  Retrieve any image with a URL
    $imageLoc = $rst['productImageURL'];
    if ($imageLoc != null)
        echo("<img src=\"".$imageLoc."\" class='center' style=\"width:750px;height:500px\">");
    echo("</table>");

    
    
    echo("<h3><a href=\"addcart.php?id=" . $rst['productId'] . "&name=" . $rst['productName']
                            . "&price=" . $rst['productPrice'] . "\">Add to Cart</a></h3>");		
    
    echo("<h3><a href=\"listprod.php\">Continue Shopping</a>");

    // get reviews
    include "reviews.php";
    
    
    

}
?>

</body>
</html>
