<?php
session_start();
include '../config/db.php';

// 1. Authenticate: Ensure an admin is logged in.
if (!isset($_SESSION['admin'])) {
  header("Location: ../admin/login.php");
  exit;
}

// 2. Validate Input: Check if the ID is provided and is a number.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Permintaan tidak valid. ID profil tidak ditemukan.";
    header("Location: ../admin/lihat_profil.php");
    exit;
}
$id = $_GET['id'];

// 3. Clean Up File: First, get the photo filename to delete it from the server.
$stmt_select = $conn->prepare("SELECT foto FROM profil_desa WHERE id = ?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows > 0) {
    $profil = $result->fetch_assoc();
    $foto_file = $profil['foto'];

    // If a photo filename exists, attempt to delete the file.
    if (!empty($foto_file)) {
        $file_path = '../aset/' . $foto_file;
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the physical file.
        }
    }
    $stmt_select->close();

    // 4. Delete Database Record: Use a prepared statement to prevent SQL injection.
    $stmt_delete = $conn->prepare("DELETE FROM profil_desa WHERE id = ?");
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        $_SESSION['msg'] = "Item profil berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus item profil: " . $conn->error;
    }
    $stmt_delete->close();
} else {
    $_SESSION['error'] = "Item profil dengan ID tersebut tidak ditemukan.";
}

$conn->close();

// 5. Redirect back to the profile list page with a status message.
header("Location: ../admin/lihat_profil.php");
exit;