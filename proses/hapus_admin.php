<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Validasi input ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['admin_error'] = "ID admin tidak valid.";
    header("Location: ../admin/kelola_admin.php");
    exit;
}

$id_to_delete = $_GET['id'];
$current_admin_id = $_SESSION['admin_id'];

// Mencegah admin menghapus akunnya sendiri
if ($id_to_delete == $current_admin_id) {
    $_SESSION['admin_error'] = "Anda tidak dapat menghapus akun Anda sendiri.";
    header("Location: ../admin/kelola_admin.php");
    exit;
}

// Gunakan prepared statement untuk menghapus
$stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
$stmt->bind_param("i", $id_to_delete);

if ($stmt->execute()) {
    $_SESSION['admin_msg'] = "Akun admin berhasil dihapus.";
} else {
    $_SESSION['admin_error'] = "Gagal menghapus akun admin.";
}

$stmt->close();
$conn->close();

header("Location: ../admin/kelola_admin.php");
exit;