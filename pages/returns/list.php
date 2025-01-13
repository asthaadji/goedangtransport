<?php
// pages/returns/list.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
?>
<?php include '../../includes/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Daftar Pengembalian Mobil</h1>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Tabel Daftar Pengembalian -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengembalian Mobil</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="add.php" class="btn btn-success mb-3">Tambah Pengembalian</a>
                    <table id="returnsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Peminjaman</th>
                                <th>Nama Pelanggan</th>
                                <th>Plat Nomor</th>
                                <th>Tarif Sewa per Hari (Rp)</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Jumlah Hari</th>
                                <th>Total Biaya (Rp)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mengambil data peminjaman yang masih "dipinjam"
                            $stmt = $pdo->prepare('
                                SELECT rentals.*, customers.name, cars.license_plate, cars.rental_rate_per_day
                                FROM rentals
                                INNER JOIN customers ON rentals.customer_id = customers.id
                                INNER JOIN cars ON rentals.car_id = cars.id
                                WHERE rentals.status = "dipinjam"
                                ORDER BY rentals.rental_date DESC
                            ');
                            $stmt->execute();
                            $rentals = $stmt->fetchAll();

                            foreach ($rentals as $rental) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($rental['id']) . '</td>';
                                echo '<td>' . htmlspecialchars($rental['name']) . '</td>';
                                echo '<td>' . htmlspecialchars($rental['license_plate']) . '</td>';
                                echo '<td>' . number_format($rental['rental_rate_per_day'], 0, ',', '.') . '</td>';
                                echo '<td>' . htmlspecialchars($rental['rental_date']) . '</td>';
                                echo '<td>' . htmlspecialchars($rental['days']) . '</td>';
                                echo '<td>' . number_format($rental['total_cost'], 0, ',', '.') . '</td>';
                                echo '<td>' . htmlspecialchars(ucfirst($rental['status'])) . '</td>';
                                echo '<td>';

                                // Tombol "Kembalikan" hanya muncul jika status masih "dipinjam"
                                if ($rental['status'] === 'dipinjam') {
                                    echo '<a href="return.php?id=' . htmlspecialchars($rental['id']) . '" class="btn btn-primary btn-sm">Kembalikan</a> ';
                                }

                                echo '<a href="edit.php?id=' . htmlspecialchars($rental['id']) . '" class="btn btn-warning btn-sm">Edit</a> ';
                                echo '<a href="delete.php?id=' . htmlspecialchars($rental['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus peminjaman ini?\')">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
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
