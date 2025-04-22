<?php
include 'koneksiadmin.php';

// BAGIAN USER
// sekat -- jumlah user yang akan di tampilkan
$userperhalaman = 6; 

// belum paham maksudnya --
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $userperhalaman;

// ini juga belum paham --
$hitungtotaluser = "SELECT COUNT(*) AS total FROM pengguna";
$hasilperhitunganuser = mysqli_query($conn, $hitungtotaluser);
$totalbarisuser = mysqli_fetch_assoc($hasilperhitunganuser);
$totalpengguna = $totalbarisuser['total'];

// menampilkan data user sesuai dengan maksimal data yang dapat ditampilkan
$selectuser = "SELECT * FROM pengguna LIMIT $userperhalaman OFFSET $offset";
$pengguna = mysqli_query($conn, $selectuser); 
$totalhalaman = ceil($totalpengguna / $userperhalaman);



// =-=-=-= INI BUAT HAPUS DATA (SEMUA TERCANTUM) =-=--= //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hapus_pengguna'])) {
        $id = $_POST['hapus_pengguna'];
        mysqli_query($conn, "DELETE FROM pengguna WHERE ID = $id");
        header("Location: admin.php");
        exit();
    }

    if (isset($_POST['hapus_pelatihan'])) {
        $id = $_POST['hapus_pelatihan'];
        mysqli_query($conn, "DELETE FROM pelatihan WHERE ID = $id");
        header("Location: admin.php");
        exit();
    }
}
// =-=-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= //

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKL</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>


<!-- Sampingan -->
    <div class="samping">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="user.php?type=tambah">Tambah User</a></li>
            <li><a href="pelatihan.php">Tambah Pelatihan</a></li>
            <li><a href="informasi.php">Tambah Informasi</a></li>
            <li><a href="../login.php?type=login" class="Kembali">Kembali</a></li>
        </ul>
    </div>
<!-- =-=-=-=-= -->

<div class="allexptsidebar">
<!-- INI BUAT NAMPILIN PELATIHAN -->
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

<!-- INI BUAT NAMPILIN INFORMASI -->
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

</div> <!-- allexptsidebar -->
</body>
</html>
