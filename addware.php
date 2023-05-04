<?php
session_start();
include "header.php";

$newProd = addWare();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Add Warehouse</title>
</head>
<body>
<h1>Add a Warehouse</h1>

<form method="post" action="addware.php" enctype="multipart/form-data"> 
<table class='center' style='width:40%'>
<tr><td>
   New Warehouse Name:<input type="text" name="wname" size="10" maxlength="10">
   
   <input type="submit" value="Add"> </td></tr>
</form>
</table>

<?php 
// put add warehouse info into database
function addWare() {
    $wname = $_POST['wname'];

    if (!isset($_POST['wname'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($wname) == 0) {
        return NULL; //make sure all fields have been entered
    }
    $sql = "INSERT INTO warehouse (warehouseName) VALUES (?)";//add whouse info
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $pstmt = sqlsrv_prepare($con, $sql, array($wname));//
    sqlsrv_execute($pstmt); //execute sql insert
    $retStr = $wname;
    
    sqlsrv_close($con);//close connection

    echo("<h3>" . $retStr . " has been added!</h3>" ); //confirms item is added
}
?>
<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>