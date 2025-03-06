<?php
include 'koneksi.php'; // Sambung ke database

$query = "SELECT * FROM pengguna"; // Ambil data pengguna
$result = mysqli_query($conn, $query); 

// Handle delete request
if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
    $deleteQuery = "DELETE FROM pengguna WHERE ID = $ID";

    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: admin.php"); // Redirect back after deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
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
<body>

    <style>
        .card {
    padding: 10px;
}

.card table {
    width: 100%;
    border-collapse: collapse;
}

.card table td {
    padding: 5px;
    vertical-align: top;
}

.actions {
    display: flex;
    justify-content: start;
    gap: 10px;
    margin-top: 10px;
}

.btn-edit {
    text-decoration: none;
    color: blue;
}

.btn-delete {
    border: none;
    background: none;
    cursor: pointer;
}

.btn-delete i {
    color: red;
}
ul li a{
    text-decoration: none;
    color:rgb(255, 255, 255);
}
    </style>

<div class="wrapper">
    <div class="sidebar">
        <h2>Cari User</h2>
        <ul>
            
            <li><a href="../login.php?type=login" class="Kembali">Kembali</a></li>
        </ul>
    </div>
    <div class="container">

    <!-- INI BUAT NAMPILIN SEMUA USER -->
    <?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>";

        echo "<table>"; //Tabel nya
        echo "<tr><td><strong>Nama</strong></td><td>: " . htmlspecialchars($row['Nama']) . "</td></tr>";
        echo "<tr><td><strong>Email</strong></td><td>: " . htmlspecialchars($row['Email']) . "</td></tr>";
        echo "<tr><td><strong>Usia</strong></td><td>: " . htmlspecialchars($row['Usia']) . "</td></tr>";
        echo "</table>";  //Penutup Tabel nya

        echo "<div class='actions'>";
        echo "<a href='edit.php?ID=" . $row['ID'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>"; // Tombol Edit
        echo "<form action='' method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='ID' value='" . $row['ID'] . "'>";
        echo "<button type='submit' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>";       echo "<i class='fa-solid fa-trash'></i>"; // Tombol Hapus

        echo "</form>" ."</div>" ."</div>";
    }
} else {
    echo "<p>Tidak ada data pengguna.</p>";
}
?>

    </div>
</div>
</body>
</html>
