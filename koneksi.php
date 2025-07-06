<?php
$koneksi = mysqli_connect("localhost", "root", "", "desacipancur");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
