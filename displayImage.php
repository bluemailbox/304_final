<?php
header("Content-Type: image/jpeg");

$id = $_GET['id'];

if ($id == null) {
    return;
}

$idVal = -1;
try {
    $idVal = (int)$id;
} catch (Exception $e) {
    return;
}

$sql = "SELECT productImage FROM Product P  WHERE productId = ?";

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$pstmt = sqlsrv_prepare($con, $sql, array($idVal));
sqlsrv_execute($pstmt);

$rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);

$image = $rst['productImage'];
echo($image);

sqlsrv_close($con);
?>
