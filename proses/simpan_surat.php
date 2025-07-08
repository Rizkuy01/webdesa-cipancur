<?php
include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php';

$nama = $_POST['nama'];
$nik = $_POST['nik'];
$jenis = $_POST['jenis_surat'];
$keperluan = $_POST['keperluan'];

$conn->query("INSERT INTO surat (nama, nik, jenis_surat, keperluan)
              VALUES ('$nama', '$nik', '$jenis', '$keperluan')");

$id = $conn->insert_id;
header("Location: ../admin/surat_generated.php?id=$id");
