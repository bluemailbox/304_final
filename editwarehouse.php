<?php
session_start();
include 'header.php';

?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Add/Edit Warehouses</title>
</head>
<?php 
echo("<h2><a href=\"admin.php\">Return to Admin</a></h2>");
    $edit = (int)$_GET['wId'];
?>
<body>


<form>
    <br>
    <table>
    <tr>
    <h2>Add/Edit Products in Warehouse: (warehouseId = <?php echo($edit);?>)</h2>
    </tr>
    <table>
    <tr>
        <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="4">Product Id:</font></div></td>
        <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="4">Quantity:</font></div></td>
    </tr>  
    
     <tr>
        <input type="hidden" name = "wId" value = <?php echo($edit);?>>
        <td><input type="number" name="pId" size="5"></td>
        <td><input type="number" name="q" size="5"></td>
     </tr>

     </table><br>
     <table>
    <tr>
    <h2>Delete Products in Warehouse:</h2>
    <table>
    <tr>
        <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="4">Product Id:</font></div></td>
    </tr><tr>
        <td><input type="number" name="dId" size="5"></td>
    </tr></table><br>
    <input type="submit" value="Submit" ><input type="reset" value="Reset">
</form>
<?php
include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$delete = $_GET['dId'];
$pId = $_GET['pId'];
$q = $_GET['q'];

if($delete!=null){

$sql4 = "DELETE FROM productInventory WHERE productId = ? AND warehouseId = ?";
$pstmt4 = sqlsrv_prepare($con, $sql4, array($delete, $edit));
sqlsrv_execute($pstmt4);

}
if($q!=null || $pId!=null){

$sql = "SELECT productId FROM productinventory WHERE warehouseId = ?";
$pstmt = sqlsrv_prepare($con, $sql, array($edit));
sqlsrv_execute($pstmt);
$rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);

if($pId==$rst['productId']){

    $sql2 = "UPDATE productInventory SET quantity = ?, price = ? WHERE productId = ? AND warehouseId = ?";

} else {

    $sql2 = "INSERT INTO productInventory (quantity, price, productId, warehouseId ) VALUES (?,?,?,?)";

}

//gets product price
$sql3 = "SELECT productPrice FROM product WHERE productId = ?";
$pstmt3 = sqlsrv_query($con, $sql3, array($pId));
$rst3 = sqlsrv_fetch_array($pstmt3, SQLSRV_FETCH_ASSOC);
$price =$rst3['productPrice'];

$pstmt2 =sqlsrv_prepare($con, $sql2, array($q, $price, $pId, $edit));
sqlsrv_execute($pstmt2);

}

?>
</body>
</html>
<?php
include 'showWarehouses.php';
?>