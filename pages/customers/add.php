<?php
// pages/customers/add.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validasi input
    if ($name && $email) {
        $stmt = $pdo->prepare('INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)');
        try {
            $stmt->execute([$name, $email, $phone, $address]);
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            $message = 'Email sudah digunakan!';
        }
    } else {
        $message = 'Nama dan Email wajib diisi!';
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <h1>Tambah Pelanggan</h1>
    </div>
    <div class="content">
        <?php if($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="list.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
