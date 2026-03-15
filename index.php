<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "belajar_crud";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    mysqli_query($koneksi, "INSERT INTO mahasiswa (nama, jurusan) VALUES ('$nama', '$jurusan')");
    header("Location: index.php"); // Refresh halaman
}


if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id=$id");
    header("Location: index.php");
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    mysqli_query($koneksi, "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan' WHERE id=$id");
    header("Location: index.php");
}


$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id=$id");
    $edit_data = mysqli_fetch_array($result);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tugas Inready</title>
</head>

<body>

    <h1>Data Mahasiswa</h1>

    <fieldset>
        <legend><?php echo $edit_data ? "Edit Data" : "Tambah Data"; ?></legend>
        <form action="index.php" method="POST">
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
            <?php endif; ?>

            <label>Nama:</label><br>
            <input type="text" name="nama" value="<?php echo $edit_data ? $edit_data['nama'] : ''; ?>" required><br><br>

            <label>Jurusan:</label><br>
            <input type="text" name="jurusan" value="<?php echo $edit_data ? $edit_data['jurusan'] : ''; ?>" required><br><br>

            <?php if ($edit_data): ?>
                <button type="submit" name="update">Simpan Perubahan</button>
                <a href="index.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="tambah">Tambah Mahasiswa</button>
            <?php endif; ?>
        </form>
    </fieldset>

    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY id DESC");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jurusan']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $data['id']; ?>">Edit</a> |
                        <a href="index.php?hapus=<?php echo $data['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>
