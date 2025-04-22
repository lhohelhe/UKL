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

$beranda='Landing.php';
$program='Program UKL.php';
$tentang='Tentang.php';
?>