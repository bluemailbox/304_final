<?php
session_start();
include 'auth.php';
include "header.php";
?>
<html>
<head>
<title>Danny Decheetos Gamers R Us - Review Information</title>
</head>
<body>
<?php
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);

    /* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}
    $productName = $_GET['rname'];
    $productId = $_GET['rid'];
    $comment = $_GET['Comment'];
    $rating = $_GET['Rating'];
    $date = date("Y/m/d H:i:s");

    $sql2 = "SELECT customerId FROM customer WHERE userid = ?";
    $webUsername = $_SESSION['authenticatedUser'];
    $pstmt2 = sqlsrv_query($con, $sql2, array($webUsername));
    $rst2 = sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC);
    $custId = $rst2['customerId'];
   

    $sql = "INSERT INTO Review (reviewRating, reviewDate, customerId, productId, reviewComment) VALUES ( ?, ?, ?, ?, ? );";

    $pstmt = sqlsrv_query($con, $sql, array($rating, $date, $custId, $productId, $comment));
    $rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);
    $sql3 = "SELECT productId, C.customerId, reviewRating, reviewDate, reviewComment, userId FROM Review R, Customer C WHERE R.customerId = C.customerId AND productId = ? AND customerId = ? ORDER BY reviewDate";
    $pstmt3 = sqlsrv_prepare($con, $sql3, array($productId, $custId));
    $rst3 = sqlsrv_fetch_array($pstmt3, SQLSRV_FETCH_ASSOC);
    echo("<h2>Review succesfully created!</h2>");
    sqlsrv_close($con);
?>
<h2><a href="listprod.php">Back to Shopping</a></h2>
</body>
</html>