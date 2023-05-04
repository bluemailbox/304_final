<?php
session_start();

$authenticatedadmin = false;
if (isset($_SESSION['authenticatedAdmin'])) {
    $authenticatedadmin = $_SESSION['authenticatedAdmin'];
}

if (!$authenticatedadmin) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
        $requestUrl = "https://";
    } else {
        $requestUrl = "http://";
    }
    $requestUrl .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $adminloginMessage = "You have not been authorized to access the URL " . $requestUrl;
    $_SESSION['adminloginMessage'] = $adminloginMessage;

    header('Location: adminlogin.php');
}
?>
