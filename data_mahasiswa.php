
<?php

require_once 'config/database.php';

$sql = "SELECT * FROM mahasiswa";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Data Mahasiswa</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>BIODATA SAYA</h1>

    <p>Website Biodata Sederhana</p>

    <p>Mata Kuliah Web Programming 1</p>
</header>

<nav>
    <a href="index.html">Biodata</a>

    <a href="layout.html">Layout Experiment</a>

    <a href="data_mahasiswa.php">Data Mahasiswa</a>

    <a href="index.html#tentang">Tentang Saya</a>

    <a href="index.html#pendidikan">Pendidikan</a>

    <a href="index.html#hobi">Hobi</a>

    <a href="index.html#sosial-media">Social Media</a>
</nav>

<main class="data-mahasiswa">

    <h2>Data Mahasiswa</h2>

    <!-- Tombol Tambah Data -->
    <p>
        <a href="tambah.php">+ Tambah Data Mahasiswa</a>
    </p>

    <div class="table-container">

        <table>

            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <tr>
                <td>
                    <?= htmlspecialchars($row['id']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['nim']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['nama']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['program_studi']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['email']); ?>
                </td>

                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>

                    <a href="hapus.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Hapus
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>

    </div>

    <a href="index.html" class="kembali">
        ← Kembali ke Beranda
    </a>

</main>

<footer>
    <p>Copyright &copy; 2026 - Mufrika</p>

    <p>Web Programming 1</p>
</footer>

</body>
</html>

<?php

mysqli_close($conn);

?>
