<?php
// pages/dashboard.php
require_once '../includes/auth.php';
require_once '../config/database.php';
?>

<?php include '../includes/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Statistik atau informasi lainnya dapat ditambahkan di sini -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            $stmt = $pdo->query('SELECT COUNT(*) as count FROM cars');
                            $carCount = $stmt->fetch()['count'];
                            ?>
                            <h3><?= $carCount ?></h3>
                            <p>Mobil Tersedia</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <a href="cars/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Tambahkan box lain seperti jumlah pelanggan, peminjaman, dll. -->
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
