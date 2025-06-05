<?php
include 'koneksiadmin.php';

$userperhalaman = 6; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $userperhalaman;

$hitungtotalpendaftaran = "SELECT COUNT(*) AS total FROM pendaftaran";
$hasilperhitunganpendaftaran = mysqli_query($conn, $hitungtotalpendaftaran);
$totalbarispendaftaran = mysqli_fetch_assoc($hasilperhitunganpendaftaran);
$totalpendaftaran = $totalbarispendaftaran['total'];

$selectpendaftaran = "SELECT * FROM pendaftaran LIMIT $userperhalaman OFFSET $offset";
$pendaftaran_records = mysqli_query($conn, $selectpendaftaran); 
$totalhalaman = ceil($totalpendaftaran / $userperhalaman);

$row = [
    'ID' => '',
    'pelatihanID' => '',
    'PenggunaID' => '',
    'status' => '',
    'diskon' => ''
];

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $querypnd = "SELECT * FROM pendaftaran WHERE ID = $id";
    $pendaftaran = mysqli_query($conn, $querypnd);

    if ($pendaftaran && mysqli_num_rows($pendaftaran) > 0) {
        $row = mysqli_fetch_assoc($pendaftaran);
    }
}

// Tangani update status
if (isset($_POST['simpan'])) {
    $status = $_POST['status'];
    $updateQuery = "UPDATE pendaftaran SET status='$status' WHERE ID='$id'";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: $varpnd");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Tangani update diskon
if (isset($_POST['simpan_diskon'])) {
    $diskon = $_POST['diskon'];
    $updateDiskonQuery = "UPDATE pendaftaran SET diskon='$diskon' WHERE ID='$id'";
    if (mysqli_query($conn, $updateDiskonQuery)) {
        header("Location: $varpnd");
        exit();
    } else {
        echo "Error updating diskon: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pendaftaran Backend</title>
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

<div class="pendaftaran">
<div class="pnd">
<h2>Daftar Pendaftaran</h2>

<?php if (mysqli_num_rows($pendaftaran_records) > 0): ?>
<div class="persatuancardpendaftaran">
<?php while ($rowpendaftaran = mysqli_fetch_assoc($pendaftaran_records)) :
    $idpendaftaran = htmlspecialchars($rowpendaftaran['ID']); ?>
    <div class="cardpendaftaran">
        <table>
            <tr><td><strong>ID</strong></td><td>: <?= $idpendaftaran ?></td></tr>
            <tr><td><strong>Tanggal</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['Tanggal']); ?></td></tr>
            <tr><td><strong>Administrasi</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['administrasi']); ?></td></tr>
            <tr><td><strong>Kontak</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['kontak']); ?></td></tr>
            <tr><td><strong>Pengguna ID</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['PenggunaID']); ?></td></tr>
            <tr><td><strong>Status</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['status']); ?></td></tr>
            <tr><td><strong>Pelatihan ID</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['pelatihanID']); ?></td></tr>
            <tr><td><strong>Diskon (%)</strong></td><td>: <?= htmlspecialchars($rowpendaftaran['diskon'] ?? '0'); ?></td></tr>
        </table>
        <div class="actions">
            <a href="pendaftaran.php?ID=<?= $idpendaftaran ?>" class="btn-edit">
                <i class="fa-solid fa-pen-to-square"></i></a>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="hapus_pendaftaran" value="<?= $idpendaftaran ?>">
                <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus pendaftaran ini?');">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
<?php endwhile; ?>
</div>
<?php else: ?>
<p>Tidak ada data pendaftaran.</p>
<?php endif; ?>

<div class="pagination">
<?php for ($i = 1; $i <= $totalhalaman; $i++): ?>
<a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i ?></a>
<?php endfor; ?>
</div>
</div>

<div class="pndaksi">
<form class="cardpnd" method="POST">
<h2>Update Status</h2>
<?php if (!empty($row['ID'])): ?>
<table>
    <tr><td><strong>ID</strong></td><td>: <?= htmlspecialchars($row['ID']); ?></td></tr>
    <tr><td><strong>Pelatihan ID</strong></td><td>: <?= htmlspecialchars($row['pelatihanID']); ?></td></tr>
    <tr><td><strong>Pengguna ID</strong></td><td>: <?= htmlspecialchars($row['PenggunaID']); ?></td></tr>
</table>

<label for="status">Status:</label>
<select name="status" id="status" required>
<option selected disabled><?= htmlspecialchars($row['status']); ?></option>
<?php $liststatus = ['Menunggu', 'Ditolak', 'Diterima', 'Selesai'];
foreach ($liststatus as $status):
    if ($status !== $row['status']): ?>
    <option value="<?= htmlspecialchars($status); ?>"><?= htmlspecialchars($status); ?></option>
<?php endif; endforeach; ?>
</select>
<button type="submit" name="simpan">Update Status</button>
<?php else: ?>
<p><em>Silakan pilih data pendaftaran untuk mengubah status.</em></p>
<?php endif; ?>
</form>

<!-- Form Update Diskon -->
<?php if (!empty($row['ID'])): ?>
<form class="cardpnd" method="POST">
<h2>Update Diskon</h2>
<label for="diskon">Diskon (%)</label>
<input type="number" name="diskon" id="diskon" min="0" max="100" value="<?= htmlspecialchars($row['diskon']); ?>" required>
<button type="submit" name="simpan_diskon">Update Diskon</button>
</form>
<?php endif; ?>

</div>
</div>

</body>
</html>
