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
    <!-- Sekat -->
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
    <!-- Sekat -->
    <main id="main" class="Tentangmain">
        <h2 class="Pusat">Tentang Kami</h2>
        <p>  Website ini hadir sebagai wujud nyata dari komitmen kami untuk membangun generasi muda Indonesia yang  kompeten, berdaya saing, dan siap menghadapi tantangan global. Kami percaya bahwa setiap anak Indonesia memiliki potensi besar yang dapat dikembangkan melalui pelatihan keterampilan yang tepat dan relevan dengan kebutuhan dunia kerja saat ini. Oleh karena itu, kami menciptakan platform ini untuk melatih dan mengasah keahlian mereka dalam berbagai bidang yang sedang diminati di pasar global, baik di tingkat Asia maupun Eropa. </p> 
            
          <p>  Dengan fokus pada pengembangan keterampilan praktis dan profesional, kami bertujuan untuk menjembatani kesenjangan antara kebutuhan industri dengan kemampuan tenaga kerja Indonesia. Melalui pelatihan berbasis praktik, kurikulum yang mengikuti tren industri, serta bimbingan dari para ahli yang berpengalaman, kami memberikan akses kepada generasi muda untuk mendapatkan pengetahuan dan keterampilan yang diperlukan agar mereka mampu bersaing dengan tenaga kerja dari negara-negara lain.  
            </p>
            <p>
            Tidak hanya bertujuan untuk meningkatkan kualitas individu, platform ini juga berperan dalam membantu mengurangi angka pengangguran di Indonesia. Kami membuka peluang kerja bagi mereka yang telah menyelesaikan pelatihan dengan menghubungkan mereka ke berbagai perusahaan dan industri di luar negeri, termasuk kawasan Asia dan Eropa yang memiliki kebutuhan tinggi akan tenaga kerja berkualitas. Dengan demikian, kami berharap dapat menciptakan sumber daya manusia Indonesia yang tidak hanya mampu bekerja secara profesional di luar negeri, tetapi juga membawa pengalaman dan pengetahuan global kembali ke tanah air untuk berkontribusi pada pembangunan bangsa.  </p>
            <p>
            Kami percaya bahwa masa depan Indonesia ada di tangan generasi mudanya. Dengan keterampilan yang tepat, semangat kerja keras, dan dukungan yang memadai, anak-anak Indonesia akan mampu bersinar di panggung dunia dan membawa nama bangsa ke tingkat yang lebih tinggi. Bersama, kita wujudkan Indonesia yang lebih kompeten, mandiri, dan dihormati di kancah internasional.</p>
                <div class="a">
            <div class="visi">
                <h2>Visi Kami</h2>
                <p>
                    1. Menjadi platform unggulan dalam pengembangan keahlian generasi muda Indonesia di bidang-bidang yang paling dibutuhkan di era global.
                    </p>
                    <p>
                    2. Mendorong terciptanya tenaga kerja Indonesia yang kompeten, profesional, dan mampu bersaing di pasar internasional.
                    </p>
                    <p>
                    3. Berkontribusi pada pengurangan pengangguran dengan menciptakan akses kerja global bagi tenaga ahli Indonesia.
                </p>
            </div>
            <div class="misi">
                <h2>Misi Kami</h2>
                <p>1. Memberikan pelatihan berbasis keterampilan yang relevan dengan kebutuhan industri modern.</p>
                <p> 2. Membuka akses bagi tenaga kerja Indonesia untuk bekerja di sektor global, termasuk negara-negara Eropa.</p>
                <p>3. Menyediakan program mentoring dan bimbingan karir untuk mengarahkan generasi muda ke jalur yang sesuai dengan potensi mereka.</p>
                <p>4. Berkolaborasi dengan berbagai perusahaan nasional dan internasional untuk memperluas peluang kerja bagi tenaga profesional Indonesia.</p>
                <p>5. Meningkatkan kesadaran tentang pentingnya pengembangan keterampilan di kalangan anak muda untuk menghadapi persaingan global.</p>
            </div>
            </div>
    </main>
    <!-- Sekat -->
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