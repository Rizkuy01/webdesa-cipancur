<?php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
// Ambil nama admin dari session
$admin_nama = $_SESSION['admin']['nama'] ?? 'Admin';


// Jika form dikirim (method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jumlah'])) {
  foreach ($_POST['jumlah'] as $id => $value) {
    $id = intval($id);
    $value = intval($value);
    mysqli_query($conn, "UPDATE dashboard_stats SET jumlah = $value WHERE id = $id");
  }

  header("Location: dashboard.php?edit=success");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin | Desa Cipancur</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../aset/logo-desa.png" type="image/png" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
      min-height: 100vh;
      overflow-x: hidden;
    }
    
    .card {
      transition: all 0.3s ease;
      border-left: 4px solid;
      border-radius: 8px;
      overflow: hidden;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .header-gradient {
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }
    
    .sidebar {
      background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
      transition: all 0.3s ease;
    }
    
    .sidebar-link {
      transition: all 0.2s ease;
      border-left: 3px solid transparent;
      cursor: pointer;
    }
    
    .sidebar-link:hover {
      background: rgba(255,255,255,0.05);
      border-left: 3px solid #3b82f6;
    }
    
    .sidebar-link.active {
      background: rgba(59, 130, 246, 0.15);
      border-left: 3px solid #3b82f6;
    }
    
    .stat-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    
    .logout-btn {
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .logout-btn:hover {
      transform: scale(1.02);
      box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }
    
    .notification-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      width: 22px;
      height: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .content-section {
      display: none;
      animation: fadeIn 0.5s ease;
    }
    
    .content-section.active {
      display: block;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        position: absolute;
        z-index: 100;
        height: 100%;
      }
      .sidebar-text {
        display: none;
      }
      .main-content {
        margin-left: 0;
      }
      .mobile-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 99;
      }
      .mobile-overlay.active {
        display: block;
      }
    }
  </style>
</head>

<body class="flex">
  <!-- Mobile overlay -->
  <div class="mobile-overlay" id="mobileOverlay"></div>
  
  <!-- Sidebar Navigation -->
  <aside class="sidebar w-64 min-h-screen text-white py-6 hidden md:block" id="sidebar">
    <div class="flex flex-col items-center mb-10">
      <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2MGI0ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMCI+PC9jaXJjbGU+PHBhdGggZD0iTTEyIDhsLTQgNi41aDhsLTQtNi41eiI+PC9wYXRoPjwvc3ZnPg==" alt="logo-desa" width="50px" height="50px">
      <h2 class="font-bold text-xl mt-3">Desa Cipancur</h2>
      <p class="text-sm text-gray-300">Admin Dashboard</p>
    </div>
    
    <nav class="mt-8">
      <ul class="space-y-2 px-4">
        <li>
          <a data-target="dashboard" class="sidebar-link active flex items-center p-3 rounded-lg">
            <i class="fas fa-tachometer-alt text-blue-400 mr-3 text-lg"></i>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>
        
        <li>
          <a data-target="profile" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-map-marked-alt text-indigo-400 mr-3 text-lg"></i>
            <span class="sidebar-text">Profil Desa</span>
          </a>
        </li>
        <li>
          <a data-target="bpjs" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-notes-medical text-green-400 mr-3 text-lg"></i>
            <span class="sidebar-text">Cek BPJS</span>
          </a>
        </li>
        <li>
          <a data-target="persuratan" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-envelope-open-text text-blue-400 mr-3 text-lg"></i>
            <span class="sidebar-text">Persuratan</span>
          </a>
        </li>
        <li>
          <a data-target="admin" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-users-cog text-purple-400 mr-3 text-lg"></i>
            <span class="sidebar-text">Kelola Admin</span>
          </a>
        </li>
      </ul>
    </nav>
    
    <div class="mt-auto px-4">
          <a href="logout.php" class="logout-btn flex items-center justify-center p-3 rounded-lg text-white font-medium">
          <i class="fas fa-sign-out-alt mr-2"></i>
          <span class="sidebar-text">Keluar</span>
        </a>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col main-content">
    <!-- Header -->
    <header class="header-gradient text-white">
      <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center">
          <button id="sidebarToggle" class="md:hidden text-white mr-4">
            <i class="fas fa-bars text-xl"></i>
          </button>
          <div class="flex items-center space-x-3">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMCI+PC9jaXJjbGU+PHBhdGggZD0iTTEyIDhsLTQgNi41aDhsLTQtNi41eiI+PC9wYXRoPjwvc3ZnPg==" alt="logo-desa" width="50px" height="50px">
            <div>
              <h1 class="text-xl font-bold">Desa Cipancur</h1>
              <p class="text-sm text-blue-100">Dashboard Admin</p>
            </div>
          </div>
        </div>
        
        <div class="flex items-center space-x-6">
          <div class="relative">
            <button class="text-blue-100 hover:text-white">
              <i class="fas fa-bell text-xl"></i>
              <span class="notification-badge bg-red-500 text-white rounded-full text-xs font-bold">3</span>
            </button>
          </div>
          
          <div class="bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center">
              <span class="font-semibold">
                <?= $admin_nama ? strtoupper(substr($admin_nama, 0, 1)) : 'A' ?>
              </span>
            </div>
            <div>
              <p class="text-sm font-medium">
                <?= $admin_nama ? htmlspecialchars($admin_nama) : 'Admin' ?>
              </p>
              <p class="text-xs text-blue-100">Administrator</p>
            </div>
        </div>
      </div>
    </header>

    <!-- Potongan penting: bagian <main> yang sudah diperbaiki -->
<main class="flex-1 p-6">

<!-- Dashboard Section -->
<div class="content-section active" id="dashboard">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Dashboard Admin</h2>
    <button id="editToggleBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded transition">
      <i class="fas fa-edit mr-1"></i> Edit Dashboard
    </button>
  </div>

  <!-- Form Edit (Hidden by Default) -->
  <form method="post" id="editForm" class="hidden mb-6 bg-white rounded-lg shadow p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <?php
      $query = mysqli_query($conn, "SELECT * FROM dashboard_stats");
      while ($row = mysqli_fetch_assoc($query)) :
      ?>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars($row['label']) ?></label>
        <input type="number" name="jumlah[<?= $row['id'] ?>]" value="<?= $row['jumlah'] ?>" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-200" required>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-right mt-4">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Simpan</button>
    </div>
  </form>

  <!-- Kotak Statistik -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM dashboard_stats");
    while ($row = mysqli_fetch_assoc($query)) :
    ?>
    <div class="stat-card p-4 flex items-center">
      <div class="<?= $row['warna_bg'] ?> p-3 rounded-lg mr-4">
        <i class="<?= $row['icon_class'] . ' ' . $row['warna_text'] ?> text-xl"></i>
      </div>
      <div>
        <p class="text-gray-500 text-sm"><?= htmlspecialchars($row['label']) ?></p>
        <p class="text-xl font-bold"><?= number_format($row['jumlah']) ?></p>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
<!-- Profil Section -->
<div class="content-section" id="profile">
  <div class="card p-6 bg-white border-indigo-500">
    <div class="flex items-start mb-4">
      <div class="bg-indigo-100 p-3 rounded-lg mr-4">
        <i class="fas fa-map-marked-alt text-indigo-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold mb-1">Edit Profil Desa</h3>
        <p class="text-sm text-gray-600">Kelola informasi lokasi, demografi, potensi, dan prestasi desa.</p>
      </div>
    </div>
    <div class="flex space-x-3 mt-5">
      <a href="tambah_profil.php" class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-2 px-4 rounded-lg text-sm font-medium transition">
        <i class="fas fa-plus mr-1"></i> Tambah
      </a>
      <a href="lihat_profil.php" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
        <i class="fas fa-eye mr-1"></i> Lihat
      </a>
    </div>
  </div>
</div>

<!-- BPJS Section -->
<div class="content-section" id="bpjs">
  <div class="card p-6 bg-white border-green-500">
    <div class="flex items-start mb-4">
      <div class="bg-green-100 p-3 rounded-lg mr-4">
        <i class="fas fa-notes-medical text-green-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold mb-1">Cek BPJS</h3>
        <p class="text-sm text-gray-600">Periksa status aktif/tidak BPJS berdasarkan NIK warga.</p>
      </div>
    </div>
    <a href="https://wa.me/628118165165" target="_blank" class="mt-5 inline-block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition">
      <i class="fab fa-whatsapp mr-2"></i> Cek via WhatsApp
    </a>
  </div>
</div>

<!-- Persuratan Section -->
<div class="content-section" id="persuratan">
  <div class="card p-6 bg-white border-blue-500">
    <div class="flex items-start mb-4">
      <div class="bg-blue-100 p-3 rounded-lg mr-4">
        <i class="fas fa-envelope-open-text text-blue-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold mb-1">Persuratan Otomatis</h3>
        <p class="text-sm text-gray-600">Tambah surat atau lihat arsip surat digital desa.</p>
      </div>
    </div>
    <div class="flex space-x-3 mt-5">
      <a href="tambah_surat.php" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-700 py-2 px-4 rounded-lg text-sm font-medium transition">
        <i class="fas fa-plus mr-1"></i> Tambah
      </a>
      <a href="lihat_surat.php" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
        <i class="fas fa-folder-open mr-1"></i> Arsip
      </a>
    </div>
  </div>
</div>

<!-- Kelola Admin Section -->
<div class="content-section" id="admin">
  <div class="card p-6 bg-white border-purple-500">
    <div class="flex items-start mb-4">
      <div class="bg-purple-100 p-3 rounded-lg mr-4">
        <i class="fas fa-users-cog text-purple-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold mb-1">Kelola Admin</h3>
        <p class="text-sm text-gray-600">Kelola dan hapus akun admin yang terdaftar.</p>
      </div>
    </div>
    <a href="kelola_admin.php" class="mt-5 inline-block w-full text-center bg-purple-600 hover:bg-purple-700 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition">
      <i class="fas fa-cog mr-2"></i> Kelola Admin
    </a>
  </div>
</div>
    </main>

    <footer class="bg-white py-4 px-6 border-t">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-600 text-sm">&copy; 2025 Desa Cipancur | Admin Panel</p>
        <div class="flex space-x-4 mt-2 md:mt-0">
          <a href="#" class="text-gray-500 hover:text-blue-600">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="#" class="text-gray-500 hover:text-blue-400">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-gray-500 hover:text-red-600">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>
    </footer>
  </div>

  <script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      
      sidebar.classList.toggle('hidden');
      overlay.classList.toggle('active');
    });
    
    // Close sidebar when clicking outside
    document.getElementById('mobileOverlay').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      
      sidebar.classList.add('hidden');
      overlay.classList.remove('active');
    });
    
    // Navigate to menu
    document.querySelectorAll('.sidebar-link').forEach(link => {
      link.addEventListener('click', function() {
        // Remove active class from all links
        document.querySelectorAll('.sidebar-link').forEach(item => {
          item.classList.remove('active');
        });
        
        // Add active class to clicked link
        this.classList.add('active');
        
        // Hide all content sections
        document.querySelectorAll('.content-section').forEach(section => {
          section.classList.remove('active');
        });
        
        // Show the target section
        const target = this.getAttribute('data-target');
        document.getElementById(target).classList.add('active');
        
        // For mobile: close sidebar after selection
        if (window.innerWidth < 768) {
          document.getElementById('sidebar').classList.add('hidden');
          document.getElementById('mobileOverlay').classList.remove('active');
        }
      });
    });
    
    // Initialize logo display (in case of broken images)
    document.addEventListener('DOMContentLoaded', function() {
      const logoPlaceholders = document.querySelectorAll('img[alt="logo-desa"]');
      logoPlaceholders.forEach(logo => {
        logo.onerror = function() {
          this.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2MGI0ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMCI+PC9jaXJjbGU+PHBhdGggZD0iTTEyIDhsLTQgNi41aDhsLTQtNi41eiI+PC9wYXRoPjwvc3ZnPg==';
        }
      });
    });
  </script>
  <script>
  const editToggleBtn = document.getElementById('editToggleBtn');
  const editForm = document.getElementById('editForm');

  editToggleBtn.addEventListener('click', () => {
    editForm.classList.toggle('hidden');
    editToggleBtn.textContent = editForm.classList.contains('hidden') ? 'Edit Dashboard' : 'Batal Edit';
  });
</script>
</body>
</html>