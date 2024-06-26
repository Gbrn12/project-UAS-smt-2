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

include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_dosen'])) {
        $id_dosen = $_POST['id_dosen'];

        // Delete data dosen
        $stmt = $conn->prepare("DELETE FROM dosen WHERE id=?");
        $stmt->bind_param("i", $id_dosen);

        if ($stmt->execute()) {
            // Redirect back to dosen.php with success message
            header('Location: dosen.php?success_delete=1');
            exit();
        } else {
            // Handle error
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID Dosen tidak valid.";
    }
}

$conn->close();
?>
