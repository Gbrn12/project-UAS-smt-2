<?php
// Koneksi ke database
include("koneksi.php");

// Ambil data dari form
$nama_fakultas = $_POST['nama_fakultas'];

// Insert data ke tabel fakultas
$sql = "INSERT INTO fakultas (nama_fakultas) VALUES ('$nama_fakultas')";

if ($conn->query($sql) === TRUE) {
    // Redirect kembali ke halaman fakultas setelah berhasil menambahkan data
    header('Location: fakulltas.php');
    exit();
} else {
    // Tampilkan pesan error jika query tidak berhasil
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi ke database
$conn->close();
?>
