<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Mata Kuliah</title>
</head>
<body>
    <h2>Form Tambah Mata Kuliah</h2>
    <form action="proses_tambah_matakuliah.php" method="POST">
        <label for="fakultas">Nama Fakultas:</label><br>
        <select name="fakultas" id="fakultas">
            <option value="fakultas1">Fakultas 1</option>
            <option value="fakultas2">Fakultas 2</option>
            <option value="fakultas3">Fakultas 3</option>
            <!-- Tambahkan opsi sesuai dengan fakultas yang ada -->
        </select><br><br>

        <label for="prodi">Nama Program Studi:</label><br>
        <select name="prodi" id="prodi">
            <option value="prodi1">Program Studi 1</option>
            <option value="prodi2">Program Studi 2</option>
            <option value="prodi3">Program Studi 3</option>
            <!-- Tambahkan opsi sesuai dengan program studi yang ada -->
        </select><br><br>

        <label for="nama_matkul">Nama Mata Kuliah:</label><br>
        <input type="text" id="nama_matkul" name="nama_matkul" required><br><br>

        <label for="hari">Hari:</label><br>
        <input type="text" id="hari" name="hari" required><br><br>

        <label for="jam">Jam:</label><br>
        <input type="text" id="jam" name="jam" required><br><br>

        <label for="dosen">Nama Dosen Pengampu:</label><br>
        <select name="dosen" id="dosen">
            <option value="dosen1">Dosen 1</option>
            <option value="dosen2">Dosen 2</option>
            <option value="dosen3">Dosen 3</option>
            <!-- Tambahkan opsi sesuai dengan dosen yang ada -->
        </select><br><br>

        <input type="submit" value="Tambah Mata Kuliah">
    </form>
</body>
</html>
