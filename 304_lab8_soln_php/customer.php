<?php
include 'auth.php';
session_start();
include "header.php";
$webUsername = $_SESSION['authenticatedUser'];
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<title>Customer Page</title>
</head>
<body>

<?php
echo("<h3>Customer Profile</h3>");

$sql = "select customerId, firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password FROM Customer WHERE userid = ?";
include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$pstmt = sqlsrv_query($con, $sql, array($webUsername));

if(sqlsrv_fetch($pstmt)) {
    echo("<table class=\"table\" border=\"1\">");
    echo("<tr><th>Id</th><td>".sqlsrv_get_field($pstmt, 0)."</td></tr>");	
    echo("<tr><th>First Name</th><td>".sqlsrv_get_field($pstmt, 1)."</td></tr>");
    echo("<tr><th>Last Name</th><td>".sqlsrv_get_field($pstmt, 2)."</td></tr>");
    echo("<tr><th>Email</th><td>".sqlsrv_get_field($pstmt, 3)."</td></tr>");
    echo("<tr><th>Phone</th><td>".sqlsrv_get_field($pstmt, 4)."</td></tr>");
    echo("<tr><th>Address</th><td>".sqlsrv_get_field($pstmt, 5)."</td></tr>");
    echo("<tr><th>City</th><td>".sqlsrv_get_field($pstmt, 6)."</td></tr>");
    echo("<tr><th>State</th><td>".sqlsrv_get_field($pstmt, 7)."</td></tr>");
    echo("<tr><th>Postal Code</th><td>".sqlsrv_get_field($pstmt, 8)."</td></tr>");
    echo("<tr><th>Country</th><td>".sqlsrv_get_field($pstmt, 9)."</td></tr>");
    echo("<tr><th>User id</th><td>".sqlsrv_get_field($pstmt, 10)."</td></tr>");	
    echo("</table>");	
}

echo("<h2><a href=\"editinfo.php\">Update Information</a></h2>"); //edit customer button

sqlsrv_close($con);
?>

</body>
</html>
