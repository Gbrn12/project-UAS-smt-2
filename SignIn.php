<?php
include('koneksi.php');

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($username) && !empty($password) && !empty($role)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `login` (`username`, `password`, `role`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            echo '<script>alert("Sign up successful");</script>';
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("All fields are required.");</script>';
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css?v=<?php echo time();?>">
</head>
<body>
    <form method="post" id="signup-form">
        <h2>Sign Up SIAKAD</h2>
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
        <input type="submit" name="signup" value="Sign Up">
        <a href="login.php">Login now</a>
    </form>
    <script src="java.js?v=<?php echo time();?>"></script>
</body>
</html>
