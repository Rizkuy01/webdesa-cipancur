<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Surat Otomatis - Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Pembuatan Surat Otomatis</h2>

    <form method="POST" action="../proses/simpan_surat.php" class="space-y-4">
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Pemohon</label>
        <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
      </div>

      <div>
        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
        <input type="text" id="nik" name="nik" maxlength="16" required placeholder="Masukkan 16 digit NIK" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
      </div>

      <div>
        <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
        <select id="jenis_surat" name="jenis_surat" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
          <option value="Surat Pengantar">Surat Pengantar (Umum)</option>
          <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
          <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
          <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
          <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
        </select>
      </div>

      <div>
        <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
        <textarea id="keperluan" name="keperluan" rows="4" required placeholder="Jelaskan keperluan pembuatan surat..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"></textarea>
      </div>

      <div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
          Buat & Cetak Surat
        </button>
      </div>
    </form>

    <div class="mt-6 text-center">
        <a href="dashboard.php" class="text-sm text-indigo-600 hover:text-indigo-500">
            &larr; Kembali ke Dashboard
        </a>
    </div>
  </div>
</body>
</html>
