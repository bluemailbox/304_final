<?php
$authenticatedUser = NULL;
session_start();

$authenticatedUser = validateUser();

if ($authenticatedUser != NULL) {
    header('Location: index.php');
} else {
    header('Location: createuser.php');
}
?>

<?php
function validateUser() {
    if (!isset($_POST['newusername']) || !isset($_POST['newpassword']) || !isset($_POST['confirmpassword'])) {
        return NULL;
    }
    
    // Beware db_credentials $username conflict!
    // db_credentials defines $username which will
    // override any previous $username on include.
    $webUsername = $_POST['newusername'];
    $webPassword = $_POST['newpassword'];
    $webConfirmPassword = $_POST['confirmpassword'];

    if (strlen($webUsername) == 0 || strlen($webPassword) == 0 || strlen($webConfirmPassword) == 0) {
        return NULL;
    }
     
    if ($webConfirmPassword != $webPassword) {
        $_SESSION['newUserMessage'] = "Password and confirm password do not match";
        return NULL;
    } else {
    $sql = "INSERT INTO customer (userid, password) VALUES (?, ?)";
	include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }
    $pstmt = sqlsrv_prepare($con, $sql, array($webUsername, $webPassword));
    sqlsrv_execute($pstmt);
    $retStr = $webUsername;
    }
    sqlsrv_close($con);

    return $retStr;
}
?>
