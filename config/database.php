<?php
// config/database.php

require_once 'config.php'; // Mengikutsertakan config.php untuk menggunakan BASE_URL jika diperlukan

$host = 'localhost';
$db   = 'goedangtransport'; // Pastikan nama database sesuai
$user = 'root';             // Username database
$pass = '';                 // Password database (biasanya kosong di XAMPP)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Mengaktifkan exception untuk error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mengatur mode fetch
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Mengaktifkan prepared statements
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
