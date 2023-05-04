<?php
session_start();
include "header.php";

$newProd = editWare();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Edit Warehouse</title>
</head>
<body>
<h1>Edit a Warehouse</h1> 

<form method="post" action="editware.php" enctype="multipart/form-data"> 
<table class='center' style='width:40%'>
<tr><td>Old Warehouse Name:<input type="text" name="wname" size="10" maxlength="10"></td></tr>
<tr><td>New Warehouse Name:<input type="text" name="nname" size="10" maxlength="10"></td></tr>
   
<tr><td><input type="submit" value="Add"></td></tr>
</table>
</form>

<?php 
// put add warehouse info into database
function editWare() {
    $wname = $_POST['wname'];
    $nname = $_POST['nname']; 

    if (!isset($_POST['wname']) || !isset($_POST['nname'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($wname) == 0 || strlen($nname) == 0) {
        return NULL; //make sure all fields have been entered
    }
    $sql = "UPDATE warehouse SET warehouseName=? WHERE warehouseName=?";//add whouse info
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $pstmt = sqlsrv_prepare($con, $sql, array($wname, $nname));//
    sqlsrv_execute($pstmt); //execute sql insert
    $retStr = $wname;
    $retStr1 = $nname;

    sqlsrv_close($con);//close connection

    echo("<h3>" . $retStr . " has been updated to " . $retStr1 . "</h3>" ); //confirms item is added
}
?>
<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>