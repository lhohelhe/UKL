<?php
include 'koneksiadmin.php'; 

$type = isset($_GET['type']) ? $_GET['type'] : '';


    // Sekat -- kalo type nya edit
if ($type === 'edit' && isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $queryuser = "SELECT * FROM pengguna WHERE id = $id";
    $user = mysqli_query($conn, $queryuser);
    $row = mysqli_fetch_assoc($user);
}

    // sekat -- tombol post
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $usia = isset($_POST['usia']) ? $_POST['usia'] : null;

    // Sekat -- form tambahnya
    if ($type === 'tambah') {
        $sqluser = "INSERT INTO pengguna (Nama, Email, Usia) VALUES ('$nama', '$email', '$usia')";
        if ($conn->query($sqluser) === TRUE) {
            echo "Data berhasil ditambahkan!";
            header("Location: admin.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        // sekat form editnya
    } elseif ($type === 'edit' && isset($id)) {
        $updateQuery = "UPDATE pengguna SET Nama='$nama', Email='$email', Usia='$usia' WHERE id=$id";
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

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


if (isset($_POST['hapus_pengguna'])) {
    $id = $_POST['hapus_pengguna'];
    mysqli_query($conn, "DELETE FROM pengguna WHERE ID = $id");
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $type === 'tambah' ? 'Tambah Pengguna' : 'Edit Pengguna'; ?></title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="samping">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="user.php?type=tambah">Bagian User</a></li>
            <li><a href="pelatihan.php">Tambah Pelatihan</a></li>
            <li><a href="informasi.php">Tambah Informasi</a></li>
            <li><a href="../login.php?type=login" class="Kembali">Kembali</a></li>
        </ul>
    </div>
        <!-- INI BUAT NAMPILIN SEMUA USER -->
<div class="user">
    <div class="pengguna">
    <h2>Daftar User</h2>
    
        <!-- Card -->
        <?php if (mysqli_num_rows($pengguna) > 0): ?>

        <div class="persatuancarduser">
            <?php while ($rowpengguna = mysqli_fetch_assoc($pengguna)) :
                $idpengguna = htmlspecialchars($rowpengguna['ID']); ?>
                
        <div class="carduser">
            <table>
                <tr><td>
                    <strong>Nama</strong></td><td>: <?= htmlspecialchars($rowpengguna['Nama']); ?></td></tr>
                <tr><td>
                    <strong>Email</strong></td><td>: <?= htmlspecialchars($rowpengguna['Email']); ?></td></tr>
                <tr><td>
                    <strong>Usia</strong></td><td>: <?= htmlspecialchars($rowpengguna['Usia']); ?></td></tr>
            </table>

            <div class="actions">
                <a href="user.php?type=edit&ID=<?= $idpengguna ?>" class="btn-edit">
                <i class="fa-solid fa-pen-to-square"></i> </a>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="hapus_pengguna" value="<?= $idpengguna ?>">
                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus pengguna ini?');">
                    <i class="fa-solid fa-trash"></i> </button> </form>
            </div>
        </div>
            <?php endwhile; ?>
        </div>
            <?php else: ?>
            <p>Tidak ada data pengguna.</p>
            <?php endif; ?>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalhalaman; $i++) : ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalhalaman) : ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
</div>

   <div class="useraksi">
       <form class="carduser" method="POST">
        <h2><?php echo $type === 'tambah' ? 'Tambah User' : 'Edit User'; ?></h2>
        <label class="">Nama:</label>
        <input type="text" name="nama" value="<?php echo isset($row['Nama']) ? htmlspecialchars($row['Nama']) : ''; ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($row['Email']) ? htmlspecialchars($row['Email']) : ''; ?>" required><br>

        <label>Usia:</label>
        <input type="number" name="usia" value="<?php echo isset($row['Usia']) ? htmlspecialchars($row['Usia']) : ''; ?>" required><br>
        
        <button type="submit" name="simpan"><?php echo $type === 'tambah' ? 'Tambah' : 'Update'; ?></button>
        <a href="admin.php">Batal</a>
    </form>
    </div>

</div>
</body>
</html>
