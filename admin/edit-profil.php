<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM profil_desa WHERE id=$id"));
?>
<form action="proses-edit.php" method="POST">
  <input type="hidden" name="id" value="<?= $data['id'] ?>">
  <label>Judul</label><br>
  <input name="judul" value="<?= $data['judul'] ?>"><br>
  <label>Konten</label><br>
  <textarea name="konten" rows="6"><?= $data['konten'] ?></textarea><br>
  <label>Icon FontAwesome (contoh: fa-map-marker-alt)</label><br>
  <input name="icon" value="<?= $data['icon'] ?>"><br>
  <button type="submit">Simpan Perubahan</button>
</form>
