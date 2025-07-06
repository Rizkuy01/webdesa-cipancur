<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = $_POST['username'];
  $pass = md5($_POST['password']);
  $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
  if (mysqli_num_rows($cek) > 0) {
    $_SESSION['login'] = true;
    header("Location: dashboard.php");
  } else {
    echo "<script>alert('Login gagal!');</script>";
  }
}
?>
<form method="POST">
  <input name="username" placeholder="Username"><br>
  <input type="password" name="password" placeholder="Password"><br>
  <button type="submit">Login</button>
</form>
