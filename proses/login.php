<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($username === '' || $password === '') {
    $_SESSION['error'] = "Username dan password tidak boleh kosong.";
    header("Location: ../admin/login.php");
    exit;
  }

  // Ambil data admin
  $stmt = $conn->prepare("SELECT id, nama, username, password FROM admin WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $admin = $result->fetch_assoc();
  $stmt->close();

  // Verifikasi password
  if ($admin && password_verify($password, $admin['password'])) {
    // Simpan ke session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin'] = [
      'id' => $admin['id'],
      'nama' => $admin['nama'],
      'username' => $admin['username']
    ];

    header("Location: ../admin/dashboard.php");
    exit;
  } else {
    $_SESSION['error'] = "Login gagal. Username atau password salah.";
    header("Location: ../admin/login.php");
    exit;
  }
} else {
  header("Location: ../admin/login.php");
  exit;
}
