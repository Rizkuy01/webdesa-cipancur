<?php
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM profil_desa ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($data)) {
  echo '<div class="profile-card">';
  echo '<i class="fas ' . $row['icon'] . '"></i>';
  echo '<h4>' . $row['judul'] . '</h4>';
  echo '<p>' . nl2br($row['konten']) . '</p>';
  echo '</div>';
}
?>
