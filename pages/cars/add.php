<?php
// pages/cars/add.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $license_plate = $_POST['license_plate'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $rental_rate_per_day = $_POST['rental_rate_per_day'];

    // Validasi input
    if ($license_plate && $make && $model && $year && $rental_rate_per_day) {
        $stmt = $pdo->prepare('INSERT INTO cars (license_plate, make, model, year, rental_rate_per_day, status) VALUES (?, ?, ?, ?, ?, "tersedia")');
        try {
            $stmt->execute([$license_plate, $make, $model, $year, $rental_rate_per_day]);
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
            <h1 class="m-0">Tambah Mobil</h1>
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
                    <h3 class="card-title">Form Tambah Mobil</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Plat Nomor</label>
                            <input type="text" name="license_plate" class="form-control" placeholder="Masukkan Plat Nomor" required>
                        </div>
                        <div class="form-group">
                            <label>Merek</label>
                            <input type="text" name="make" class="form-control" placeholder="Masukkan Merek Mobil" required>
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" placeholder="Masukkan Model Mobil" required>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="year" class="form-control" placeholder="Masukkan Tahun Mobil" required>
                        </div>
                        <div class="form-group">
                            <label>Tarif Sewa per Hari (Rp)</label>
                            <input type="number" name="rental_rate_per_day" class="form-control" placeholder="Masukkan Tarif Sewa per Hari" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
