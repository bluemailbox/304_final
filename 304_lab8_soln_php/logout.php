<?php
session_start();
$_SESSION['authenticatedUser'] = NULL;
$_SESSION['authenticatedAdmin'] = NULL;
header('Location: index.php');
?>
