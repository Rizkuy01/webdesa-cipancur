<?php
include '../config/db.php';

// Proses update saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  foreach ($_POST['jumlah'] as $id => $nilai) {
    $id = intval($id);
    $nilai = intval($nilai);
    mysqli_query($conn, "UPDATE dashboard_stats SET jumlah = $nilai WHERE id = $id");
  }
  header("Location: edit_dashboard.php?status=ok");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Dashboard | Admin Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">Edit Data Dashboard</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'ok'): ?>
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Data berhasil diperbarui!</div>
    <?php endif; ?>

    <form method="post">
      <div class="space-y-6">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM dashboard_stats");
        while ($row = mysqli_fetch_assoc($query)) :
        ?>
        <div class="flex justify-between items-center">
          <label class="text-gray-700 font-medium"><?= htmlspecialchars($row['label']) ?></label>
          <input type="number" name="jumlah[<?= $row['id'] ?>]" value="<?= $row['jumlah'] ?>" class="w-32 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <?php endwhile; ?>
      </div>

      <div class="mt-8 text-right">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium transition">
          Simpan Perubahan
        </button>
      </div>
    </form>

    <div class="mt-6">
      <a href="dashboard.php" class="text-blue-500 hover:underline text-sm">&larr; Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
