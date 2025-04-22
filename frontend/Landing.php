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
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      </head>
      
</head>
<body>
<!-- bismillah -->
    <nav>
        <ul>
            <img src="../Foto/Logo Tempa.jpg" class="logo">
            <li><a href="#header">Beranda</a></li>
            <li><a href="<?=$program?>">Layanan</a></li>
            <li><a href="<?=$tentang?>">Tentang</a></li>
            <li><a href="#Promo">Promo</a></li>
        </ul>
    </nav>
<!-- pemisah aja -->
    <header class="Landingheader" id="header">
        <div class="kontener">
            
            <div class="selimut">
                <div class="moto">
                    <h1>Tempa Dirimu</h1>
                    <h2>Asah Kemampuanmu</h2>
                    <button type="button"><a href="#main">Mulai</a></button>
                    <button type="button"><a href="login.php">Login</a></button>
                </div> 
            </div>

        </div>
    </header>
<!-- pemisah aja -->
    <article class="Landingartikel">
        <div class="kata">
            <span>Bersama keahlianmu warnai duniamu</span>
            <p>maksimalkan kemampuanmu untuk masa depan yang lebih baik. Kami menyediakan program yang terbaik untuk memastikan kebutuhanmu</p>
        </div>
    </article>
<!-- pemisah aja -->
    <section class="Landingsection">
        <h2>Tentang kami</h2>
        <br>
        
        <div class="tentang">
            <div class="baca">
            <p >Tempa adalah website yang berfokus pada pendidikan dan pengasahan kemampuan khusus hanya untuk anak bangsa yang dimaksudkan untuk menyiapkan diri mereka sehingga dapat bersaing dengan dunia luar dan tenaga kerja asing. Kami berharap dengan adanya Tempa tenaga kerja Indonesia dapat lebih berkompeten dan terampil, sehingga tenaga kerja di Indonesia dapat terserap dengan baik. Pelajari untuk informasi lebih lanjut tentang kami.</p>
            <a href="<?=$tentang?>"><button type="button">Pelajari</button></a>
            </div>
            <img src="../Foto/Teknologi.jpg" >
        </div>
    </section>
<!-- pemisah aja -->
    <main id="main" class="Landingmain">
        <div class="bungkus">
            <div class="tambahan">
                <span>Pelayanan kami</span>
            </div>
        <div class="kontener">
            <?php $pelatihan = $conn->query("SELECT * FROM pelatihan");
            while ($rowpelatihan = $pelatihan->fetch_assoc()): ?>
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
            <a href="<?=$program?>#pro"><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </main>
<!-- pemisah aja -->
    <figure id="Promo" class="Landingfigure">
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
<!-- pemisah aja -->
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
<!-- pemisah aja -->
</body>
</html>