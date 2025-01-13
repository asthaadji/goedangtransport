<?php
// includes/header.php

// Menggunakan __DIR__ untuk memastikan path yang benar
require_once __DIR__ . '/../config/config.php';

// Optional: Menampilkan BASE_URL untuk debugging
// echo "BASE_URL: " . BASE_URL;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GoedangTransport Admin</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>adminlte/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>adminlte/dist/css/adminlte.min.css">
    <!-- Jika Anda memiliki CSS kustom -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <!-- Tambahkan link lain jika diperlukan -->
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="<?= BASE_URL ?>pages/logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= BASE_URL ?>pages/dashboard.php" class="brand-link">
            <span class="brand-text font-weight-light">GoedangTransport</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>pages/dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <!-- Mobil -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-car"></i>
                            <p>
                                Mobil
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/cars/list.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Mobil</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/cars/add.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Mobil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Pelanggan -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Pelanggan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/customers/list.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Pelanggan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/customers/add.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Pelanggan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Peminjaman -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                Peminjaman
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/rentals/list.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Peminjaman</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/rentals/add.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Input Peminjaman</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Pelanggan -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                Pengembalian
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>pages/returns/return.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Pengembalian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Tambahkan menu lain jika diperlukan -->
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
