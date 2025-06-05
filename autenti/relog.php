<?php
session_start();

// Cek Check in
if (!isset($_SESSION['PenggunaID'])) {
    header("Location: login.php?type=login");
    exit();
}

$timeout = 150; 
if (isset($_SESSION['terakhiron']) && time() - $_SESSION['terakhiron'] > $timeout) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['terakhiron'] = time();
?>
