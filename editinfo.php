<?php
session_start();
include "header.php";

$newUser = editUser();
?>

<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>Edit User Info</title>
</head>
<body>
<h1>Edit User Info</h1>

<?php
   include 'include/db_credentials.php';
   $con = sqlsrv_connect($server, $connectionInfo);
   
   /* Try/Catch connection errors */
   if( $con === false ) {
       die( print_r( sqlsrv_errors(), true));
   }
$userid =  $_SESSION['authenticatedUser'];
$sql2 = "SELECT customerId, firstName, lastName, email, phonenum, C.address a, city, C.state s, postalCode, country FROM customer C WHERE userid = ?";
$pstmt2 = sqlsrv_query($con, $sql2, array($userid));
$rst=sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC);
sqlsrv_close($con);
$fname = $rst['firstName'];
$lname = $rst['lastName'];
$email = $rst['email'];
$pnum = $rst['phonenum'];
$addr = $rst['a'];
$city = $rst['city'];
$state = $rst['s'];
$postc = $rst['postalCode'];
$country = $rst['country'];
?>
<form method="post" action="editinfo.php" enctype="multipart/form-data"> 
<table class='center' style='width:40%'>  
<tr><td>New First Name:<input type="text" name="n_fname" size="10" maxlength="10" value=<?php echo($fname);?> ></td></tr>
<tr><td>New Last Name:<input type="text" name="n_lname" value="<?php echo($lname);?>" ></td></tr>
<tr><td> New Email:<input type="text" name="n_email" value="<?php echo($email);?>" ></td></tr>
<tr><td> New Phone Number:<input type="text" name="n_pnum" value="<?php echo($pnum);?>" ></td></tr>
<tr><td>New Address:<input type="text" name="n_address" value="<?php echo($addr);?>" ></td></tr>
<tr><td>New City:<input type="text" name="n_cit" value="<?php echo($city);?>" ></td></tr>
<tr><td>New State:<input type="text" name="n_state" value="<?php echo($state);?>" ></td></tr>
<tr><td>New Postal Code:<input type="text" name="n_postc" value="<?php echo($postc);?>" ></td></tr>
<tr><td>New Country:<input type="text" name="n_country" value="<?php echo($country);?>" ></td></tr>
<tr><td>New Password:<input type="text" name="n_pass" size="10" >
<input type="hidden" name="userid" value=<?php echo($userid);?> >
   
   <input type="submit" value="Change"> </td></tr>
</form>
</table>

<?php 
// put edited customer info into database
function editUser() {
    $n_fname = $_POST['n_fname'];
    $n_lname = $_POST['n_lname'];
    $n_email = $_POST['n_email'];
    $n_pnum = $_POST['n_pnum'];
    $n_addr = $_POST['n_address'];
    $n_city = $_POST['n_cit'];
    $n_state = $_POST['n_state'];
    $n_postc = $_POST['n_postc'];
    $n_country = $_POST['n_country'];
    $n_pass = $_POST['n_pass'];
    $uid = $_POST['userid'];

    if (!isset($_POST['n_fname']) || !isset($_POST['n_lname']) || !isset($_POST['n_email']) || !isset($_POST['n_pnum']) || !isset($_POST['n_address']) || !isset($_POST['n_cit']) || !isset($_POST['n_state']) || !isset($_POST['n_postc']) || !isset($_POST['n_country'])|| !isset($_POST['n_pass'])) {
        return NULL;
    }//if nothings been grabbed yet, do nothing

    if (strlen($n_fname) == 0 || strlen($n_lname) == 0 || strlen($n_email) == 0 || strlen($n_pnum) == 0 || strlen($n_addr) == 0 || strlen($n_city) == 0 || strlen($n_state) == 0 || strlen($n_postc) == 0 || strlen($n_country) == 0 || strlen($n_pass) == 0) {
        return NULL; // NEED big set of ifs to check which fields have been entered if not all fields have been entered
    }
    $sql = "UPDATE Customer SET firstName=?, lastName=?, email=?, phoneNum=?, address=?, city=?, state=?, postalCode=?, country=?, password=? WHERE userid =?";//update cust info
    include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    
    /* Try/Catch connection errors */
    if( $con === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $pstmt = sqlsrv_prepare($con, $sql, array($n_fname, $n_lname, $n_email, $n_pnum, $n_addr, $n_city, $n_state, $n_postc, $n_country, $n_pass, $uid));//
    sqlsrv_execute($pstmt); //execute sql insert
    sqlsrv_close($con);//close connection

    echo("<h3>Information has been updated for user: ". $uid . "</h3>" ); //confirms item is added
}
?>
<h2><a href="customer.php">Back to user page</a></h2> 
</body>
</html>