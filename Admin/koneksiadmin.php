<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ukl";

// RUCIKA
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$varuse="pengguna.php";
$varpel="pelatihan.php";
$varinf="informasi.php";
$varpnd="pendaftaran.php";
$varprm="promo.php";
?>