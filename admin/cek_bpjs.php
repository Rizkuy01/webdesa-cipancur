<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Cek BPJS - Desa Maju Bersama</title>
</head>
<body>
  <h2>Cek Status BPJS Warga</h2>
  <form method="POST" action="C:\xampppp\htdocs\webdesa-cipancur\proses\cek_bpjs.php">
    <label>Masukkan NIK:</label><br>
    <input type="text" name="nik" maxlength="16" required>
    <button type="submit">Cek</button>
  </form>

  <?php if (isset($_SESSION['hasil_bpjs'])): ?>
    <h3>Hasil Pengecekan:</h3>
    <p><strong>Nama:</strong> <?= $_SESSION['hasil_bpjs']['nama'] ?></p>
    <p><strong>Jenis BPJS:</strong> <?= $_SESSION['hasil_bpjs']['jenis_bpjs'] ?></p>
    <p><strong>Status:</strong> <?= $_SESSION['hasil_bpjs']['status_bpjs'] ?></p>
    <?php unset($_SESSION['hasil_bpjs']); ?>
  <?php elseif (isset($_SESSION['not_found'])): ?>
    <p style="color:red"><?= $_SESSION['not_found']; unset($_SESSION['not_found']); ?></p>
  <?php endif; ?>
</body>
</html>
