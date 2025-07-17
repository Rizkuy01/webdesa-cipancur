<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../config/db.php';

$current_admin_id = $_SESSION['admin_id'];
$admins = $conn->query("SELECT id, username, nama, created_at FROM admin");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Admin - Desa Cipancur</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../aset/logo-desa.png" type="image/png" />
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen font-sans">

  <div class="max-w-5xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold text-indigo-800">Kelola Akun Admin</h1>
        <p class="text-sm text-gray-500">Daftar dan kelola akun admin yang terdaftar di sistem</p>
      </div>
      <a href="dashboard.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
        ← Kembali ke Dashboard
      </a>
    </div>

    <?php if (isset($_SESSION['admin_msg'])): ?>
      <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['admin_msg']); unset($_SESSION['admin_msg']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['admin_error'])): ?>
      <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?>
      </div>
    <?php endif; ?>

    <div class="overflow-x-auto rounded-lg shadow-sm">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-indigo-100 text-indigo-800">
          <tr>
            <th class="px-4 py-3 text-left font-medium">ID</th>
            <th class="px-4 py-3 text-left font-medium">Username</th>
            <th class="px-4 py-3 text-left font-medium">Nama</th>
            <th class="px-4 py-3 text-left font-medium">Tanggal Dibuat</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          <?php while ($row = $admins->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?= $row['id']; ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['username']); ?></td>
              <td class="px-4 py-2">
                <?php if ($row['id'] == $current_admin_id): ?>
                  <form action="../proses/edit_nama_admin.php" method="POST" class="flex space-x-2">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" class="border px-2 py-1 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium">Simpan</button>
                  </form>
                <?php else: ?>
                  <?= htmlspecialchars($row['nama']); ?>
                <?php endif; ?>
              </td>
              <td class="px-4 py-2 text-gray-500"><?= date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
              <td class="px-4 py-2">
                <?php if ($row['id'] != $current_admin_id): ?>
                  <a href="../proses/hapus_admin.php?id=<?= $row['id']; ?>" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</a>
                <?php else: ?>
                  <span class="text-gray-400 italic">Ini Anda</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
