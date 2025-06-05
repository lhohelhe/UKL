<?php
include 'connfront.php';
include 'Admin/koneksiadmin.php';



// Prosesi Masuk Nggaknya
$type = isset($_GET['type']) ? $_GET['type'] : 'Tambah';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Nama'];
    $email = $_POST['Email'];
    
    if ($type == 'Tambah') {
    // Proses daftar
    $sql = "INSERT INTO pengguna (Nama, Email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?type=login");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    // LOGIN
    if ($name === 'Admin' && $email === 'Admin@gmail.com') {
        header("Location: Admin/$varuse?type=tambah");
        exit();
    } else {
        $sql = "SELECT * FROM pengguna WHERE Nama='$name' AND Email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            session_start();
            $_SESSION['Namapengguna'] = $user['Nama'];
            $_SESSION['PenggunaID'] = $user['ID'];
            header("Location: frontend/$beranda");
            exit();
        } else {
            echo "<script>alert('User tidak ditemukan!');</script>";
      }
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

