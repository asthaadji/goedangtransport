<?php
// index.php

// Mulai sesi untuk mengelola otentikasi
session_start();

// Periksa apakah admin sudah login
if (isset($_SESSION['admin_id'])) {
    // Jika sudah login, arahkan ke dashboard
    header('Location: pages/dashboard.php');
    exit;
} else {
    // Jika belum login, arahkan ke halaman login
    header('Location: pages/login.php');
    exit;
}
?>
