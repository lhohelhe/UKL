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
        header("Location: $varinf");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['hapus_informasi'])) {
    $id = $_POST['hapus_informasi'];
    mysqli_query($conn, "DELETE FROM informasi WHERE ID = $id");
    header("Location: $varinf");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKL</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
<div class="samping">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="<?=$varuse?>?type=tambah">Pengguna</a></li>
            <li><a href="<?=$varpel?>">Pelatihan</a></li>
            <li><a href="<?=$varinf?>">Informasi</a></li>
            <li><a href="<?=$varpnd?>">Pendaftaran</a></li>
            <li><a href="<?=$varprm?>">Promo</a></li>
            <li><a href="../login.php?type=login" class="Kembali">Kembali</a></li>
        </ul>
    </div>

<div class="info">
<div class="informasi">
    <?php $informasi = $conn->query("SELECT * FROM informasi ORDER BY waktu DESC"); ?>

    <h2>Daftar Informasi</h2>

    <div class="persatuancardinfo">
        <?php while ($row = $informasi->fetch_assoc()) { ?>
        <div class="cardinfo">
            <img src="../<?php echo $row['gambar']; ?>" alt="gambar">

        <div class="info-content">
            <h3><?php echo $row['judul']; ?></h3>
            <p><b>Tanggal:</b> <?php echo $row['waktu']; ?></p>

            <div class="actions">
                <a href="informasi.php?type=edit&ID=<?php echo $row['ID']; ?>" class="btn-edit">
                <i class="fa-solid fa-pen-to-square"></i> </a>
                <form method="POST" style="display:inline;">
                <input type="hidden" name="hapus_informasi" value="<?php echo $row['ID']; ?>">
                <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus pengguna ini?');">
                <i class="fa-solid fa-trash"></i> </button> </form>
            </div> 

        </div> </div> <!-- tutup info-content & cardinfo --> <?php } ?>
    </div>
</div>    
<div class="informasiaksi">
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
</form> </div>
</div>
</div>
</body>
    
