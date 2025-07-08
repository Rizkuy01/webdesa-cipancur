<?php
session_start();
include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->query("SELECT * FROM admin WHERE username = '$username'");
$data = $query->fetch_assoc();

if ($data && password_verify($password, $data['password'])) {
  $_SESSION['admin'] = $data['username'];
  header("Location: ../admin/dashboard.php");
} else {
  $_SESSION['error'] = "Login gagal. Cek kembali username/password.";
  header("Location: ../admin/login.php");
}
?>
