<?php
// pages/cars/edit.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$car_id = intval($_GET['id']);
$message = '';

// Mengambil data mobil
$stmt = $pdo->prepare('SELECT * FROM cars WHERE id = ?');
$stmt->execute([$car_id]);
$car = $stmt->fetch();

if (!$car) {
    die('Data mobil tidak ditemukan.');
}

// Proses form edit mobil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $license_plate = $_POST['license_plate'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $rental_rate_per_day = $_POST['rental_rate_per_day'];
    $status = $_POST['status'];

    // Validasi input
    if ($license_plate && $make && $model && $year && $rental_rate_per_day && $status) {
        $update_stmt = $pdo->prepare('UPDATE cars SET license_plate = ?, make = ?, model = ?, year = ?, rental_rate_per_day = ?, status = ? WHERE id = ?');
        try {
            $update_stmt->execute([$license_plate, $make, $model, $year, $rental_rate_per_day, $status, $car_id]);
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $message = 'Plat nomor sudah ada!';
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
            <h1 class="m-0">Edit Mobil</h1>
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
                    <h3 class="card-title">Form Edit Mobil</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Plat Nomor</label>
                            <input type="text" name="license_plate" class="form-control" value="<?= htmlspecialchars($car['license_plate']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Merek</label>
                            <input type="text" name="make" class="form-control" value="<?= htmlspecialchars($car['make']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($car['model']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($car['year']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tarif Sewa per Hari (Rp)</label>
                            <input type="number" name="rental_rate_per_day" class="form-control" value="<?= htmlspecialchars($car['rental_rate_per_day']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Status Mobil</label>
                            <select name="status" class="form-control" required>
                                <option value="tersedia" <?= $car['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="dipinjam" <?= $car['status'] === 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Mobil</button>
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
