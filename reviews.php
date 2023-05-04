<html>
<head>
<title>Danny Decheetos Gamers R Us - Review Information</title>
</head>
<body>
<?php
$productId = $rst['productId'];
$productName = $rst['productName'];
if (isset($_SESSION['reviewMessage'])) {
    echo("<p>" . $_SESSION['reviewMessage'] . "</p>");
    $_SESSION['reviewMessage'] = NULL;
}
?>


<h1>Reviews for <?php echo($productName); ?>:</h1>
<table style="display:inline">
<tr>
    <td><div align="right"><font face="Arial, Helvetica, sans-serif" size="4">Leave your rating and review (max 1000 characters):</font></div></td>
</tr>
</table>
<br>
<form name="Review" method=get action="validateReview.php">
<input type="hidden" name="rid" value=<?php echo($productId); ?> >
<input type="hidden" name="rname" value="<?php echo($productName); ?>" >
<table style="display:inline">

<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="4">Rating:</font></div></td>
	<td><select size="1" name="Rating">
        <option>1</option>
        <option>2</option>
        <option>3</option> 
        <option>4</option>
        <option>5</option> 
        <option>6</option> 
        <option>7</option> 
        <option>8</option> 
        <option>9</option> 
        <option>10</option>
        </select>
    </td>   
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="4">Review:</font></div></td>
	<td><textarea name="Comment" maxlength="1000" rows=5 cols="62"></textarea></td>        
    <td>
        <input type="submit" value="Submit" size = "4">
        <input type="reset" value="Reset" size = "4">
    </td>
</tr>
</table>
</form>
<br/>

<?php

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT productId, C.customerId, reviewRating, reviewDate, reviewComment, userId FROM Review R, Customer C WHERE R.customerId = C.customerId AND productId = ? ORDER BY reviewDate";


$pstmt = sqlsrv_prepare($con, $sql, array($productId));

sqlsrv_execute($pstmt);
$sql2 = "SELECT AVG(reviewRating) RR, productId FROM Review R WHERE productId = ? GROUP BY productId";
$pstmt2 = sqlsrv_prepare($con, $sql2, array($productId));
$rst2 = sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC);

$result2 = sqlsrv_execute($pstmt2);
echo("<table>");
if (!$result2) {
    echo("No Ratings");
}else{
    $rst2 = sqlsrv_fetch_array($pstmt2, SQLSRV_FETCH_ASSOC);
    echo("<tr align=\"right\"><td colspan=\"5\"><table border=\"1\">");
    echo("<tr><th>Average Rating:</th><td>" . $rst2['RR'] . "/10</td></tr>");}
    echo("<tr align=\"right\"><td colspan=\"5\"><table border=\"1\">");
echo("<tr><th>Name</th><th>Date</th><th>Rating</th><th>Review</th></tr>");

while ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) {
    echo("<td>" . $rst['userId'] . "</td><td>" . date_format($rst['reviewDate'],"Y/m/d H:i:s") . "</td><td>" . $rst['reviewRating'] . "</td><td>" . $rst['reviewComment'] . "</td></tr>");
}
echo("</table>");

sqlsrv_close($con);
?>

</body>
</html>