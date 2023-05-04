<?php
session_start();
include "header.php";

$updateProd = updateProd();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Edit Products</title>
</head>
<body>
<h1>Update an already existing item</h1> 
<form method="post" action="upload.php" enctype="multipart/form-data">
<table class='center' style='width:40%'>   
<tr>
   <td>Need to upload image to change first:<input type="file" name="fileToUpload" id="fileToUpload">

   <td><input type="submit" value="Upload Image"> </td></tr>
</table>
</form> 
<table class='center' style='width:40%'>
<form method="post" action="editprods.php" enctype="multipart/form-data"></td></tr>
<tr><td>Name of Product you're changing:<input type="text" name="p_name" size="10"></td></tr>
<tr><td>Change Product Name:<input type="text" name="n_name" size="10" maxlength="10"></td></tr>
<tr><td>Change Product Price:<input type="text" name="n_price" size="2" step="0.01"></td></tr>
<tr><td>Change Product Description: <textarea name="n_desc" rows="5" cols="40"></textarea></td></tr>
<tr><td>Change Category ID: <input type="number" name="n_cid"></td></tr>
<tr><td>Name of Image(including extension) after you have uploaded:<input type="text" name="n_iname" size="10">
   
   <input type="submit" value="Edit"> </td></tr>
</form>
</table>
<?php
// put updated prod info into database
function updateProd() {
    $p_name = $_POST['p_name']; //name of prod you are changing
    $n_name = $_POST['n_name']; //new name
    $n_price = $_POST['n_price']; //updated price
    $n_desc = $_POST['n_desc']; //new desc
    $n_cid = $_POST['n_cid']; //updated cat id
    $n_iname =("img/" . $_POST['n_iname']);//directory plus name of new file including extension

    if (!isset($_POST['p_name']) || !isset($_POST['n_name']) || !isset($_POST['n_price']) || !isset($_POST['n_desc']) || !isset($_POST['n_cid']) || !isset($_POST['n_iname'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($p_name) == 0 || strlen($n_name) == 0 || strlen($n_price) == 0 || strlen($n_desc) == 0 || $n_cid == 0 || strlen($_POST['n_iname']) == 0) {
        return NULL; //make sure all fields have been entered
    }
    $sql = "UPDATE product SET productName=?, productPrice=?, productDesc=?, categoryId=?, productImageURL=? WHERE productName = ?";//update prod with given prod name
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $pstmt = sqlsrv_prepare($con, $sql, array($n_name, $n_price, $n_desc, $n_cid, $n_iname, $p_name));//
    sqlsrv_execute($pstmt); //execute sql insert
    $retStr = $p_name;//output old name
    $retStr1 = $n_name;//output new name
    
    sqlsrv_close($con);//close connection

    echo("<h3>" . $retStr . " has been updated to " . $retStr1 . "</h3>" ); //confirms item is updated
}
?>


<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>