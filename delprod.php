<?php
include 'adminauth.php';
session_start();
include "header.php";

$delProd = delProd();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Edit Products</title>
</head>
<body>
<h1>Delete an existing item</h1> 

<form method="post" action="delprod.php">
<table class='center' style='width:40%'>   
<tr>
<td>Name of Product you wish to delete:<input type="text" name="d_name" size="10">
   
   <td><input type="submit" value="Delete"> </td></tr>
</form>
</table>
<?php
// delete prod info from database
function delProd() {
    $d_name = $_POST['d_name']; //which prod to delete

    if (!isset($_POST['d_name'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($d_name) == 0) {
        return NULL; //make sure the field has been filled
    }
     //delete all of prod info.
        $sql = "DELETE FROM product WHERE productName = ?";//
        include 'include/db_credentials.php';
        $con = sqlsrv_connect($server, $connectionInfo);
        
        /* Try/Catch connection errors */
        if( $con === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    
        $pstmt1 = sqlsrv_prepare($con, $sql, array($d_name));//
        sqlsrv_execute($pstmt1); //execute sql insert
        $retStr = $d_name;//output new name
        
        sqlsrv_close($con);//close connection
    
        echo("<h3>" . $retStr . " has been deleted.</h3>" ); //confirms item is deleted	
}
?>

<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>