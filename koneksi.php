<?php
$koneksi = mysqli_connect("localhost", "root", "", "webdesa-cipancur");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
