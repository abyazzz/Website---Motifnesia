<?php
require '../functions/koneksi.php';
require '../asstes/header-footer/header.php';

$query = $conn->query("SELECT c.id AS checkout_id, c.user_id, u.nama_lengkap, u.email, c.alamat, c.total_bayar, c.status_id
  FROM checkout c
  JOIN users u ON c.user_id = u.id
  ORDER BY c.created_at DESC");

$statusList = $conn->query("SELECT * FROM status_transaksi")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Status Pesanan</title>
  <link rel="stylesheet" href="css/status.css">
  <style>
    .modal-bg {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .modal {
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      max-height: 80vh;
      overflow-y: auto;
    }
    .modal h3 {
      margin-top: 0;
    }
    .close-modal {
      float: right;
      cursor: pointer;
      font-weight: bold;
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <aside>
      <section class="profil">
        <i>[icon]</i>
        <p>Admin</p>
      </section>
      <div class="nav">
        <li><a href="Koleksi.php"><p>Koleksi</p></a></li>
        <li><a href="penjualan.php"><p>Penjualan & Stok</p></a></li>
        <li><a href="pelanggan.php"><p>Pelanggan</p></a></li>
        <li><a href="#"><p>Status</p></a></li>
        <li><a href="tembah.php"><p>Tambah Produk</p></a></li>
      </div>
    </aside>

    <main>
      <h2>Status Pesanan Pelanggan</h2>

      <?php while ($row = $query->fetch_assoc()): ?>
        <?php
          $checkout_id = $row['checkout_id'];
          $produk = $conn->query("SELECT ci.*, p.nama_produk FROM checkout_items ci JOIN produk p ON ci.product_id = p.id WHERE ci.checkout_id = $checkout_id");
        ?>
        <form method="post" action="proses_status.php" class="akun-pelanggan">
          <section><?= $row['nama_lengkap'] ?></section>
          <section>
            <ul>
              <?php while ($p = $produk->fetch_assoc()): ?>
                <li><?= $p['nama_produk'] ?> (<?= $p['ukuran'] ?>) × <?= $p['qty'] ?> - Rp <?= number_format($p['harga_satuan'], 0, ',', '.') ?></li>
              <?php endwhile; ?>
            </ul>
          </section>
          <section>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></section>
          <section><?= $row['alamat'] ?></section>
          <button type="button" onclick="showModal(<?= $checkout_id ?>)">Lihat Bukti Pembayaran</button>
          <section>
            <select name="status_id">
              <?php foreach ($statusList as $s): ?>
                <option value="<?= $s['id'] ?>" <?= $s['id'] == $row['status_id'] ? 'selected' : '' ?>>
                  <?= $s['nama_status'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </section>
          <section>
            <input type="hidden" name="checkout_id" value="<?= $checkout_id ?>">
            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
            <button type="submit">Update</button>
            
          </section>
        </form>
      <?php endwhile; ?>
    </main>
  </div>

  <!-- Modal -->
  <div class="modal-bg" id="modalBukti">
    <div class="modal">
      <span class="close-modal" onclick="closeModal()">✖</span>
      <h3>Bukti Pembayaran</h3>
      <div id="modalContent">Loading...</div>
    </div>
  </div>

  <script>
    function showModal(id) {
      document.getElementById('modalBukti').style.display = 'flex';
      document.getElementById('modalContent').innerHTML = 'Loading...';

      fetch('../functions/get_bukti_pembayaran.php?checkout_id=' + id)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modalContent').innerHTML = html;
        })
        .catch(() => {
          document.getElementById('modalContent').innerHTML = 'Gagal memuat data.';
        });
    }

    function closeModal() {
      document.getElementById('modalBukti').style.display = 'none';
    }
  </script>
</body>
</html>
