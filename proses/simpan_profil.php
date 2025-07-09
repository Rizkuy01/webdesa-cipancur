<?php
session_start();
include 'C:\xampppp\htdocs\webdesa-cipancur\config\db.php';

$kategori = $_POST['kategori'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

$foto = '';
if ($_FILES['foto']['name']) {
  $namaFile = time() . '-' . $_FILES['foto']['name'];
  $lokasi = "../upload/" . $namaFile;
  move_uploaded_file($_FILES['foto']['tmp_name'], $lokasi);
  $foto = $namaFile;
}

$sql = "INSERT INTO profil_desa (kategori, judul, deskripsi, foto) 
        VALUES ('$kategori', '$judul', '$deskripsi', '$foto')";

$conn->query($sql);

$_SESSION['msg'] = "Data berhasil disimpan!";
header("Location: C:\Users\ASUS\webdesa-cipancur\admin\edit_profil.php");


