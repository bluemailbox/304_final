<link rel="stylesheet" href="mystyle.css">

<h1 align="center"><font face="cursive" color="black"><a href="index.php">Danny DeCheeto's World of Video Games</h1> 

<div class="topnav">
  <a href="login.php">Login</a>
  <a href="listprod.php">Begin Shopping</a>
  <a href="listorder.php">List All Orders</a></li>
  <a href="customer.php">Customer Info</a>
  <a href="admin.php">Administrators</a>
  <a href="logout.php">Log out</a>
  <a href="showcart.php">Show Cart</a>
  <a href="createuser.php">Create Account</a>
  <a><?php
	$webUsername = $_SESSION['authenticatedUser'];
	if ($webUsername) {
		echo("<a>Signed in as: " . $webUsername . "</a>");
	}
?>

</a> 
</div>
 

