
<?php
require_once 'config/database.php';

// Mengambil ID mahasiswa dari URL
$id = $_GET['id'] ?? '';

if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    die("ID mahasiswa tidak valid.");
}

// Mengambil data mahasiswa berdasarkan ID
$stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$mahasiswa = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$mahasiswa) {
    die("Data mahasiswa tidak ditemukan.");
}

$pesan = '';

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $program_studi = trim($_POST['program_studi'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nim === '' || $nama === '' || $program_studi === '' || $email === '') {
        $pesan = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = "Format email tidak valid.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE mahasiswa
             SET nim = ?, nama = ?, program_studi = ?, email = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $nim,
            $nama,
            $program_studi,
            $email,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: data_mahasiswa.php");
            exit;
        } else {
            $pesan = "Gagal memperbarui data. Pastikan NIM belum digunakan.";
        }

        mysqli_stmt_close($stmt);
    }

    // Menampilkan kembali data yang sudah diinput
    $mahasiswa['nim'] = $nim;
    $mahasiswa['nama'] = $nama;
    $mahasiswa['program_studi'] = $program_studi;
    $mahasiswa['email'] = $email;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<main class="data-mahasiswa">

    <h2>Edit Data Mahasiswa</h2>

    <?php if ($pesan !== ''): ?>
        <p><?= htmlspecialchars($pesan); ?></p>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= $id; ?>">

        <label>NIM</label>
        <input
            type="text"
            name="nim"
            maxlength="20"
            value="<?= htmlspecialchars($mahasiswa['nim']); ?>"
            required
        >

        <label>Nama</label>
        <input
            type="text"
            name="nama"
            maxlength="100"
            value="<?= htmlspecialchars($mahasiswa['nama']); ?>"
            required
        >

        <label>Program Studi</label>
        <input
            type="text"
            name="program_studi"
            maxlength="100"
            value="<?= htmlspecialchars($mahasiswa['program_studi']); ?>"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            maxlength="100"
            value="<?= htmlspecialchars($mahasiswa['email']); ?>"
            required
        >

        <button type="submit">Update Data</button>

    </form>

    <p>
        <a href="data_mahasiswa.php">Kembali ke Data Mahasiswa</a>
    </p>

</main>

<script src="validasi.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
