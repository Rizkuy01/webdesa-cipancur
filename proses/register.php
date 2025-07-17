<?php
session_start();
include '../config/db.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validasi dasar
if (empty($username) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header("Location: ../admin/register.php");
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
    header("Location: ../admin/register.php");
    exit;
}

// Cek apakah username sudah ada (gunakan prepared statement)
$stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Username sudah digunakan. Silakan pilih username lain.";
    $stmt->close();
    header("Location: ../admin/register.php");
    exit;
}
$stmt->close();

// Hash password dengan standar keamanan modern
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan admin baru ke database (gunakan prepared statement)
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
    header("Location: ../admin/login.php");
} else {
    $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
    header("Location: ../admin/register.php");
}

$stmt->close();
$conn->close();