
<?php
require_once 'config/database.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $program_studi = trim($_POST['program_studi'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nim === '' || $nama === '' || $program_studi === '' || $email === '') {
        $pesan = 'Semua kolom wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = 'Format email tidak valid.';
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO mahasiswa (nim, nama, program_studi, email)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $nim,
            $nama,
            $program_studi,
            $email
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: data_mahasiswa.php");
            exit;
        } else {
            $pesan = 'Gagal menyimpan data. Pastikan NIM belum digunakan.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="data-mahasiswa">
    <h2>Tambah Data Mahasiswa</h2>

    <?php if ($pesan !== ''): ?>
        <p><?= htmlspecialchars($pesan); ?></p>
    <?php endif; ?>

    <form method="POST" action="tambah.php">
        <label>NIM</label>
        <input
            type="text"
            name="nim"
            maxlength="20"
            value="<?= htmlspecialchars($_POST['nim'] ?? ''); ?>"
            required
        >

        <label>Nama</label>
        <input
            type="text"
            name="nama"
            maxlength="100"
            value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
            required
        >

        <label>Program Studi</label>
        <input
            type="text"
            name="program_studi"
            maxlength="100"
            value="<?= htmlspecialchars($_POST['program_studi'] ?? ''); ?>"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            maxlength="100"
            value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>"
            required
        >

        <button type="submit">Simpan Data</button>
    </form>

    <p>
        <a href="data_mahasiswa.php">Kembali ke Data Mahasiswa</a>
    </p>
</main>

<script src="validasi.js"></script>
</body>
</html>
