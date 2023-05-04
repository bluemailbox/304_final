<?php
session_start();
include "header.php";

$newProd = addCust();
?>

<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Add Customer</title>
</head>
<body>
<h1>Add a Customer</h1> 
<h2>All of the following fields are required:</h2>
<table class='center' style='width:40%'>   
<form method="post" action="addcust.php" enctype="multipart/form-data"> 
<tr><td>First Name:<input type="text" name="fname" size="10" maxlength="10"></td></tr>
<tr><td>Last Name:<input type="text" name="lname"></td></tr>
<tr><td>Email:<input type="text" name="email"></td></tr>
<tr><td>Phone Number:<input type="text" name="pnum"></td></tr>
<tr><td> Address:<input type="text" name="address"></td></tr>
<tr><td>City:<input type="text" name="cit"></td></tr>
<tr><td> State:<input type="text" name="state" ></td></tr>
<tr><td> Postal Code:<input type="text" name="postc"></td></tr>
<tr><td> Country:<input type="text" name="country" ></td></tr>
<tr><td>  User ID:<input type="text" name="uid"></td></tr>
<tr><td> Password:<input type="text" name="pass" size="10">
   
   <input type="submit" value="Add"></td></tr>
</form>
</table>
<?php 
// put add customer info into database
function addCust() {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pnum = $_POST['pnum'];
    $addr = $_POST['address'];
    $city = $_POST['cit'];
    $state = $_POST['state'];
    $postc = $_POST['postc'];
    $country = $_POST['country'];
    $uid = $_POST['uid'];
    $pass = $_POST['pass'];

    if (!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['email']) || !isset($_POST['pnum']) || !isset($_POST['address']) || !isset($_POST['cit']) || !isset($_POST['state']) || !isset($_POST['postc']) || !isset($_POST['country']) || !isset($_POST['uid']) || !isset($_POST['pass'])) {
        return NULL;
    }//if nothing is grabbed yet return null

    if (strlen($fname) == 0 || strlen($lname) == 0 || strlen($email) == 0 || strlen($pnum) == 0 || strlen($addr) == 0 || strlen($city) == 0 || strlen($state) == 0 || strlen($postc) == 0 || strlen($country) == 0 || strlen($uid) == 0 || strlen($pass) == 0) {
        return NULL; //make sure all fields have been entered
    }
    $sql = "INSERT INTO Customer (firstName, lastName, email, phoneNum, address, city, state, postalCode, country, userid, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";//add cust info
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }

    $pstmt = sqlsrv_prepare($con, $sql, array($fname, $lname, $email, $pnum, $addr, $city, $state, $postc, $country, $uid, $pass));//
    sqlsrv_execute($pstmt); //execute sql insert
    $retStr = $uid;
    
    sqlsrv_close($con);//close connection

    echo("<h3>User " . $retStr . " has been added!</h3>" ); //confirms item is added
}
?>
<h2><a href="admin.php">Back to admin</a></h2> 
</body>
</html>