<?php
include '../config/db.php';

$nama = $_POST['nama'];
$nik = $_POST['nik'];
$jenis = $_POST['jenis_surat'];
$keperluan = $_POST['keperluan'];

// Gunakan prepared statement untuk keamanan dan mencegah error syntax
$stmt = $conn->prepare("INSERT INTO surat (nama, nik, jenis_surat, keperluan) VALUES (?, ?, ?, ?)");

// 'ssss' berarti semua empat parameter adalah string
$stmt->bind_param("ssss", $nama, $nik, $jenis, $keperluan);

// Eksekusi query
$stmt->execute();

// Ambil ID yang baru saja dimasukkan
$id = $stmt->insert_id;

$stmt->close();
$conn->close();

// Alihkan ke halaman cetak surat
header("Location: ../admin/surat_generated.php?id=$id");
exit();
