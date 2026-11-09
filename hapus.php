
<?php

require_once 'config/database.php';

// Mengambil ID dari URL
$id = $_GET['id'] ?? '';

if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    die("ID mahasiswa tidak valid.");
}

// Menghapus data mahasiswa
$stmt = mysqli_prepare($conn, "DELETE FROM mahasiswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: data_mahasiswa.php");
    exit;
} else {
    die("Gagal menghapus data: " . mysqli_error($conn));
}

?>
