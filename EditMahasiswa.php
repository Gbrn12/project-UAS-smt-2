<?php
session_start();
include("koneksi.php");

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil data dari form
$mahasiswa_id = $_POST['mahasiswa_id'];
$fakultas_id = $_POST['fakultas'];
$program_studi_id = $_POST['program_studi'];
$nama_mahasiswa = $_POST['nama_mahasiswa'];
$nim = $_POST['nim'];

// Query untuk mengupdate data
$sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama_mahasiswa', program_studi=$program_studi_id WHERE id=$mahasiswa_id";

if ($conn->query($sql) === TRUE) {
    // Redirect kembali ke halaman mahasiswa.php setelah berhasil
    header('Location: mahasiswa.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
