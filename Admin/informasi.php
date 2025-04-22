<?php
include 'koneksiadmin.php';

$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['ID']) ? $_GET['ID'] : '';
$judul = $cuplikan = $isi = $gambarLama = "";

// --- Maling data sebelum di edit ---
if ($type === 'edit' && $id) {
    $query = "SELECT * FROM informasi WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $judul = $row['judul'];
        $cuplikan = $row['cuplikan'];
        $isi = $row['isi'];
        $gambarLama = $row['gambar'];
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// --- Kalau di Submit (tambah atau edit) ---
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $cuplikan = $_POST['cuplikan'];
    $isi = $_POST['isi'];
    $waktu = date('Y-m-d');

    $target_dir = "upload/";
    $gambarBaru = $_FILES["gambar"]["name"];
    $uploadPath = $target_dir . basename($gambarBaru);

    if (!empty($gambarBaru)) {
        if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], "../$uploadPath")) {
            echo "Gagal mengupload gambar.";
            exit;
        }
    } else {
        $uploadPath = $gambarLama; // kalau gak upload baru --
    }

    if ($type === 'edit' && $id) {
        $sql = "UPDATE informasi SET 
                    judul = '$judul', 
                    cuplikan = '$cuplikan', 
                    isi = '$isi', 
                    gambar = '$uploadPath', 
                    waktu = '$waktu' 
                WHERE id = $id";
    } else {    // kalau kirim baru --
        $sql = "INSERT INTO informasi (judul, cuplikan, isi, gambar, waktu) 
                VALUES ('$judul', '$cuplikan', '$isi', '$uploadPath', '$waktu')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKL</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body class="informasiaksi">

<div class="cardinformasi">
<form method="POST" enctype="multipart/form-data">
    <label>Judul:</label>
    <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

    <label>Cuplikan:</label>
    <textarea name="cuplikan" rows="3" required><?= htmlspecialchars($cuplikan) ?></textarea>

    <label>Isi:</label>
    <textarea name="isi" rows="6" required><?= htmlspecialchars($isi) ?></textarea>

    <label>Upload Gambar:</label>
    <input type="file" name="gambar" accept="image/*" <?= $type === 'edit' ? '' : 'required' ?>>
    <?php if ($type === 'edit' && $gambarLama): ?>
        <small>Gambar saat ini: <?= basename($gambarLama) ?></small>
    <?php endif; ?>

    <button type="submit" name="submit"><?= $type === 'edit' ? 'Update' : 'Simpan' ?> Informasi</button>
</form>
    <a href="admin.php">Batal</a>

</div>
</body>
    
