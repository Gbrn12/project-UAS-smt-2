<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakultas - Siakad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="fakultas.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Siakad</h2>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="fakulltas.php" class="active"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="programstudi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="matakuliah.php"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php"><i class="fas fa-chalkboard-teacher"></i> Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <img src="user.png" alt="User" width="30" height="30">
            <div>
                <h4>Admin</h4>
                <small>Connected</small>
            </div>
        </header>

        <main>
            <div class="content-container card">
                <h2>Fakultas</h2>
                <button class="add" onclick="openModal()">Tambah Data Fakultas</button>
                <div class="table-container">
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
                                // Inisialisasi nomor urut
                                $no = 1;
                                // Output data setiap baris
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama_fakultas']}</td>
                                        <td>
                                            <form action='editFakultas.php' method='post' class='edit-form'>
                                                <input type='hidden' name='fakultas_id' value='{$row['id']}'>
                                                <button class='add' type='submit' name='edit' class='edit-btn'>Edit</button>
                                            </form>
                                            <form action='deleteFakultas.php' method='post' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='delete-form'>
                                                <input type='hidden' name='fakultas_id' value='{$row['id']}'>
                                                <button class='add' type='submit' name='delete' class='delete-btn'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                    // Increment nomor urut
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div class="empty-state">
                        Tidak ada data fakultas lain saat ini.
                    </div>
                </div>
            </div>

            <!-- Modal for Adding Fakultas -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Tambah Data Fakultas</h2>
                    <form action="addFakultas.php" method="post">
                        <label for="nama_fakultas">Nama Fakultas:</label>
                        <input type="text" id="nama_fakultas" name="nama_fakultas" required>
                        <input type="submit" value="Tambah Fakultas">
                    </form>
                </div>
            </div>
        </main>
    </div>

    <button class="tombol" onclick="scrollToTop()">
        <span class="svgIcon"><i class="fas fa-arrow-up"></i></span>
    </button>

    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>
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
</html>
