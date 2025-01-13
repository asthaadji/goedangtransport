<?php
// pages/rentals/return.php
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
    SELECT rentals.*, customers.name AS customer_name, cars.license_plate, cars.id AS car_id
    FROM rentals
    INNER JOIN customers ON rentals.customer_id = customers.id
    INNER JOIN cars ON rentals.car_id = cars.id
    WHERE rentals.id = :id
');
$stmt->bindParam(':id', $rental_id, PDO::PARAM_INT);
$stmt->execute();
$rental = $stmt->fetch();

if (!$rental) {
    die('Peminjaman tidak ditemukan.');
}

// Jika tombol "Kembalikan" ditekan, proses pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengupdate status peminjaman menjadi "dikembalikan"
    $updateRentalStmt = $pdo->prepare('UPDATE rentals SET status = "dikembalikan", return_date = NOW() WHERE id = :id');
    $updateRentalStmt->bindParam(':id', $rental_id, PDO::PARAM_INT);

    // Mengupdate status mobil menjadi "tersedia"
    $updateCarStmt = $pdo->prepare('UPDATE cars SET status = "tersedia" WHERE id = :car_id');
    $updateCarStmt->bindParam(':car_id', $rental['car_id'], PDO::PARAM_INT); // Menggunakan hanya :car_id

    // Eksekusi query
    if ($updateRentalStmt->execute() && $updateCarStmt->execute()) {
        // Redirect ke halaman daftar peminjaman setelah berhasil mengembalikan
        header('Location: list.php');
        exit;
    } else {
        echo 'Terjadi kesalahan saat mengembalikan mobil.';
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Pengembalian Mobil</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Konfirmasi Pengembalian Mobil</h3>
                </div>
                <div class="card-body">
                    <p>Anda yakin ingin mengembalikan mobil berikut?</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Peminjaman</th>
                            <td><?php echo htmlspecialchars($rental['id']); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td><?php echo htmlspecialchars($rental['customer_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Plat Nomor</th>
                            <td><?php echo htmlspecialchars($rental['license_plate']); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td><?php echo htmlspecialchars($rental['rental_date']); ?></td>
                        </tr>
                        <tr>
                            <th>Total Biaya (Rp)</th>
                            <td><?php echo number_format($rental['total_cost'], 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                    <form method="POST" action="">
                        <button type="submit" class="btn btn-success">Kembalikan Mobil</button>
                        <a href="list.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
