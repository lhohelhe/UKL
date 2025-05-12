<?php
include '../connfront.php';

session_start();

if (!isset($_SESSION['PenggunaID'])) {
    die("Akun anda tidak terdeteksi dalam server");
}
if (!isset($_GET['ID'])) {
    die("Pelatihan tidak ditemukan");
}

// =-=-=-=-=-=-=-= //
$userid = $_SESSION['PenggunaID'];
$pelaid = $_GET['ID'];

// Ambil data pelatihan berdasarkan ID
$queryPelatihan = "SELECT * FROM pelatihan WHERE id = '$pelaid'";
$data = $conn->query($queryPelatihan);

if ($data->num_rows > 0) {
    $pelatihan = $data->fetch_assoc(); // Ambil data pelatihan
} else {
    die("Data pelatihan tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = date("Y-m-d");
    $status = "Menunggu";

    // File upload handling
    $nama_file = $_FILES['Administrasi']['name'];
    $tmp_file = $_FILES['Administrasi']['tmp_name'];
    $target_dir = "upload";
    $path = $target_dir . basename($nama_file);

    // Pindahkan file yang diunggah ke direktori target
    if (move_uploaded_file($tmp_file, $path)) {
        // Sisipkan ke dalam database
        $query = "INSERT INTO pendaftaran (PenggunaID, PelatihanID, tanggal, administrasi, status)
                  VALUES ('$userid', '$pelaid', '$tanggal', '$path', '$status')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran berhasil. Mohon menunggu konfirmasi dari kami :)');</script>";
            header("Location: $program#pro");
        } else {
            echo "Gagal mendaftar: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengupload file.";
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
        <form method="POST" enctype="multipart/form-data"> 
            <p>ID Pelatihan: <?= htmlspecialchars($pelaid) ?></p> 
            <p>Pengguna ID: <?= htmlspecialchars($userid) ?></p> 
            <label for="Administrasi">Unggah Administrasi (gambar):</label> 
            <input type="file" name="Administrasi" id="Administrasi" required> 
            <button type="submit">Daftar Sekarang</button> 
        </form> 
    </div> 

    <div class="tampilandaftar"> 
        <img src="../<?= htmlspecialchars($pelatihan['gambar']) ?>" alt="Gambar">
        <h1><?= htmlspecialchars($pelatihan['program']) ?></h1>
        <div class="deskripsi"><?= htmlspecialchars($pelatihan['deskripsi']) ?></div>
        <strong class="harga">Harga Rp <?= number_format($pelatihan['harga'], 0, ',', '.') ?></strong>
        <a href="<?=$program?>#pro" class="btn-kembali">← Kembali</a> 
    </div>
</body>
</html>
