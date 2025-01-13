<?php
// pages/rentals/add.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$message = '';

// Mengambil daftar mobil yang tersedia
$stmt = $pdo->prepare('SELECT * FROM cars WHERE status = "tersedia"');
$stmt->execute();
$cars = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $car_id = $_POST['car_id'];
    $rental_date = $_POST['rental_date'];
    $days = $_POST['days'];

    // Validasi input
    if ($customer_id && $car_id && $rental_date && $days) {
        // Mengambil tarif sewa per hari dari mobil yang dipilih
        $car_stmt = $pdo->prepare('SELECT rental_rate_per_day FROM cars WHERE id = ?');
        $car_stmt->execute([$car_id]);
        $car = $car_stmt->fetch();

        if (!$car) {
            $message = 'Mobil tidak ditemukan.';
        } else {
            $rental_rate_per_day = $car['rental_rate_per_day'];
            $total_cost = $rental_rate_per_day * $days;

            // Insert data peminjaman
            $insert_stmt = $pdo->prepare('INSERT INTO rentals (customer_id, car_id, rental_date, days, total_cost, status) VALUES (?, ?, ?, ?, ?, "dipinjam")');
            try {
                $insert_stmt->execute([$customer_id, $car_id, $rental_date, $days, $total_cost]);

                // Update status mobil menjadi 'dipinjam'
                $update_car_stmt = $pdo->prepare('UPDATE cars SET status = "dipinjam" WHERE id = ?');
                $update_car_stmt->execute([$car_id]);

                header('Location: list.php');
                exit;
            } catch (PDOException $e) {
                $message = 'Terjadi kesalahan saat menambah peminjaman.';
            }
        }
    } else {
        $message = 'Semua field wajib diisi!';
    }
}
?>
<?php include '../../includes/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Tambah Peminjaman Mobil</h1>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Peminjaman</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <select name="customer_id" class="form-control" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php
                                // Ambil daftar pelanggan
                                $customer_stmt = $pdo->prepare('SELECT * FROM customers');
                                $customer_stmt->execute();
                                $customers = $customer_stmt->fetchAll();
                                foreach ($customers as $customer) {
                                    echo '<option value="' . htmlspecialchars($customer['id']) . '">' . htmlspecialchars($customer['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mobil</label>
                            <select name="car_id" class="form-control" required>
                                <option value="">-- Pilih Mobil --</option>
                                <?php
                                foreach ($cars as $car) {
                                    echo '<option value="' . htmlspecialchars($car['id']) . '">' . htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']) . ' (' . htmlspecialchars($car['license_plate']) . ') - Rp ' . number_format($car['rental_rate_per_day'], 0, ',', '.') . '/hari</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Peminjaman</label>
                            <input type="date" name="rental_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Hari</label>
                            <input type="number" name="days" class="form-control" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Peminjaman</button>
                        <a href="list.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include '../../includes/footer.php'; ?>
