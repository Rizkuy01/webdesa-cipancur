<?php
include 'config/db.php';

// Fetch all profiles, ordered by the newest first
$profiles_result = $conn->query("SELECT id, kategori, judul, deskripsi, foto FROM profil_desa ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Desa Cipancur | Website</title>
  <link rel="stylesheet" href="./css/style.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="aset/logo-desa.png" rel="icon" type="image/png" />
</head>

<body>
  <div class="page-container">
    <header>
      <div class="header-content">
        <div class="logo">
          <img src="aset/logo-desa.png" alt="logo-desa" width="50px" height="50px">
          <div>
            <h1>Desa Cipancur</h1>
            <small>Portal Resmi Pemerintah Desa</small>
          </div>
        </div>
        <nav>
          <ul>
            <li><a href="#home">Beranda</a></li>
            <li><a href="#profile">Profil</a></li>
            <li><a href="#services">Layanan</a></li>
            <li><a href="#ai-assistant">AI Assistant</a></li>
            <li><a href="#pengajuan-surat">Pengajuan Surat</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li><a href="admin/login.php" target="_blank">Admin</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="home" class="hero">
      <div class="hero-content">
        <h2>Selamat Datang di Informasi Desa Cipancur</h2>
        <p>Desa Modern dengan Pelayanan Digital Terdepan</p>
        <a href="#ai-assistant" class="btn">Tanya AI Assistant</a>
      </div>
    </section>

    <div class="content">
      <section id="profile" class="section">
        <h3><i class="fas fa-users"></i> Profil Desa</h3>
        <div class="profile-grid">
          <?php if ($profiles_result && $profiles_result->num_rows > 0): ?>
            <?php while ($profil = $profiles_result->fetch_assoc()): ?>
              <div class="profile-card">
                <div class="image-container">
                  <?php if (!empty($profil['foto'])): ?>
                    <img src="aset/<?= htmlspecialchars($profil['foto']); ?>" alt="<?= htmlspecialchars($profil['judul']); ?>" class="profile-image">
                  <?php else: ?>
                    <div class="profile-image-placeholder">
                      <i class="fas fa-image fa-3x text-gray-400"></i>
                    </div>
                  <?php endif; ?>
                </div>
                <h4><?= htmlspecialchars($profil['judul']); ?></h4>
                <p><?= nl2br(htmlspecialchars($profil['deskripsi'])); ?></p>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="col-span-full text-center text-gray-500">Belum ada data profil yang ditambahkan.</p>
          <?php endif; ?>
        </div>
      </section>

      <section id="services" class="section">
        <h3><i class="fas fa-cogs"></i> Layanan Desa</h3>
        <div class="services-grid">
          <div class="service-item">
            <h4><i class="fas fa-id-card"></i> Surat Keterangan</h4>
            <p>
              Pengurusan surat keterangan domisili, kelahiran, kematian, dan
              berbagai surat administrasi lainnya
            </p>
          </div>
          <div class="service-item">
            <h4><i class="fas fa-file-alt"></i> Dokumen Kependudukan</h4>
            <p>
              Bantuan pengurusan KTP, KK, akta kelahiran, dan dokumen
              kependudukan lainnya
            </p>
          </div>
          <div class="service-item">
            <h4><i class="fas fa-home"></i> Izin Usaha</h4>
            <p>
              Pengurusan SIUP, TDP, izin tempat usaha, dan perizinan usaha
              mikro kecil menengah
            </p>
          </div>
          <div class="service-item">
            <h4><i class="fas fa-heart"></i> Bantuan Sosial</h4>
            <p>
              Informasi dan pendaftaran program bantuan sosial pemerintah
              untuk masyarakat
            </p>
          </div>
          <div class="service-item">
            <h4><i class="fas fa-graduation-cap"></i> Beasiswa</h4>
            <p>
              Informasi beasiswa pendidikan untuk pelajar dan mahasiswa
              berprestasi
            </p>
          </div>
          <div class="service-item">
            <h4><i class="fas fa-medkit"></i> Pelayanan Kesehatan</h4>
            <p>
              Informasi posyandu, imunisasi, dan program kesehatan masyarakat
            </p>
          </div>
        </div>
      </section>

      <section id="ai-assistant" class="section">
        <h3><i class="fas fa-robot"></i> AI Assistant - Tanya Persuratan</h3>
        <div class="ai-chat">
          <div class="chat-container">
            <div class="chat-messages" id="chatMessages">
              <div class="message ai-message">
                <strong>🤖 AI Assistant:</strong> Halo! Saya siap membantu
                Anda dengan informasi persuratan dan birokrasi desa. Silakan
                tanyakan apa yang ingin Anda ketahui tentang prosedur
                pembuatan surat-surat atau dokumen lainnya.
              </div>
            </div>
            <div class="loading" id="loading">
              <div class="spinner"></div>
              <p>AI sedang memproses...</p>
            </div>
            <div class="chat-input">
              <input type="text" id="userInput" placeholder="Tanyakan tentang persuratan desa..."
                onkeypress="if(event.key==='Enter') sendMessage()" />
              <button onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i> Kirim
              </button>
            </div>
          </div>
        </div>
      </section>

      <section id="pengajuan-surat" class="section">
        <h3><i class="fas fa-envelope-open-text"></i> Pengajuan Surat</h3>
        <div class="profile-grid">

          <!-- Surat Domisili -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfDomisiliURL/viewform" target="_blank"
            class="profile-card hover:bg-blue-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-home text-blue-600"></i>
            <h4>Surat Domisili</h4>
            <p>Ajukan surat keterangan domisili secara online dengan cepat dan mudah.</p>
          </a>

          <!-- Surat Kelahiran -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfKelahiranURL/viewform" target="_blank"
            class="profile-card hover:bg-green-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-baby text-green-600"></i>
            <h4>Surat Kelahiran</h4>
            <p>Formulir pengajuan surat keterangan kelahiran anak Anda.</p>
          </a>

          <!-- Surat Kematian -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfKematianURL/viewform" target="_blank"
            class="profile-card hover:bg-red-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-cross text-red-500"></i>
            <h4>Surat Kematian</h4>
            <p>Ajukan surat keterangan kematian secara resmi dan cepat.</p>
          </a>

          <!-- Surat Usaha -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfUsahaURL/viewform" target="_blank"
            class="profile-card hover:bg-yellow-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-briefcase text-yellow-500"></i>
            <h4>Surat Usaha</h4>
            <p>Formulir pendaftaran izin usaha mikro atau UMKM Anda.</p>
          </a>

          <!-- Pengantar KTP -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfKTPURL/viewform" target="_blank"
            class="profile-card hover:bg-indigo-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-id-card text-indigo-500"></i>
            <h4>Pengantar KTP</h4>
            <p>Ajukan surat pengantar untuk pembuatan atau perpanjangan KTP.</p>
          </a>

          <!-- Surat Nikah -->
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSfSuratNikahURL/viewform" target="_blank"
            class="profile-card hover:bg-pink-50 transition duration-300 cursor-pointer text-center">
            <i class="fas fa-heart text-pink-500 text-3xl mb-2"></i>
            <h4>Surat Nikah</h4>
            <p>Ajukan permohonan surat nikah secara online dengan mudah dan cepat.</p>
          </a>
        </div>
      </section>

    </div>

    <footer id="contact">
      <p>&copy; Desa Cipancur 2025.</p>
      <p>Kec. Cibatu, Kab. Purwakarta</p>
      <p>Telp: (021) 1234-5678 | Email: info@majubersama.desa.id</p>
    </footer>
  </div>

  <!-- WhatsApp Float Button -->
  <div class="whatsapp-float" onclick="openWhatsApp()">
    <i class="fab fa-whatsapp"></i>
  </div>
  <script src="./js/script.js"></script>
</body>

</html>