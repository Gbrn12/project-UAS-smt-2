<?php
// Koneksi ke database
include("koneksi.php");

// Pastikan hanya admin yang dapat mengakses halaman ini
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Proses jika form delete dikirimkan
if (isset($_POST['delete'])) {
    $program_studi_id = $_POST['program_studi_id'];

    // Hapus data program studi berdasarkan ID
    $sql = "DELETE FROM program_studi WHERE id = $program_studi_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Data program studi berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Redirect kembali ke halaman program_studi.php
header('Location: programstudi.php');
exit();
?>
