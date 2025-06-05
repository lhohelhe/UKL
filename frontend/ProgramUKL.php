<?php
include '../connfront.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKL</title>
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
        <li><a href="#Promo">Promo</a></li>
        <li class="profile-icon">
          <a href="profil.php" title="Profil Saya">
          <i class="fa-solid fa-user" style="font-size: 20px;"></i> </a> </li>
      </ul>
    </nav>
<!-- sekat -->
    <main class="Programmain" id="main">
        <div class="card">
            <img src="../Foto/Asia.jpg"  class="gambar">
        </div>
        <div class="card">
            <img src="../Foto/Australia.jpg"  class="gambar">
        </div>
        <div class="card">
            <img src="../Foto/eropa.jpg"  class="gambar">
        </div>
        <div class="card">
            <img src="../Foto/afrika.jpg"  class="gambar">
        </div>
        <div class="card">
            <img src="../Foto/amerika.jpg"  class="gambar">
        </div>
    </main>
<!-- sekat -->
 <?php
    $sql = " SELECT p.program, p.gambar, pr.diskon, pr.pelatihanID
            FROM promo pr
            JOIN pelatihan p ON pr.pelatihanID = p.ID
            LIMIT 1 ";
    $promomu = $conn->query($sql);

if ($promomu && $promomu->num_rows > 0) {
    $apalah = $promomu->fetch_assoc();
    $pelatihanID = $apalah['pelatihanID'];
    $program = $apalah['program'];
    $diskon = $apalah['diskon'];
    $gambar = $apalah['gambar'];
} else {
    $program = "Belum ada promo aktif";
    $diskon = 0;
    $gambar = "../Foto/promo.jpg";
}
?>

<figure id="Promo" class="Programfigure">
    <div class="luaran">
        <span>Promo</span>
        <a href="pendaftaran.php?ID=<?php echo $pelatihanID; ?>&type=disc">
          <div class="gambar" style="background-image: url('../<?php echo $gambar; ?>');">
            <div class="promo">
            <span>Khusus buat kamu</span>
                <p>Promo pelatihan: <?php echo $program; ?> 
                <h3>Potongan <?php echo $diskon; ?>%</h3></p>
            </div>
          </div> </a>
    </div>
</figure>

<!-- sekat -->
<section class="Programsection" id="pro">
    <span>Pelatihan</span>
    <div class="kontener">
        <?php
        $pelatihan = $conn->query("SELECT * FROM pelatihan");
        while ($rowpelatihan = $pelatihan->fetch_assoc()):
        ?>
        <a href="Pendaftaran.php?ID=<?= urlencode($rowpelatihan['ID']) ?>" class="daftar">
            <div class="kartu">
                <img src="../<?= htmlspecialchars($rowpelatihan['gambar']) ?>" alt="Gambar Pelatihan <?= htmlspecialchars($rowpelatihan['program']) ?>" />
                <div class="info">
                    <h3 class="judul"><?= htmlspecialchars($rowpelatihan['program']) ?></h3>
                    <p class="deskripsi"><?= nl2br(htmlspecialchars($rowpelatihan['deskripsi'])) ?></p>
                    <div class="bawahan">
                        <strong class="harga">Rp <?= number_format($rowpelatihan['harga'], 0, ',', '.') ?></strong>
                    </div>
                </div>
            </div>
        </a>
        <?php endwhile; ?>
    </div>
</section>
<!-- sekat -->
 <?php
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$informasi = $conn->query("SELECT * FROM informasi LIMIT $start, $limit");
$totalData = $conn->query("SELECT COUNT(*) AS total FROM informasi")->fetch_assoc()['total'];
$totalPage = ceil($totalData / $limit);
?>
<article class="Programartikel">
    <span>Informasi</span>
    <div class="haduh">
        <?php while ($rowinformasi = $informasi->fetch_assoc()) { ?>
            <div class="kelompok">
                <img src="../<?php echo $rowinformasi['gambar']; ?>" alt="gambar">
                <div class="berita">
                    <h2><?php echo $rowinformasi['judul']; ?></h2>
                    <p><?php echo $rowinformasi['cuplikan']; ?></p>
                    <a href="informasi.php?ID=<?php echo $rowinformasi['ID']; ?>" class="selengkapnya-btn">Selengkapnya</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>" <?= ($i == $page) ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</article>
<!-- sekat -->
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
<!-- sekat -->
</body>
</html>