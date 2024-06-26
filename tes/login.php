<?php
// Proses Login
include('koneksi.php');
session_start();

if (isset($_POST['login'])) {
    // Mendapatkan nilai username, password, dan role dari form login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validasi input
    if (!empty($username) && !empty($password) && !empty($role)) {
        // Membuat query SQL untuk mendapatkan pengguna berdasarkan username, password, dan role
        $stmt = $conn->prepare("SELECT id, password, role FROM login WHERE username = ? AND role = ?");
        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $stmt->store_result();

        // Jika pengguna ditemukan
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_password, $db_role);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $db_password)) {
                // Set session variables
                $_SESSION['username'] = $username; // Menggunakan $username dari input, bukan $db_username dari database
                $_SESSION['role'] = $db_role;

                // Insert login history into database
                $login_time = date('Y-m-d H:i:s'); // Waktu login saat ini
                $ip_address = $_SERVER['REMOTE_ADDR']; // Alamat IP pengguna
                $page_accessed = 'dashboard.php'; // Halaman yang diakses setelah login (misalnya welcome.php)

                $stmt_insert = $conn->prepare("INSERT INTO login_history (user_id, login_time, ip_address, page_accessed) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("isss", $user_id, $login_time, $ip_address, $page_accessed);
                $stmt_insert->execute();

                $stmt_insert->close(); // Menutup statement INSERT

                // Redirect based on role
                if ($db_role === 'admin') {
                    echo '<script>alert("Login successful. Redirecting to admin dashboard."); window.location.href = "dashboard.php";</script>';
                } else {
                    echo '<script>alert("Login successful. Redirecting to user dashboard."); window.location.href = "user.php";</script>';
                }
                exit();
            } else {
                echo '<script>alert("Invalid username, password, or role.");</script>';
            }
        } else {
            echo '<script>alert("Invalid username, password, or role.");</script>';
        }

        $stmt->close(); // Menutup statement SELECT
    } else {
        echo '<script>alert("All fields are required.");</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css?v=<?php echo time();?>">
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIAKAD</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form method="post" id="login-form">
        <h2>Login SIAKAD</h2>
        <div class="input-container">
            <input type="text" name="username" id="username" required>
            <label for="username">Username</label>
        </div>
        <div class="input-container">
            <input type="password" name="password" id="password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-container custom-select">
            <select name="role" id="custom-select" required>
                <option value="" disabled selected>Pilih Status</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <label for="custom-select">Role</label>
        </div>
        <input type="submit" name="login" value="Login">
        <a href="signin.php">Sign up now</a>
    </form>
</body>
</html>

</body>
</html>



    <script src="java.js?v=<?php echo time();?>"></script>
</body>
</html>
