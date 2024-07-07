<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Include the database connection file
include('db_connection.php');

// Function to add a new faculty
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO fakultas (name, description) VALUES ('$name', '$description')";
    if (mysqli_query($conn, $sql)) {
        $success_message = "Faculty added successfully.";
    } else {
        $error_message = "Error adding faculty: " . mysqli_error($conn);
    }
}

// Fetch all faculties
$result = mysqli_query($conn, "SELECT * FROM fakultas");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculties - SIAKAD</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="welcome.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fas fa-file-alt"></i> Manage Applications</a></li>
        <li><a href="viewadmin.php"><i class="fas fa-history"></i> View Login History</a></li>
        <li><a href="fakultas.php" class="active"><i class="fas fa-building"></i> Manage Faculties</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
    <div class="user-info">
        Connected as Admin
    </div>
</div>

<div class="main-content">
    <div class="container">
        <h1>Manage Faculties</h1>
        <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

        <!-- Add Faculty Form -->
        <form action="fakultas.php" method="POST">
            <h2>Add New Faculty</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <br>
            <button type="submit">Add Faculty</button>
        </form>

        <!-- Display Faculties -->
        <h2>Faculties</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 SIAKAD. All rights reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a> | 
            <a href="#">Contact Us</a>
        </p>
    </div>
</footer>

<script src="welcome.js"></script>

</body>
</html>
