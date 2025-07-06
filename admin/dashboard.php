<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM profil_desa");
?>
<h2>Dashboard Admin</h2>
<table border="1">
  <tr><th>Kategori</th><th>Judul</th><th>Aksi</th></tr>
  <?php while ($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
      <td><?= $row['kategori'] ?></td>
      <td><?= $row['judul'] ?></td>
      <td><a href="edit-profil.php?id=<?= $row['id'] ?>">Edit</a></td>
    </tr>
  <?php endwhile; ?>
</table>
<a href="logout.php">Logout</a>
