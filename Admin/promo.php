<?php
include 'koneksiadmin.php';

$queryPromo = "SELECT * FROM promo LIMIT 1";
$result = $conn->query($queryPromo);

if ($result && $result->num_rows > 0) {
    $promo = $result->fetch_assoc();
} else {
    $conn->query("INSERT INTO promo (pelatihanID, diskon) VALUES (0, 0)");
    $promo = ['ID' => $conn->insert_id, 'pelatihanID' => 0, 'diskon' => 0];
}

// Proses update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelatihanID = $_POST['pelatihanID'];
    $diskon = $_POST['diskon'];

    $update = "UPDATE promo SET pelatihanID = '$pelatihanID', diskon = '$diskon' WHERE ID = '1'";
    if ($conn->query($update)) {
        echo "<script>alert('Promo berhasil diperbarui.');window.location.href='promo.php';</script>";
        exit;
    } else {
        echo "Gagal update promo: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Promo</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
<!-- Sekat -->
<div class="promo">
    <h2>Edit Promo</h2>
    <form method="POST">
        <label for="pelatihanID">Pelatihan ID:</label>
        <input type="number" name="pelatihanID" id="pelatihanID" value="<?= htmlspecialchars($promo['pelatihanID']) ?>" required>

        <label for="diskon">Diskon (%):</label>
        <input type="number" name="diskon" id="diskon" value="<?= htmlspecialchars($promo['diskon']) ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>