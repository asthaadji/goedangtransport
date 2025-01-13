<?php
// pages/rentals/delete.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

// Ambil ID peminjaman dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $rental_id = $_GET['id'];
} else {
    die('ID peminjaman tidak ditemukan atau tidak valid.');
}

// Query untuk mengambil data peminjaman berdasarkan ID
$stmt = $pdo->prepare('
    SELECT * FROM rentals WHERE id = :id AND deleted_at IS NULL
');
$stmt->bindParam(':id', $rental_id, PDO::PARAM_INT);
$stmt->execute();
$rental = $stmt->fetch();

if (!$rental) {
    die('Peminjaman tidak ditemukan atau sudah terhapus.');
}

// Proses soft delete (update deleted_at)
$deleteStmt = $pdo->prepare('
    UPDATE rentals 
    SET deleted_at = NOW() 
    WHERE id = :id
');
$deleteStmt->bindParam(':id', $rental_id, PDO::PARAM_INT);

if ($deleteStmt->execute()) {
    // Redirect ke halaman daftar peminjaman setelah berhasil melakukan soft delete
    header('Location: list.php');
    exit;
} else {
    echo 'Terjadi kesalahan saat melakukan soft delete.';
}
?>
