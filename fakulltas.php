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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakultas - Siakad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="abc.css">
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
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <div class="user-info">
            Connected as Admin
        </div>
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
            <h2>Fakultas</h2>
            <button onclick="openModal()">Tambah Data Fakultas</button>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Fakultas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    include("koneksi.php");

                    // Ambil data fakultas
                    $sql = "SELECT id, nama_fakultas FROM fakultas";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data setiap baris
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nama_fakultas']}</td>
        <td>
            <form action='editFakultas.php' method='post'>
                <input type='hidden' name='fakultas_id' value='{$row['id']}'>
                <button type='submit' name='edit'>Edit</button>
            </form>
            <form action='deleteFakultas.php' method='post' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                <input type='hidden' name='fakultas_id' value='{$row['id']}'>
                <button type='submit' name='delete'>Delete</button>
            </form>
        </td>
      </tr>";

                        }
                    } else {
                        echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal for Adding Faculty -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Tambah Data Fakultas</h2>
            <form action="addFakultas.php" method="post">
                <label for="nama_fakultas">Nama Fakultas:</label>
                <input type="text" id="nama_fakultas" name="nama_fakultas" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
