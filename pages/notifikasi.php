<?php
session_start();
require '../functions/koneksi.php';
require '../asstes/header-footer/header.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header("Location: halamanlogin2.php");
  exit;
}

// Ambil semua notifikasi user
$notif = $conn->query("SELECT * FROM notifikasi WHERE user_id = $user_id ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi</title>
  <link rel="stylesheet" href="../asstes/css/notifikasi.css">
  <style>
    .produk-list {
      margin-top: 10px;
      padding-left: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📩 Notifikasi Kamu</h2>

    <?php while ($n = $notif->fetch_assoc()): ?>
      <div class="container-notif">
        <h3><?= $n['judul'] ?></h3>
        <p><?= $n['deskripsi'] ?></p>
        <small><?= $n['waktu'] ?></small>

        <?php
          $checkout_id = $n['checkout_id'] ?? null;
          if ($checkout_id) {
            $produk = $conn->query("SELECT p.nama_produk, ci.ukuran, ci.qty, ci.harga_satuan
              FROM checkout_items ci
              JOIN produk p ON ci.product_id = p.id
              WHERE ci.checkout_id = $checkout_id");
        ?>
        <div class="produk-list">
          <ul>
            <?php while ($p = $produk->fetch_assoc()): ?>
              <li>
                <?= $p['nama_produk'] ?> (<?= $p['ukuran'] ?>) × <?= $p['qty'] ?> - Rp <?= number_format($p['harga_satuan'], 0, ',', '.') ?>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
        <?php } ?>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
