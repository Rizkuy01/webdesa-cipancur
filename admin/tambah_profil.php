<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Profil Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../aset/logo-desa.png" type="image/png" />
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen font-sans">

  <div class="max-w-3xl mx-auto mt-12 bg-white p-8 rounded-xl shadow-xl">

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-bold text-indigo-800">➕ Tambah Profil Desa</h2>
      <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition duration-200">
        ← Kembali ke Dashboard
      </a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['msg']); unset($_SESSION['msg']); ?>
      </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <form action="../proses/simpan_profil.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <!-- Kategori -->
      <div>
        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-1">🗂️ Pilih Kategori</label>
        <select id="kategori" name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
          <option value="" disabled selected>-- Pilih Kategori Profil --</option>
          <option value="lokasi">📍 Lokasi & Geografis</option>
          <option value="demografi">👥 Demografi</option>
          <option value="potensi">🌾 Potensi Desa</option>
          <option value="prestasi">🏆 Prestasi</option>
        </select>
      </div>

      <!-- Judul -->
      <div>
        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-1">📝 Judul</label>
        <input type="text" id="judul" name="judul" required placeholder="Contoh: Pertanian Padi Organik" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
      </div>

      <!-- Deskripsi -->
      <div>
        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">📄 Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required placeholder="Tulis penjelasan singkat tentang judul di atas..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
      </div>

      <!-- Upload Foto -->
      <div>
        <label for="foto" class="block text-sm font-semibold text-gray-700 mb-1">📷 Upload Foto (1 Foto per Judul)</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png, image/gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:bg-indigo-50 file:text-indigo-600 file:font-semibold file:border-0 file:py-2 file:px-4 hover:file:bg-indigo-100">
        <p class="mt-1 text-xs text-gray-500">Hanya JPG, PNG, atau GIF. Maks: 2MB.</p>
      </div>

      <!-- Tombol Simpan -->
      <div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
          💾 Simpan Data
        </button>
      </div>
    </form>

    <!-- Tombol Kembali ke Daftar Profil -->
    <div class="mt-6 text-center">
      <a href="lihat_profil.php" class="text-indigo-600 text-sm hover:underline">
        ← Lihat Daftar Profil Desa
      </a>
    </div>

  </div>
</body>
</html>
