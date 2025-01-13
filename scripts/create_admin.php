<?php
// scripts/create_admin.php
require_once '../config/database.php';

// Ganti dengan username dan password yang diinginkan
$username = 'admin'; // Contoh: 'admin'
$password = '123'; // Ganti dengan password yang kuat

// Hash password menggunakan password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username sudah ada
$stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
$stmt->execute([$username]);
$existingAdmin = $stmt->fetch();

if ($existingAdmin) {
    echo "Username sudah ada. Silakan gunakan username lain.";
} else {
    // Insert admin baru
    $stmt = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
    try {
        $stmt->execute([$username, $hashed_password]);
        echo "Admin baru berhasil dibuat!";
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
