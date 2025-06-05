<?php 
include '../connfront.php';
session_start();
$UserID = $_SESSION['PenggunaID'];

// Query JOIN langsung + ambil diskon
$sql = "
    SELECT 
        pendaftaran.ID AS PendaftaranID,
        pendaftaran.Tanggal,
        pendaftaran.Status,
        pendaftaran.diskon AS DiskonPendaftaran,
        pelatihan.Program,
        pelatihan.gambar,
        pelatihan.Harga
    FROM pendaftaran
    JOIN pelatihan ON pendaftaran.PelatihanID = pelatihan.ID
    WHERE pendaftaran.PenggunaID = $UserID
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Histori Pendaftaran</title>
  <link rel="stylesheet" href="frontend.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
      <ul>
        <img src="../Foto/Logo Tempa.jpg" class="logo">
        <li><a href="<?=$beranda?>">Beranda</a></li>
        <li><a href="<?=$program?>">Layanan</a></li>
        <li><a href="<?=$tentang?>">Tentang</a></li>
        <li><a href="<?=$program?>#pro">Promo</a></li> 
        <li class="profile-icon">
          <a href="profil.php" title="Profil Saya">
          <i class="fa-solid fa-user" style="font-size: 20px;"></i> </a> </li>
      </ul>
    </nav> 
<!-- Sekat -->
<div class="urprofil">
  <?php 
  $sqlUser = "SELECT Nama, Email, Usia FROM pengguna WHERE ID = $UserID";
  $resultUser = $conn->query($sqlUser);
  $userData = $resultUser->fetch_assoc(); ?>

  <div class="sidebar">
  <div class="profile">
    <h2>Selamat Datang</h2>
    <p><?= htmlspecialchars($userData['Nama']); ?> !</p>
    <br>
    <p><?= htmlspecialchars($userData['Email']); ?></p>
    <br>
    <p>UID kamu "<?= $UserID?>"</p>
  </div>
</div>
<!-- Sekat -->
<div class="urmain">
  <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $hargaAsli = $row['Harga'];
            $diskon = $row['DiskonPendaftaran'] ?? 0; // NULL jadi 0
            $hargaDiskon = $hargaAsli - ($hargaAsli * $diskon / 100);
      ?>
    <div class="card">
        <img src="../<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['Program']); ?>" />
          <div class="card-content">
            <h3><?php echo htmlspecialchars($row['Program']); ?></h3>
            <p>ID Pendaftaran : <?php echo htmlspecialchars($row['PendaftaranID']); ?></p>
            <p>Tanggal Daftar : <?php echo htmlspecialchars($row['Tanggal']); ?></p>
            <p>Status : <?php echo htmlspecialchars($row['Status']); ?></p>
            <?php if ($diskon > 0) { ?>
                <p>Harga Asli : <s>Rp <?php echo number_format($hargaAsli, 0, ',', '.'); ?></s></p>
                <p>Harga Promo : Rp <?php echo number_format($hargaDiskon, 0, ',', '.'); ?> (Diskon <?= $diskon ?>%)</p>
            <?php } else { ?>
                <p>Harga : Rp <?php echo number_format($hargaAsli, 0, ',', '.'); ?></p>
            <?php } ?>
          </div>
    </div>
      <?php
        } } else {
        echo "<p>Tidak ada data pelatihan.</p>";
        } ; ?>
</div>
</body>
</html>
