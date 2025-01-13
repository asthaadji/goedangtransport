<?php
// pages/customers/list.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

// Fetch all customers
$stmt = $pdo->query('SELECT * FROM customers');
$customers = $stmt->fetchAll();
?>

<?php include '../../includes/header.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <h1>Daftar Pelanggan</h1>
    </div>
    <div class="content">
        <a href="add.php" class="btn btn-success mb-3">Tambah Pelanggan</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($customers as $customer): ?>
                    <tr>
                        <td><?= $customer['id'] ?></td>
                        <td><?= htmlspecialchars($customer['name']) ?></td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td><?= htmlspecialchars($customer['phone']) ?></td>
                        <td><?= htmlspecialchars($customer['address']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $customer['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Anda dapat menambahkan tombol hapus jika diperlukan -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
