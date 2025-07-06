CREATE DATABASE IF NOT EXISTS desacipancur;
USE desacipancur;

CREATE TABLE profil_desa (
  id INT PRIMARY KEY AUTO_INCREMENT,
  kategori VARCHAR(50),
  judul VARCHAR(100),
  konten TEXT,
  icon VARCHAR(50)
);

INSERT INTO profil_desa (kategori, judul, konten, icon) VALUES
('lokasi', 'Lokasi & Geografis', 'Desa Maju Bersama terletak di Kecamatan Sukamaju...', 'fa-map-marker-alt'),
('demografi', 'Demografi', 'Jumlah penduduk: 5.234 jiwa\nJumlah KK: 1.456 KK\n...', 'fa-chart-bar'),
('potensi', 'Potensi Desa', 'Pertanian padi organik, perkebunan kopi...', 'fa-seedling'),
('prestasi', 'Prestasi', 'Juara 1 Desa Terbaik Tingkat Kabupaten 2023...', 'fa-trophy');

CREATE TABLE admin (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50),
  password VARCHAR(255)
);

INSERT INTO admin (username, password) VALUES
('admin', MD5('admin123'));
