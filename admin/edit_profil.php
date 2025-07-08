<?php session_start(); include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Profil Desa</title>
</head>
<body>
  <h2>Edit Profil Desa</h2>
  <?php if (isset($_SESSION['msg'])): ?>
    <p style="color: green;"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></p>
  <?php endif; ?>
  <form action="C:\xampppp\htdocs\webdesa-cipancur\proses\simpan_profil.php" method="POST" enctype="multipart/form-data">
    <label>Kategori:</label>
    <select name="kategori" required>
      <option value="lokasi">Lokasi</option>
      <option value="demografi">Demografi</option>
      <option value="potensi">Potensi</option>
      <option value="prestasi">Prestasi</option>
    </select><br><br>

    <label>Judul:</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="5" cols="50" required></textarea><br><br>

    <label>Upload Foto:</label><br>
    <input type="file" name="foto"><br><br>

    <button type="submit">Simpan</button>
  </form>
</body>
</html>
