<?php
// Mulai session
session_start();

// Periksa apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}

// Include file koneksi database
include("koneksi.php");

// Deklarasi variabel untuk menyimpan pesan kesalahan dan pesan berhasil
$error = '';
$success = '';

// Proses jika form telah disubmit
// Proses jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan semua data diperiksa dengan isset() atau empty() sebelum digunakan
    if (isset($_POST['nama_dosen'], $_POST['email_dosen'], $_POST['password_dosen'], $_POST['program_studi'])) {
        // Ambil data dari form
        $nama_dosen = $_POST['nama_dosen'];
        $email_dosen = $_POST['email_dosen'];
        $password_dosen = $_POST['password_dosen'];
        $id_program_studi = $_POST['program_studi'];

        // Validasi data (contoh sederhana)
        if (empty($nama_dosen) || empty($email_dosen) || empty($password_dosen) || empty($id_program_studi)) {
            $error = "Semua kolom harus diisi.";
        } else {
            // Lanjutkan dengan proses menyimpan ke database
        }
    } else {
        $error = "Pastikan semua kolom diisi dengan benar.";
    }
}


// Ambil data program studi untuk dropdown
$sql_program_studi = "SELECT id, nama_program_studi FROM program_studi";
$result_program_studi = mysqli_query($conn, $sql_program_studi);

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <style>
        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container h2 {
            text-align: center;
        }
        .form-container .form-group {
            margin-bottom: 10px;
        }
        .form-container .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-container .form-group input[type="text"],
        .form-container .form-group input[type="email"],
        .form-container .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .form-container .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .form-container .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Dosen</h2>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nama_dosen">Nama Dosen:</label>
                <input type="text" id="nama_dosen" name="nama_dosen" required>
            </div>
            <div class="form-group">
                <label for="email_dosen">Email Dosen:</label>
                <input type="email" id="email_dosen" name="email_dosen" required>
            </div>
            <div class="form-group">
                <label for="password_dosen">Password Dosen:</label>
                <input type="password" id="password_dosen" name="password_dosen" required>
            </div>
            <div class="form-group">
                <label for="program_studi">Program Studi:</label>
                <select id="program_studi" name="program_studi" required>
                    <option value="">Pilih Program Studi</option>
                    <?php while ($row = mysqli_fetch_assoc($result_program_studi)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_program_studi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Tambah Dosen">
            </div>
        </form>
    </div>
</body>
</html>
