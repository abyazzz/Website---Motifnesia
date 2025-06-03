<?php
session_start();
require '../functions/koneksi.php';
require '../asstes/header-footer/header.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header("Location: halamanlogin2.php");
  exit;
}

$notif = $conn->query("SELECT * FROM notifikasi WHERE user_id = $user_id ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi</title>
  <link rel="stylesheet" href="../asstes/css/notifikasi.css">
</head>
<body>
  <div class="container">
    <h2>📩 Notifikasi Kamu</h2>
    <?php while ($n = $notif->fetch_assoc()): ?>
      <div class="container-notif">
        <h3><?= $n['judul'] ?></h3>
        <p><?= $n['deskripsi'] ?></p>
        <small><?= $n['waktu'] ?></small>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
