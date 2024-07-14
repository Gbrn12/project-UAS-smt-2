<?php
session_start();
include("koneksi.php");

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil data dari form
$fakultas_id = $_POST['fakultas'];
$program_studi_id = $_POST['program_studi'];
$nama_mahasiswa = $_POST['nama_mahasiswa'];
$nim = $_POST['nim'];

// Query untuk menambahkan data
$sql = "INSERT INTO mahasiswa (nim, nama, program_studi) VALUES ('$nim', '$nama_mahasiswa', $program_studi_id)";

if ($conn->query($sql) === TRUE) {
    // Redirect kembali ke halaman mahasiswa.php setelah berhasil
    header('Location: mahasiswa.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
