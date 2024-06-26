<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include("koneksi.php"); // Memuat koneksi ke database

// Lakukan query untuk mengambil data dosen
$sql = "SELECT dosen.id, fakultas.nama_fakultas, program_studi.nama_program_studi, dosen.nama_dosen
        FROM dosen
        INNER JOIN program_studi ON dosen.id_program_studi = program_studi.id
        INNER JOIN fakultas ON program_studi.id_fakultas = fakultas.id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen - Siakad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css?v=<?php echo time();?>">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Siakad</h2>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="fakultas.php"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="programstudi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="matakuliah.php"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php" class="active"><i class="fas fa-chalkboard-teacher"></i> Daftar Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
            <h2>Daftar Dosen</h2>
            <button onclick="openModal()">Tambah Data Dosen</button>

            <!-- Modal for Adding Dosen -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Tambah Data Dosen</h2>
                    <form id="form-dosen" action="tambahDosen.php" method="post">
                        <label for="fakultas">Nama Fakultas:</label>
                        <select id="fakultas" name="fakultas" required>
                            <option value="">Pilih Fakultas</option>
                            <?php
                            if ($result_fakultas->num_rows > 0) {
                                while($row_fakultas = $result_fakultas->fetch_assoc()) {
                                    echo "<option value='{$row_fakultas['id']}'>{$row_fakultas['nama_fakultas']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Tidak ada fakultas tersedia</option>";
                            }
                            ?>
                        </select>

                        <label for="program_studi">Nama Program Studi:</label>
                        <select id="program_studi" name="program_studi" required>
                            <option value="">Pilih Program Studi</option>
                            <?php
                            if ($result_program_studi->num_rows > 0) {
                                while($row_program_studi = $result_program_studi->fetch_assoc()) {
                                    echo "<option value='{$row_program_studi['id']}'>{$row_program_studi['nama_program_studi']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Tidak ada program studi tersedia</option>";
                            }
                            ?>
                        </select>

                        <label for="nama_dosen">Nama Dosen:</label>
                        <input type="text" id="nama_dosen" name="nama_dosen" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <input type="submit" value="Tambah Dosen">
                    </form>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Fakultas</th>
                        <th>Nama Program Studi</th>
                        <th>Nama Dosen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data setiap baris
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['nama_fakultas']}</td>";
                            echo "<td>{$row['nama_program_studi']}</td>";
                            echo "<td>{$row['nama_dosen']}</td>";
                            echo "<td>";
                            echo "<a href='editDosen.php?id={$row['id']}'>Edit</a> | ";
                            echo "<a href='deleteDosen.php?id={$row['id']}' onclick=\"return confirm('Anda yakin ingin menghapus data dosen ini?')\">Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data dosen</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
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
