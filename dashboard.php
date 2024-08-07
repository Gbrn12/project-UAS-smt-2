<?php
    session_start();

    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Check if user is logged in
    if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit();
    }

    // Sambungkan ke database
    include('koneksi.php');

    // Query untuk mengambil jumlah data dosen
    $stmt_dosen = $conn->prepare("SELECT COUNT(*) FROM dosen");
    $stmt_dosen->execute();
    $stmt_dosen->bind_result($total_dosen);
    $stmt_dosen->fetch();
    $stmt_dosen->close();

    // Query untuk mengambil jumlah data mata kuliah
    $stmt_matakuliah = $conn->prepare("SELECT COUNT(*) FROM matakuliah");
    $stmt_matakuliah->execute();
    $stmt_matakuliah->bind_result($total_matakuliah);
    $stmt_matakuliah->fetch();
    $stmt_matakuliah->close();

    // Query untuk mengambil jumlah data program studi
    $stmt_programstudi = $conn->prepare("SELECT COUNT(*) FROM program_studi");
    $stmt_programstudi->execute();
    $stmt_programstudi->bind_result($total_programstudi);
    $stmt_programstudi->fetch();
    $stmt_programstudi->close();

    // Query untuk mengambil jumlah data mahasiswa
    $stmt_mahasiswa = $conn->prepare("SELECT COUNT(*) FROM mahasiswa");
    $stmt_mahasiswa->execute();
    $stmt_mahasiswa->bind_result($total_mahasiswa);
    $stmt_mahasiswa->fetch();
    $stmt_mahasiswa->close();
// Query untuk mengambil jumlah data fakultas
$stmt_fakultas = $conn->prepare("SELECT COUNT(*) FROM fakultas");
$stmt_fakultas->execute();
$stmt_fakultas->bind_result($total_fakultas);
$stmt_fakultas->fetch();
$stmt_fakultas->close();

    // Tutup koneksi ke database
    $conn->close();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SIAKAD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css?v=<?php echo time();?>">
    <style>
        /* Additional CSS styles can be added here */
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Siakad</h2>
        </div>
        <ul>
            <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="fakulltas.php"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="programstudi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="matakuliah.php"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php"><i class="fas fa-chalkboard-teacher"></i> Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <div class="user-wrapper">
                <img src="anime-girl-horn-katana-fantasy-4k-wallpaper-uhdpaper.com-726@0@j.jpg" alt="User" width="30" height="30">
                <div>
                    <h4>Admin</h4>
                    <small>Connected</small>
                </div>
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fas fa-users"></i>
                <div class="card-content">
                    <h5>Total Mahasiswa</h5>
                    <h2><?php echo $total_mahasiswa; ?></h2>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-chalkboard-teacher"></i>
                <div class="card-content">
                    <h5>Total Dosen</h5>
                    <h2><?php echo $total_dosen; ?></h2>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-book"></i>
                <div class="card-content">
                    <h5>Total Mata Kuliah</h5>
                    <h2><?php echo $total_matakuliah; ?></h2>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-graduation-cap"></i>
                <div class="card-content">
                    <h5>Total Program Studi</h5>
                    <h2><?php echo $total_programstudi; ?></h2>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-building"></i>
                <div class="card-content">
                    <h5>Total Fakultas</h5>
                    <h2><?php echo $total_fakultas; ?></h2>
                </div>
            </div>
        </div>

        <div class="notifications">
            <h3>Pemberitahuan Terbaru</h3>
            <ul>
                <li><strong>Peringatan:</strong> Batas waktu pendaftaran ulang mahasiswa akan berakhir dalam 3 hari.</li>
                <li><strong>Info:</strong> Penjadwalan ujian tengah semester telah diperbarui.</li>
            </ul>
        </div>
        
        <div class="data-table">
            <h3>Data Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Teknik Informatika</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Akuntansi</td>
                        <td>Aktif</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

        <div class="upcoming-events">
            <h3>Acara Mendatang</h3>
            <ul>
                <li><strong>Webinar:</strong> Implementasi AI dalam Pendidikan - 10 Juli 2024</li>
                <li><strong>Konferensi:</strong> Pengembangan Kurikulum Berbasis Kompetensi - 15 Juli 2024</li>
            </ul>
        </div>
        
        <div class="quick-links">
            <h3>Tautan Cepat</h3>
            <ul>
                <li><a href="#">Pengaturan Akun</a></li>
                <li><a href="#">Ganti Kata Sandi</a></li>
                <li><a href="#">Laporan Bulanan</a></li>
                <li><a href="#">Panduan Pengguna</a></li>
            </ul>
        </div>
        

        <footer class="footer">
    <div class="footer-content">
        <p>💀&copy;2024 SIAKAD. All rights reserved.💀</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </p>
    </div>
</footer>

    </div>
</body>
</html>
