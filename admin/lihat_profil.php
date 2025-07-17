<?php
session_start();
if (isset($_SESSION['admin_id'])) {
  header("Location: dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Desa Cipancur</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../aset/logo-desa.png" type="image/png" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #f0f4f8, #dbeafe);
    }
  </style>
</head>
<body>

<div class="min-h-screen flex items-center justify-center px-4">
  <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
    <div class="text-center mb-6">
      <img src="../aset/logo-desa.png" alt="Logo Desa" class="mx-auto mb-3 w-16 h-16 rounded-full shadow">
      <h2 class="text-2xl font-bold text-gray-800">Login Admin</h2>
      <p class="text-sm text-gray-500">Selamat datang kembali di dashboard</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="../proses/login.php" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input 
          type="text" 
          name="username" 
          required
          placeholder="Masukkan username"
          class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input 
          type="password" 
          name="password" 
          required
          placeholder="••••••••"
          class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"
        />
      </div>

      <button type="submit" class="w-full py-2.5 text-white font-medium bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
        Masuk
      </button>
    </form>

    <p class="mt-5 text-center text-sm text-gray-600">
      Belum punya akun? 
      <a href="register.php" class="text-indigo-600 font-medium hover:underline">Daftar di sini</a>
    </p>
  </div>
</div>

</body>
</html>
