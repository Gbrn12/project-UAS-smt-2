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
    if (isset($_POST['id_dosen'], $_POST['nama_dosen'], $_POST['email_dosen'], $_POST['password_dosen'], $_POST['program_studi'])) {
        $id_dosen = $_POST['id_dosen'];
        $nama_dosen = $_POST['nama_dosen'];
        $email_dosen = $_POST['email_dosen'];
        $password_dosen = $_POST['password_dosen'];
        $id_program_studi = $_POST['program_studi'];

        // Update data dosen
        $stmt = $conn->prepare("UPDATE dosen SET nama_dosen=?, email_dosen=?, password_dosen=?, id_program_studi=? WHERE id=?");
        $stmt->bind_param("sssii", $nama_dosen, $email_dosen, $password_dosen, $id_program_studi, $id_dosen);

        if ($stmt->execute()) {
            // Redirect back to dosen.php with success message
            header('Location: dosen.php?success_edit=1');
            exit();
        } else {
            // Handle error
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Semua kolom harus diisi.";
    }
}

if (isset($_GET['id'])) {
    $id_dosen = $_GET['id'];

    // Prepare the query to fetch data including email_dosen
    $stmt = $conn->prepare("SELECT dosen.id, dosen.nama_dosen, dosen.email_dosen, dosen.password_dosen, dosen.id_program_studi, program_studi.nama_program_studi 
                            FROM dosen 
                            INNER JOIN program_studi ON dosen.id_program_studi = program_studi.id 
                            WHERE dosen.id = ?");
    $stmt->bind_param("i", $id_dosen);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data dosen tidak ditemukan.";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Dosen</title>
    <style>
        label {
            display: block;
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Edit Data Dosen</h2>
    <form action="editDosen.php" method="post">
        <input type="hidden" name="id_dosen" value="<?php echo $row['id']; ?>">
        <label for="nama_dosen">Nama Dosen:</label>
        <input type="text" id="nama_dosen" name="nama_dosen" value="<?php echo $row['nama_dosen']; ?>" required>
        
        <label for="email_dosen">Email Dosen:</label>
        <input type="email" id="email_dosen" name="email_dosen" value="<?php echo $row['email_dosen']; ?>" required>
        
        <label for="password_dosen">Password Dosen:</label>
        <input type="password" id="password_dosen" name="password_dosen" value="<?php echo $row['password_dosen']; ?>" required>
        
        <label for="program_studi">Program Studi:</label>
        <select id="program_studi" name="program_studi" required>
            <?php
            // Koneksi ke database
            include("koneksi.php");

            // Ambil data program studi
            $sql_program_studi = "SELECT id, nama_program_studi FROM program_studi";
            $result_program_studi = $conn->query($sql_program_studi);

            if ($result_program_studi->num_rows > 0) {
                while($row_program_studi = $result_program_studi->fetch_assoc()) {
                    $selected = ($row_program_studi['id'] == $row['id_program_studi']) ? "selected" : "";
                    echo "<option value='{$row_program_studi['id']}' $selected>{$row_program_studi['nama_program_studi']}</option>";
                }
            } else {
                echo "<option value='' disabled>Tidak ada program studi tersedia</option>";
            }

            $conn->close();
            ?>
        </select>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>
