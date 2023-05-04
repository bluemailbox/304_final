<?php
$authenticatedAdmin = NULL;
session_start();

$authenticatedAdmin = validateAdminLogin();

if ($authenticatedAdmin != NULL) {
    header('Location: admin.php');
} else {
    header('Location: adminlogin.php');
}
?>

<?php
function validateAdminLogin() {
    if (!isset($_POST['adminusername']) || !isset($_POST['adminpassword'])) {
        return NULL;
    }
    
    // Beware db_credentials $username conflict!
    // db_credentials defines $username which will
    // override any previous $username on include.
    $adminUsername = $_POST['adminusername'];
    $adminPassword = $_POST['adminpassword'];

    if (strlen($adminUsername) == 0 || strlen($adminPassword) == 0) {
        return NULL;
    }

    $sql = "SELECT * FROM administrator WHERE adminid = ? and password = ?";
	include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
	
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }
    
    $pstmt = sqlsrv_query($con, $sql, array($adminUsername,$adminPassword));
    $retStr = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($con);

    if ($retStr) {
        $_SESSION['authenticatedAdmin'] = $adminUsername;
    } else {
        $_SESSION['adminloginMessage'] = "Could not connect to the system using that username/password.";
    }

    return $retStr;
}
?>
