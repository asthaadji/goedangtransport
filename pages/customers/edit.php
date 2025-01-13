<?php
// pages/customers/edit.php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$id = $_GET['id'];

// Fetch customer data
$stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ?');
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    header('Location: list.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validasi input
    if ($name && $email) {
        $stmt = $pdo->prepare('UPDATE customers SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?');
        try {
            $stmt->execute([$name, $email, $phone, $address, $id]);
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
        <h1>Edit Pelanggan</h1>
    </div>
    <div class="content">
        <?php if($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($customer['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($customer['email']) ?>" required>
            </div>
            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($customer['phone']) ?>">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control"><?= htmlspecialchars($customer['address']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="list.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
