<?php
include 'koneksiadmin.php';

$editMode = false;
$id = '';
$program = '';
$harga = '';
$deskripsi = '';
$gambarLama = '';

if (isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['ID'])) {
    $editMode = true;
    $id = $_GET['ID'];
    $querypelatihan = "SELECT * FROM pelatihan WHERE id = $id";
    $pelatihan = $conn->query($querypelatihan);

    if ($pelatihan->num_rows > 0) {
        $row = $pelatihan->fetch_assoc();
        $program = $row['program'];
        $harga = $row['harga'];
        $deskripsi = $row['deskripsi'];
        $gambarLama = $row['gambar'];
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// Proses Submit
if (isset($_POST['submit'])) {
    $program = $_POST['program'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $target_dir = "upload/";
    $gambarBaru = '';

    if (!empty($_FILES['gambar']['name'])) {
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], "../$target_file")) {
            $gambarBaru = $target_file;
        } else {
            echo "Gagal mengupload gambar.";
            exit;
        }
    } else {
        $gambarBaru = $gambarLama;
    }

    if ($editMode) {
        // Edit data
        $sqlpelatihan = "UPDATE pelatihan SET program='$program', harga='$harga', deskripsi='$deskripsi', gambar='$gambarBaru' WHERE id=$id";
    } else {
        // Tambah data
        $sqlpelatihan = "INSERT INTO pelatihan (program, harga, deskripsi, gambar) 
                VALUES ('$program', '$harga', '$deskripsi', '$gambarBaru')";
    }

    if ($conn->query($sqlpelatihan) === TRUE) {
        header("Location: $varpel");
    } else {
        echo "Error: " . $sqlpelatihan . "<br>" . $conn->error;
    }
}

if (isset($_POST['hapus_pelatihan'])) {
    $id = $_POST['hapus_pelatihan'];
    mysqli_query($conn, "DELETE FROM pengguna WHERE ID = $id");
    header("Location: $varpel");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $editMode ? "Edit" : "Tambah" ?> Data Pelatihan</title>
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
            <li><a href="../login.php?type=login" class="Kembali">Kembali</a></li>
        </ul>
    </div>
<!-- INI BUAT NAMPILIN PELATIHAN --> 
<div class="pelatihanaksi">
<div class="pelatihan">
    <h2>Daftar Pelatihan</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Program</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>=-=-=-=</th>
        </tr>
            <?php $pelatihan = $conn->query("SELECT * FROM pelatihan");
            while ($rowpelatihan = $pelatihan->fetch_assoc()): 
            $idpelatihan= htmlspecialchars($rowpelatihan['ID']); ?>
        <tr>

            <td><?= $idpelatihan ?></td>
            <td><?= htmlspecialchars($rowpelatihan['program']) ?></td>
            <td><?= htmlspecialchars($rowpelatihan['harga']) ?></td>
            <td><?= htmlspecialchars($rowpelatihan['deskripsi']) ?></td>
            <td><img src="../<?= htmlspecialchars($rowpelatihan['gambar']) ?>" alt="Gambar Pelatihan"></td>
            <td><form method="POST" style="display:inline;">
            
        <div class="actions">
            <a href="pelatihan.php?type=edit&ID=<?= $idpelatihan ?>" class="btn-edit">
            <i class="fa-solid fa-pen-to-square"></i> </a>
            <input type="hidden" name="hapus_pelatihan" value="<?= $idpelatihan ?>">
            <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus pelatihan ini?');">
            <i class="fa-solid fa-trash"></i>
            </button> </form> </td>
        </div> </tr>

        <?php endwhile; ?> </table>
</div>
<!-- FORM INSERT -->
    <div class="cardpelatihan">
        <h2><?= $editMode ? "Edit" : "Tambah" ?> Data Pelatihan</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Program:</label>
            <input type="text" name="program" value="<?= htmlspecialchars($program) ?>" required>

            <label>Harga:</label>
            <input type="number" name="harga" value="<?= htmlspecialchars($harga) ?>" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($deskripsi) ?></textarea>

            <label>Upload Gambar:</label>
            <input type="file" name="gambar" accept="image/*">
            <?php if ($editMode && $gambarLama): ?>
                <small>Gambar saat ini: <?= basename($gambarLama) ?></small>
            <?php endif; ?>

            <button type="submit" name="submit"><?= $editMode ? "Update" : "Upload" ?></button>
        </form>
    </div>
</div>
</body>
</html>
