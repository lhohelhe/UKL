<?php
include 'connfront.php';

// RUCIKA
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Prosesi Masuk Nggaknya
$type = isset($_GET['type']) ? $_GET['type'] : 'Tambah';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Nama'];
    $email = $_POST['Email'];
    
    if ($type == 'Tambah') {
        // Proses daftar
        $sql = "INSERT INTO pengguna (Nama, Email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            // Ambil ID pengguna yang baru saja ditambahkan
            $userId = $conn->insert_id; // Mendapatkan ID pengguna yang baru ditambahkan
            echo "Data berhasil ditambahkan!";
            // Simpan ID dalam session
            session_start();
            $_SESSION['User ID'] = $userId; // Simpan ID pengguna dalam session
            header("Location: login.php?type=login");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Proses login
        $sql = "SELECT * FROM pengguna WHERE Nama='$name' AND Email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ambil data pengguna
            $user = $result->fetch_assoc();
            session_start();
            $_SESSION['Nama'] = $user['Nama'];
            $_SESSION['PenggunaID'] = $user['ID']; // Simpan ID pengguna dalam session
            
            header("Location: frontend/$beranda");
            exit();
        } else {
            echo "<script>alert('User  tidak ditemukan!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Login.css">
    <title>Form Pengguna</title>
</head>
<body>
    <img src="Foto/Logo Tempa.jpg" class="logo">
    <h2><?php echo ($type == 'Tambah') ? 'Daftar' : 'Masuk'; ?></h2>
    <div class="login">  <!-- BUNGKUS -->
    <form method="post">
        <table>
        <tr>
            <th>Nama</th>
        </tr>
        <tr>
            <th><input type="text" name="Nama" required class="inputnya"></th> 
        </tr>
        <tr>
            <th>Email</th>
        </tr>
        <tr>
            <th><input type="email" name="Email" required class="inputnya"></th>
        </tr>
        </table>
        <br>
        <div class="tombol">
        <input type="submit" value="<?php echo ($type == 'Tambah') ? 'Simpan' : 'Login'; ?>">

    </form>  <!-- TOMBOL GANTI MODE -->
    <form method="get">
       <input type="hidden" name="type" value="<?php echo ($type == 'Tambah') ? 'login' : 'Tambah'; ?>">
       <input type="submit" value="<?php echo ($type == 'Tambah') ? 'Masuk akun' : 'Belum punya akun ?'; ?>" class="ganti">
       </div>
    </form>
    </div>
</body>
</html>

