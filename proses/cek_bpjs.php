<?php
session_start();
include '../config/db.php';

$nik = $_POST['nik'];
$query = $conn->query("SELECT * FROM bpjs WHERE nik = '$nik'");

if ($query->num_rows > 0) {
  $data = $query->fetch_assoc();
  $_SESSION['hasil_bpjs'] = $data;
} else {
  $_SESSION['not_found'] = "NIK tidak ditemukan dalam data BPJS.";
}

header("Location: ../admin/cek_bpjs.php");
