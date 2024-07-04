<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Mata Kuliah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="matakuliah.css"> <!-- Ganti dengan path CSS yang sesuai -->

    <style>
        /* Contoh styling tambahan untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
            <li><a href="fakulltas.php"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="programstudi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="matakuliah.php" class="active"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php"><i class="fas fa-chalkboard-teacher"></i> Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <img src="anime-girl-horn-katana-fantasy-4k-wallpaper-uhdpaper.com-726@0@j.jpg" alt="User" width="30" height="30">
            <div>
                <h4>Admin</h4>
                <small>Connected</small>
            </div>
        </header>

        <main>
            <h2>Form Tambah Mata Kuliah</h2>
            <form action="proses_tambah_matakuliah.php" method="POST">
                <label for="fakultas">Nama Fakultas:</label><br>
                <select name="fakultas" id="fakultas">
                    <?php
                    // Include database connection file
                    include("koneksi.php");

                    // Query to retrieve fakultas data
                    $sql_fakultas = "SELECT id, nama_fakultas FROM fakultas";
                    $result_fakultas = $conn->query($sql_fakultas);

                    // Populate select options with fakultas data
                    if ($result_fakultas->num_rows > 0) {
                        while($row_fakultas = $result_fakultas->fetch_assoc()) {
                            echo "<option value='{$row_fakultas['nama_fakultas']}'>{$row_fakultas['nama_fakultas']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Tidak ada fakultas tersedia</option>";
                    }

                    // Close result and database connection
                    $result_fakultas->close();
                    ?>
                </select><br><br>

                <label for="prodi">Nama Program Studi:</label><br>
                <select name="prodi" id="prodi">
                    <?php
                    // Query to retrieve program studi data
                    $sql_program_studi = "SELECT id, nama_program_studi FROM program_studi";
                    $result_program_studi = $conn->query($sql_program_studi);

                    // Populate select options with program studi data
                    if ($result_program_studi->num_rows > 0) {
                        while($row_program_studi = $result_program_studi->fetch_assoc()) {
                            echo "<option value='{$row_program_studi['nama_program_studi']}'>{$row_program_studi['nama_program_studi']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Tidak ada program studi tersedia</option>";
                    }

                    // Close result
                    $result_program_studi->close();
                    ?>

                </select><br><br>

                <label for="nama_matkul">Nama Mata Kuliah:</label><br>
                <input type="text" id="nama_matkul" name="nama_matkul" required><br><br>

                <label for="hari">Hari:</label><br>
                <input type="text" id="hari" name="hari" required><br><br>

                <label for="jam">Jam:</label><br>
                <input type="time" id="jam" name="jam" required><br><br>

                <label for="dosen">Nama Dosen Pengampu:</label><br>
                <select name="dosen" id="dosen">
                    <?php
                    // Query to retrieve dosen data
                    $sql_dosen = "SELECT id, nama_dosen FROM dosen";
                    $result_dosen = $conn->query($sql_dosen);

                    // Populate select options with dosen data
                    if ($result_dosen->num_rows > 0) {
                        while($row_dosen = $result_dosen->fetch_assoc()) {
                            echo "<option value='{$row_dosen['nama_dosen']}'>{$row_dosen['nama_dosen']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Tidak ada dosen tersedia</option>";
                    }

                    // Close result
                    $result_dosen->close();
                    ?>

                </select><br><br>

                <input type="submit" value="Tambah Mata Kuliah">
            </form>

            <!-- Tampilkan data mata kuliah dalam tabel -->
            <h2>Data Mata Kuliah</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Fakultas</th>
                        <th>Program Studi</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Dosen Pengampu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to retrieve mata kuliah data
                    $sql_matakuliah = "SELECT fakultas, prodi, nama_matkul, hari, jam, dosen FROM matakuliah";
                    $result_matakuliah = $conn->query($sql_matakuliah);

                    // Populate table rows with mata kuliah data
                    if ($result_matakuliah->num_rows > 0) {
                        $no = 1;
                        while($row_matakuliah = $result_matakuliah->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$row_matakuliah['fakultas']}</td>";
                            echo "<td>{$row_matakuliah['prodi']}</td>";
                            echo "<td>{$row_matakuliah['nama_matkul']}</td>";
                            echo "<td>{$row_matakuliah['hari']}</td>";
                            echo "<td>{$row_matakuliah['jam']}</td>";
                            echo "<td>{$row_matakuliah['dosen']}</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data mata kuliah tersedia.</td></tr>";
                    }

                    // Close result
                    $result_matakuliah->close();
                    ?>
                </tbody>
            </table>
        </main>
    </div>

 

    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>


    <script type="text/javascript">
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        if (message === 'success') {
            alert('Data mata kuliah berhasil ditambahkan!');
        }
    };
</script>

</body>
<button class="button" onclick="scrollToTop()">
        <span class="svgIcon"><i class="fas fa-arrow-up"></i></span>
    </button>
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
