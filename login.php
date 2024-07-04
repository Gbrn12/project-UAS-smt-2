<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIAKAD</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="heading">Login</div>
        <form action="login.php" method="post" class="form"> <!-- Action ditujukan ke process_login.php -->
            <input required="" class="input" type="email" name="email" id="email" placeholder="E-mail">
            <input required="" class="input" type="password" name="password" id="password" placeholder="Password">
            <div> <!-- Menggunakan custom-select untuk role -->
                <select class="input" name="role" id="custom-select" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <span class="forgot-password"><a href="#">Forgot Password ?</a></span>
            <input class="login-button" type="submit" name="login" value="Login">
        </form>
        <span class="agreement"><a href="#">rawr</a></span>
    </div>
</body>
</html>
<?php
// Proses Login
include('koneksi.php');
session_start();

if (isset($_POST['login'])) {
    // Mendapatkan nilai email, password, dan role dari form login
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validasi input
    if (!empty($email) && !empty($password) && !empty($role)) {
        // Membuat query SQL untuk mendapatkan pengguna berdasarkan email dan role
        $stmt = $conn->prepare("SELECT id, password, role FROM login WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $stmt->store_result();

        // Jika pengguna ditemukan
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_password, $db_role);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $db_password)) {
                // Set session variables
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $db_role;

                // Insert login history into database
                $login_time = date('Y-m-d H:i:s');
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $page_accessed = 'dashboard.php';

                $stmt_insert = $conn->prepare("INSERT INTO login_history (user_id, login_time, ip_address, page_accessed) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("isss", $user_id, $login_time, $ip_address, $page_accessed);
                $stmt_insert->execute();
                $stmt_insert->close();

                // Redirect based on role
                if ($db_role === 'admin') {
                    echo '<script>alert("Login successful. Redirecting to admin dashboard."); window.location.href = "dashboard.php";</script>';
                } else {
                    echo '<script>alert("Login successful. Redirecting to user dashboard."); window.location.href = "user.php";</script>';
                }
                exit();
            } else {
                echo '<script>alert("Invalid password."); window.location.href = "login.php";</script>';
            }
        } else {
            echo '<script>alert("Invalid email or role."); window.location.href = "login.php";</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("All fields are required."); window.location.href = "login.php";</script>';
    }
}
?>
