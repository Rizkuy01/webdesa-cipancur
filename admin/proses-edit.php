<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$konten = $_POST['konten'];
$icon = $_POST['icon'];

$query = "UPDATE profil_desa SET judul='$judul', konten='$konten', icon='$icon' WHERE id=$id";
mysqli_query($koneksi, $query);
header("Location: dashboard.php");
