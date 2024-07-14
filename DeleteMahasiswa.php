<?php
session_start();
include("koneksi.php");

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Pastikan ada data mahasiswa_id yang dikirimkan melalui POST
if (!isset($_POST['mahasiswa_id'])) {
    header('Location: mahasiswa.php');
    exit();
}

$mahasiswa_id = $_POST['mahasiswa_id'];

// Query untuk menghapus data mahasiswa berdasarkan ID
$sql = "DELETE FROM mahasiswa WHERE id = $mahasiswa_id";

if ($conn->query($sql) === TRUE) {
    // Redirect kembali ke halaman mahasiswa.php setelah berhasil
    header('Location: mahasiswa.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
