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
</head>

<body>

    <nav>
        <ul>
            <img src="../Foto/Logo Tempa.jpg" class="logo">
            <li><a href="<?=$beranda?>">Beranda</a></li>
            <li><a href="#main">Layanan</a></li>
            <li><a href="<?=$tentang?>">Tentang</a></li>
            <li><a href="#Promo">Promo</a></li>
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
    <figure id="Promo" class="Programfigure">
        <div class="luaran">
            <span>Promo</span>
            <div class="gambar">
                 <div class="promo">
                <span>Khusus buat kamu</span>
                <p>Promo pelatihan + visa berangkat ke SWISS <h3>Potongan 15%</h3></p>
                 </div>
            </div>
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
        <div class="kartu">
            <img src="../<?= htmlspecialchars($rowpelatihan['gambar']) ?>" alt="Gambar Pelatihan">
            <div class="info">
                <h3 class="judul"><?= htmlspecialchars($rowpelatihan['program']) ?></h3>
                <p class="deskripsi"><?= htmlspecialchars($rowpelatihan['deskripsi']) ?></p>
                <strong class="harga">Rp <?= number_format($rowpelatihan['harga'], 0, ',', '.') ?></strong>
            </div>
        </div>
    <?php endwhile; ?>
</div>

     </section>
<!-- sekat -->
<article class="Programartikel">
    <span>Informasi</span>
    <div class="haduh">
        <?php $informasi = $conn->query("SELECT * FROM informasi");
        while ($rowinformasi = $informasi->fetch_assoc()) { ?>
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