<?php
session_start();
include "header.php";
?>
<link rel="stylesheet" href="mystyle.css">
<!DOCTYPE html>
<html>
<head>
<title>User Creation Page</title>
</head>
<body>

<div style="margin:0 auto;text-align:center;display:inline">

<h3>Create an account</h3>

<?php
if (isset($_SESSION['newUserMessage'])) {
    echo("<p>" . $_SESSION['newUserMessage'] . "</p>");
    $_SESSION['newUserMessage'] = NULL;
}
?>

<br>
<form name="createuser" method=post action="newuservalidation.php">
<table style="display:inline">
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Username:</font></div></td>
	<td><input type="text" name="newusername"  size=10 maxlength=10></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Password:</font></div></td>
	<td><input type="password" name="newpassword" size=10 maxlength="10"></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Confirm Password:</font></div></td>
	<td><input type="password" name="confirmpassword" size=10 maxlength="10"></td>
</tr>
</table>
<br/>
<input class="submit" type="submit" name="Submit2" value="Create user">
</form>

</div>

</body>
</html>

