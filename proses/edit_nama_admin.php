<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id']);
  $nama = trim($_POST['nama']);

  if ($nama !== '') {
    $stmt = $conn->prepare("UPDATE admin SET nama = ? WHERE id = ?");
    $stmt->bind_param("si", $nama, $id);
    if ($stmt->execute()) {
      if ($_SESSION['admin_id'] == $id) {
        $_SESSION['admin']['nama'] = $nama; // update session juga
      }
      $_SESSION['admin_msg'] = "Nama berhasil diperbarui.";
    } else {
      $_SESSION['admin_error'] = "Gagal memperbarui nama.";
    }
    $stmt->close();
  } else {
    $_SESSION['admin_error'] = "Nama tidak boleh kosong.";
  }
}

header("Location: ../admin/kelola_admin.php");
exit;
