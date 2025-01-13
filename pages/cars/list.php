<?php
// pages/cars/list.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

// Fetch all cars
$stmt = $pdo->query('SELECT * FROM cars');
$cars = $stmt->fetchAll();
?>

<?php include '../../includes/header.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <h1>Daftar Mobil</h1>
    </div>
    <div class="content">
        <a href="add.php" class="btn btn-success mb-3">Tambah Mobil</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Plat Nomor</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cars as $car): ?>
                    <tr>
                        <td><?= $car['id'] ?></td>
                        <td><?= htmlspecialchars($car['license_plate']) ?></td>
                        <td><?= htmlspecialchars($car['make']) ?></td>
                        <td><?= htmlspecialchars($car['model']) ?></td>
                        <td><?= htmlspecialchars($car['year']) ?></td>
                        <td>
                            <?php if($car['status'] == 'tersedia'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Dipinjam</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $car['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Anda dapat menambahkan tombol hapus jika diperlukan -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
