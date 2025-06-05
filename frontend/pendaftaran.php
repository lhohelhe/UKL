<?php
include '../connfront.php';
session_start();

if (!isset($_SESSION['PenggunaID'])) {
    echo "<script>alert('Akun anda tidak terdeteksi dalam server. Mohon Login dahulu');</script>";
    echo "<script>window.location.href = '../login.php?type=login';</script>";
    exit;
}

if (!isset($_GET['ID'])) {
    echo "<script>alert('Pelatihan tidak terdeteksi. Segera lapor kepada kami');</script>";
    echo "<script>window.location.href = '$program#pro';</script>";
    exit;
}

$userid = $_SESSION['PenggunaID'];
$pelaid = $_GET['ID'];
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Ambil data pelatihan
$queryPelatihan = "SELECT * FROM pelatihan WHERE id = '$pelaid'";
$data = $conn->query($queryPelatihan);

if ($data->num_rows > 0) {
    $pelatihan = $data->fetch_assoc();
} else {
    die("Data pelatihan tidak ditemukan.");
}

// Ambil diskon jika type=disc
$diskon = null;
if ($type === 'disc') {
    $queryPromo = "SELECT diskon FROM promo WHERE pelatihanID = '$pelaid' LIMIT 1";
    $promoResult = $conn->query($queryPromo);
    if ($promoResult && $promoResult->num_rows > 0) {
        $promoData = $promoResult->fetch_assoc();
        $diskon = $promoData['diskon'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = date("Y-m-d");
    $status = "Menunggu";
    $bank = $_POST['bank'];
    $kontak = $_POST['kontak'];

    // Gunakan diskon jika ada
    $diskonInsert = ($diskon !== null) ? $diskon : 'NULL';

    $query = "INSERT INTO pendaftaran (PenggunaID, PelatihanID, tanggal, administrasi, kontak, status, diskon)
              VALUES ('$userid', '$pelaid', '$tanggal', '$bank', '$kontak', '$status', $diskonInsert)";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran berhasil. Mohon menunggu konfirmasi dari kami :)');</script>";
        echo "<script>window.location.href = '$program#pro';</script>";
        exit;
    } else {
        echo "Gagal mendaftar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Pelatihan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="frontend.css">
</head>
<body class="pendaftaran">
    <div class="wrapformdaftar">
        <h2>Form Pendaftaran Pelatihan</h2>
        <form method="POST">
            <label for="bank">Metode Pembayaran:</label>
            <select name="bank" id="bank" required>
                <option value="">Pilih Bank</option>
                <option value="BCA">BCA</option>
                <option value="BRI">BRI</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BNI">BNI</option>
            </select>

            <label for="kontak">Nomor Telepon:</label>
            <input type="text" name="kontak" id="kontak" required placeholder="Masukkan nomor telepon">

            <button type="submit">Daftar Sekarang</button>
        </form>
    </div>
<!-- Sekat -->
    <div class="tampilandaftar">
        <img src="../<?= htmlspecialchars($pelatihan['gambar']) ?>" alt="Gambar">
        <h1><?= htmlspecialchars($pelatihan['program']) ?></h1>
        <div class="deskripsi"><?= htmlspecialchars($pelatihan['deskripsi']) ?></div>
        <?php
        $hargaAsli = $pelatihan['harga'];
        if ($diskon !== null) {
            $hargaDiskon = $hargaAsli - ($hargaAsli * ($diskon / 100));
            ?>
            <strong class="harga">
                Harga Asli: <del>Rp <?= number_format($hargaAsli, 0, ',', '.') ?></del><br>
                Harga Diskon: <span style="color: red;">Rp <?= number_format($hargaDiskon, 0, ',', '.') ?></span><br>
            </strong>
            <?php
        } else {
            ?>
            <strong class="harga">
                Harga Rp <?= number_format($hargaAsli, 0, ',', '.') ?>
            </strong>
            <?php
        }
        ?>
        <a href="<?=$program?>#pro" class="btn-kembali">← Kembali</a>
    </div>
</body>
</html>
