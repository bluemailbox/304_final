<?php
session_start();
include "header.php";

$newProd = addProd();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Add Products</title>
</head>
<body>
<h1>Add an Item</h1>  
<h2>All of the following fields are required:</h2>

<form method="post" action="upload.php" enctype="multipart/form-data">
<table class='center' style='width:40%'>   
<tr>
<td>Need to upload image first:<input type="file" name="fileToUpload" id="fileToUpload"></td>

   <td><input type="submit" value="Upload Image"> </td></tr> 
</table>
</form>
<form method="post" action="addprod.php" enctype="multipart/form-data"> 
<table class='center' style='width:40%'>
<tr><td>Product Name:<input type="text" name="pname" size="10" maxlength="10"></td></tr>
<tr><td>Product Price:<input type="text" name="pprice" size="2" step="0.01"></td></tr>
<tr><td>Product Description: <textarea name="pdesc" rows="5" cols="40"></textarea></td></tr>
<tr><td>Category ID:<input type="number" name="cid" size="2"></td></tr>
<tr><td>Name of Image(including extension) after you have uploaded:<input type="text" name="iname" size="10"></td></tr>
   
<tr><td><input type="submit" value="Add"> </td></tr>
</table>
</form>

<?php 
// put add prod info into database
function addProd() {
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pdesc = $_POST['pdesc'];
    $cid = $_POST['cid'];
    $iname =("img/" . $_POST['iname']);//directory plus name of file including extension

    if (!isset($_POST['pname']) || !isset($_POST['pprice']) || !isset($_POST['pdesc']) || !isset($_POST['cid']) || !isset($_POST['iname'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($pname) == 0 || $pprice == 0 || strlen($pdesc) == 0 || $cid == 0 || strlen($iname) == 0) {
        return NULL; //make sure all fields have been entered
    }
    $sql = "INSERT INTO product (productName, productPrice, productDesc, categoryId, productImageURL) VALUES (?, ?, ?, ?, ?)";//prod info update
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $pstmt = sqlsrv_prepare($con, $sql, array($pname, $pprice, $pdesc, $cid, $iname));//
    sqlsrv_execute($pstmt); //execute sql insert
    $retStr = $pname;
    
    sqlsrv_close($con);//close connection

    echo("<h3>" . $retStr . " has been added!</h3>" ); //confirms item is added
}
?>
<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>