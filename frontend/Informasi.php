<?php
include '../connfront.php';

$id = $_GET['ID'] ?? '';

if ($id) {
    $query = "SELECT * FROM informasi WHERE ID = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    echo "ID tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKL</title>
    <link rel="stylesheet" href="frontend.css">
</head>

<body class="informasi-page">
<div class="container">
    <center> <img src="../<?= $data['gambar'] ?>" alt="Gambar" class="informasi-img"> </center>
    <h1><?= htmlspecialchars($data['judul']) ?></h1>
    <div class="isi"><?= nl2br(htmlspecialchars($data['isi'])) ?></div>
    <div class="tanggal">Dibuat pada: <?= date('d M Y', strtotime($data['waktu'])) ?></div>
    <a href="Program UKL.php" class="btn-kembali">← Kembali</a>
</div>

<footer>
        <div class="non">
        <div class="sosmed">
            <ul>
              <li><a href="https://facebook.com"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v8/icons/facebook.svg" alt="Facebook" width="20"></a></li>
              <li><a href="https://instagram.com"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v8/icons/instagram.svg" alt="Instagram" width="20"></a></li>
              <li><a href="https://twitter.com"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v8/icons/twitter.svg" alt="Twitter" width="20"></a></li>
              <li><a href="https://youtube.com"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v8/icons/youtube.svg" alt="YouTube" width="20">
              </a></li>
              <li><a href="https://t.me/username"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v8/icons/telegram.svg" alt="Telegram" width="20">
              </a></li>
              <li>Hubungi kami +6281 2008 0730</li>
              <li>Email : pendidikantempa@gmail.co.id</li>
              <p>&copy; 2024 Tempa. Semua Hak Dilindungi.</p>
            </ul>
        </div>
    </footer>

</body>
</html>