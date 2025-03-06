<?php
include 'koneksi.php'; // Connect to the database

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $query = "SELECT * FROM pengguna WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $usia = $_POST['usia'];

    $updateQuery = "UPDATE pengguna SET Nama='$nama', Email='$email', Usia='$usia' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: admin.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>
    <h2>Edit Pengguna</h2>
    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($row['Nama']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" required><br>
        
        <label>Usia:</label>
        <input type="number" name="usia" value="<?php echo htmlspecialchars($row['Usia']); ?>" required><br>
        
        <button type="submit" name="update">Update</button>
        <a href="admin.php">Batal</a>
    </form>
</body>
</html>
