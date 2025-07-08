<?php
include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$jenis = $_POST['jenis_bpjs'];
$status = $_POST['status_bpjs'];

$conn->query("REPLACE INTO bpjs (nik, nama, jenis_bpjs, status_bpjs)
              VALUES ('$nik', '$nama', '$jenis', '$status')");

echo "<script>alert('Data BPJS berhasil disimpan!');location.href='../admin/tambah_bpjs.php';</script>";
