<?php
// includes/auth.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /pages/login.php');
    exit;
}
?>
