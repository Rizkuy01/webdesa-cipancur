<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php';
$surat = $conn->query("SELECT * FROM surat ORDER BY tanggal_dibuat DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Surat - Desa Maju Bersama</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-800 p-10">

  <div class="max-w-5xl mx-auto bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">📋 Arsip Surat Warga</h2>
    <table class="w-full table-auto border">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">No</th>
          <th class="p-2">Nama</th>
          <th class="p-2">NIK</th>
          <th class="p-2">Jenis Surat</th>
          <th class="p-2">Tanggal</th>
          <th class="p-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $surat->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="p-2"><?= $no++; ?></td>
          <td class="p-2"><?= $row['nama']; ?></td>
          <td class="p-2"><?= $row['nik']; ?></td>
          <td class="p-2"><?= $row['jenis_surat']; ?></td>
          <td class="p-2"><?= $row['tanggal_dibuat']; ?></td>
          <td class="p-2">
            <a href="surat_generated.php?id=<?= $row['id']; ?>" class="text-blue-500">Cetak</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
