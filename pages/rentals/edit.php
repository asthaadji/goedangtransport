<?php
// pages/rentals/edit.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$rental_id = intval($_GET['id']);
$message = '';

// Mengambil data peminjaman
$stmt = $pdo->prepare('
    SELECT rentals.*, customers.name, cars.license_plate, cars.rental_rate_per_day, cars.id AS car_id
    FROM rentals
    INNER JOIN customers ON rentals.customer_id = customers.id
    INNER JOIN cars ON rentals.car_id = cars.id
    WHERE rentals.id = ?
');
$stmt->execute([$rental_id]);
$rental = $stmt->fetch();

if (!$rental) {
    die('Data peminjaman tidak ditemukan.');
}

// Proses form edit peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

            // Update data peminjaman
            $update_stmt = $pdo->prepare('UPDATE rentals SET customer_id = ?, car_id = ?, rental_date = ?, days = ?, total_cost = ? WHERE id = ?');
            try {
                $update_stmt->execute([$customer_id, $car_id, $rental_date, $days, $total_cost, $rental_id]);

                // Jika mobil diubah, perbarui status mobil sebelumnya menjadi 'tersedia' dan yang baru menjadi 'dipinjam'
                if ($car_id != $rental['car_id']) {
                    // Update status mobil sebelumnya
                    $update_old_car = $pdo->prepare('UPDATE cars SET status = "tersedia" WHERE id = ?');
                    $update_old_car->execute([$rental['car_id']]);

                    // Update status mobil baru
                    $update_new_car = $pdo->prepare('UPDATE cars SET status = "dipinjam" WHERE id = ?');
                    $update_new_car->execute([$car_id]);
                }

                header('Location: list.php');
                exit;
            } catch (PDOException $e) {
                $message = 'Terjadi kesalahan saat mengupdate peminjaman.';
            }
        }
    } else {
        $message = 'Semua field wajib diisi!';
    }
}

// Mengambil daftar mobil yang tersedia atau yang sedang dipinjam oleh peminjaman ini
$available_cars_stmt = $pdo->prepare('SELECT * FROM cars WHERE status = "tersedia" OR id = ?');
$available_cars_stmt->execute([$rental['car_id']]);
$available_cars = $available_cars_stmt->fetchAll();
?>
<?php include '../../includes/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Edit Peminjaman Mobil</h1>
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
                    <h3 class="card-title">Form Edit Peminjaman</h3>
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
                                    $selected = ($customer['id'] == $rental['customer_id']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($customer['id']) . '" ' . $selected . '>' . htmlspecialchars($customer['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mobil</label>
                            <select name="car_id" class="form-control" required>
                                <option value="">-- Pilih Mobil --</option>
                                <?php
                                foreach ($available_cars as $car) {
                                    $selected = ($car['id'] == $rental['car_id']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($car['id']) . '" ' . $selected . '>' . htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']) . ' (' . htmlspecialchars($car['license_plate']) . ') - Rp ' . number_format($car['rental_rate_per_day'], 0, ',', '.') . '/hari</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Peminjaman</label>
                            <input type="date" name="rental_date" class="form-control" value="<?= htmlspecialchars($rental['rental_date']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Hari</label>
                            <input type="number" name="days" class="form-control" min="1" value="<?= htmlspecialchars($rental['days']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Total Biaya (Rp)</label>
                            <input type="text" class="form-control" value="<?= number_format($rental['total_cost'], 0, ',', '.') ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Peminjaman</button>
                        <a href="list.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include '../../includes/footer.php'; ?>
