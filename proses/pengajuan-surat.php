<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $nik = $_POST['nik'];
  $jenis = $_POST['jenis_surat'];
  $keterangan = $_POST['keterangan'];
  $berkas = $_FILES['berkas_pendukung']['name'];
  $tmp = $_FILES['berkas_pendukung']['tmp_name'];

  $uploadDir = "uploads/";
  if (!is_dir($uploadDir)) mkdir($uploadDir);

  $path = $uploadDir . basename($berkas);
  move_uploaded_file($tmp, $path);

  $file = fopen("pengajuan-data.csv", "a");
  fputcsv($file, [$nama, $nik, $jenis, $keterangan, $berkas, date("Y-m-d H:i:s")]);
  fclose($file);

  echo "<script>alert('Pengajuan berhasil dikirim!'); window.location.href='index.html';</script>";
}
?>
