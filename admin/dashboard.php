<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin - Desa Maju Bersama</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-4xl mx-auto mt-10 p-8 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold mb-6">👋 Selamat Datang, <?= $_SESSION['admin']; ?>!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Profil Desa -->
      <div class="p-6 border rounded hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">📌 Edit Profil Desa</h2>
        <p>Mengelola informasi lokasi, demografi, potensi, dan prestasi desa.</p>
        <a href="edit_profil.php" class="text-blue-500 mt-2 inline-block">Edit Profil ➜</a>
      </div>

      <!-- BPJS -->
      <div class="p-6 border rounded hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">🩺 Cek BPJS</h2>
        <p>Cek status kepesertaan BPJS berdasarkan NIK.</p>
        <a href="cek_bpjs.php" class="text-blue-500 mt-2 inline-block">Cek BPJS ➜</a>
      </div>

      <!-- Surat -->
      <div class="p-6 border rounded hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">📄 Persuratan Otomatis</h2>
        <p>Input surat baru dan lihat arsip surat warga.</p>
        <a href="tambah_surat.php" class="text-blue-500">Tambah Surat ➜</a><br>
        <a href="lihat_surat.php" class="text-blue-500">Lihat Semua Surat ➜</a>
      </div>

      <!-- Logout -->
      <div class="p-6 border rounded hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">🚪 Keluar</h2>
        <p>Logout dari sistem admin.</p>
        <a href="logout.php" class="text-red-500">Logout ➜</a>
      </div>
    </div>
  </div>

</body>
</html>
