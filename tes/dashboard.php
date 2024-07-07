<?php
// Mulai session
session_start();

// Cek apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}
?>
<!-- Admin Dashboard - SIAKAD -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SIAKAD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css?v=<?php echo time();?>">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Siakad</h2>
        </div>
        <ul>
            <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="fakultas.php"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="program_studi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="mata_kuliah.php"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php"><i class="fas fa-chalkboard-teacher"></i> Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <div class="user-wrapper">
                <img src="user.png" alt="User" width="30" height="30">
                <div>
                    <h4>Admin</h4>
                    <small>Connected</small>
                </div>
            </div>
        </header>
        <main>
            <h2>Dashboard</h2>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>2</h1>
                        <span>Mahasiswa</span>
                    </div>
                    <div>
                        <span class="fas fa-user-graduate"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>5</h1>
                        <span>Dosen</span>
                    </div>
                    <div>
                        <span class="fas fa-chalkboard-teacher"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>5</h1>
                        <span>Mata Kuliah</span>
                    </div>
                    <div>
                        <span class="fas fa-book"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>5</h1>
                        <span>Jadwal Diambil Mahasiswa</span>
                    </div>
                    <div>
                        <span class="fas fa-calendar-alt"></span>
                    </div>
                </div>
            </div>
            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pendaftar Mahasiswa Terakhir</h3>
                        </div>
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Budi Hartono</td>
                                        <td>budi@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Angga Setiawan</td>
                                        <td>angga@gmail.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="customers"></div>
            </div>
        </main>
    </div>
</body>
</html>
