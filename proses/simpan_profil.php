<?php
session_start();
include '../config/db.php';

$kategori = $_POST['kategori'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$foto_nama = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_nama = time() . '-' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], '../aset/' . $foto_nama);
}

// Jika edit
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if ($foto_nama) {
        // Hapus foto lama
        if (!empty($_POST['foto_lama']) && file_exists('../aset/' . $_POST['foto_lama'])) {
            unlink('../aset/' . $_POST['foto_lama']);
        }

        $stmt = $conn->prepare("UPDATE profil_desa SET kategori=?, judul=?, deskripsi=?, foto=? WHERE id=?");
        $stmt->bind_param("ssssi", $kategori, $judul, $deskripsi, $foto_nama, $id);
    } else {
        $stmt = $conn->prepare("UPDATE profil_desa SET kategori=?, judul=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("sssi", $kategori, $judul, $deskripsi, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Data berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data.";
    }
    header("Location: ../admin/lihat_profil.php");
    exit;
}

// Jika tambah baru
$stmt = $conn->prepare("INSERT INTO profil_desa (kategori, judul, deskripsi, foto, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $kategori, $judul, $deskripsi, $foto_nama);

if ($stmt->execute()) {
    $_SESSION['msg'] = "Data berhasil disimpan.";
} else {
    $_SESSION['error'] = "Gagal menyimpan data.";
}

header("Location: ../admin/lihat_profil.php");
exit;
