<?php
session_start();
include "header.php";
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<title>Admin Login Screen</title>
</head>
<body>

<div style="margin:0 auto;text-align:center;display:inline">

<h3>Please Login as Administrator</h3>

<?php
if (isset($_SESSION['adminloginMessage'])) {
    echo("<p>" . $_SESSION['adminloginMessage'] . "</p>");
    $_SESSION['adminloginMessage'] = NULL;
}
?>

<br>
<form name="MyForm" method=post action="validateAdminLogin.php">
<table style="display:inline">
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Admin Username:</font></div></td>
	<td><input type="text" name="adminusername"  size=10 maxlength=10></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Admin Password:</font></div></td>
	<td><input type="password" name="adminpassword" size=10 maxlength="10"></td>
</tr>
</table>
<br/>
<input class="submit" type="submit" name="Submit2" value="Log In">
</form>

</div>

</body>
</html>
