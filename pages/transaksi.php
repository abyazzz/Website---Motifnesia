<?php
require '../functions/koneksi.php';
require '../asstes/header-footer/header.php';

// Ambil semua transaksi grouped by checkout_id
$query = $conn->query("SELECT c.id AS checkout_id, c.user_id, u.nama_lengkap, u.email, c.alamat, c.total_bayar, c.status_id, c.pengiriman, c.pembayaran
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
      z-index: 1000;
    }
    .modal {
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      text-align: left;
    }
    .modal h2 {
      margin-bottom: 10px;
    }
    .modal .close-btn {
      background: crimson;
      color: white;
      border: none;
      padding: 5px 10px;
      margin-top: 15px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="container">
  <aside>
    <section class="profil">
      <i><svg xmlns="http://www.w3.org/2000/svg" height="110px" viewBox="0 -960 960 960" width="110px" fill="#e8eaed"><path d="..."/></svg></i>
      <p>Admin</p>
    </section>
    <div class="nav">
      <li><a class="Status" href="Koleksi.php"><p>Koleksi</p></a></li>
      <li><a class="Status" href="penjualan.php"><p>Penjualan & Stok</p></a></li>
      <li><a class="Status" href="pelanggan.php"><p>Pelanggan</p></a></li>
      <li><a class="status" href="#"><p>Status</p></a></li>
      <li><a class="Status" href="tembah.php"><p>Tambah Produk</p></a></li>
    </div>
  </aside>

  <main>
    <h2>Status Pesanan Pelanggan</h2>

    <?php while ($row = $query->fetch_assoc()):
      $checkout_id = $row['checkout_id'];
      $produk = $conn->query("SELECT ci.*, p.nama_produk FROM checkout_items ci JOIN produk p ON ci.product_id = p.id WHERE ci.checkout_id = $checkout_id");
    ?>
      <form method="post" action="proses_status.php" class="akun-pelanggan">
        <section><?= $row['nama_lengkap'] ?></section>
        <section>
          <ul>
            <?php while ($p = $produk->fetch_assoc()): ?>
              <li><?= $p['nama_produk'] ?> (<?= $p['ukuran'] ?>) &nbsp;&nbsp; <?= $p['qty'] ?> &nbsp;&nbsp; Rp <?= number_format($p['harga_satuan'], 0, ',', '.') ?></li>
            <?php endwhile; ?>
          </ul>
        </section>
        <section>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></section>
        <section><?= $row['alamat'] ?></section>
        <section>
          <select name="status_id">
            <?php foreach ($statusList as $s): ?>
              <option value="<?= $s['id'] ?>" <?= $s['id'] == $row['status_id'] ? 'selected' : '' ?>><?= $s['nama_status'] ?></option>
            <?php endforeach; ?>
          </select>
        </section>
        <section>
          <input type="hidden" name="checkout_id" value="<?= $checkout_id ?>">
          <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
          <button type="submit">Update</button>
          <button type="button" class="lihat-bukti" data-checkout="<?= $checkout_id ?>">Lihat Bukti</button>
        </section>
      </form>
    <?php endwhile; ?>
  </main>
</div>

<div class="modal-bg" id="modalBukti">
  <div class="modal" id="modalContent">
    <h2>Bukti Pembayaran</h2>
    <div id="buktiDetail">Memuat...</div>
    <button class="close-btn" onclick="tutupModal()">Tutup</button>
  </div>
</div>

<script>
function tutupModal() {
  document.getElementById("modalBukti").style.display = "none";
}

document.querySelectorAll(".lihat-bukti").forEach(button => {
  button.addEventListener("click", function () {
    const id = this.getAttribute("data-checkout");
    fetch("../functions/get_bukti_pembayaran.php?checkout_id=" + id)
      .then(res => res.text())
      .then(html => {
        document.getElementById("buktiDetail").innerHTML = html;
        document.getElementById("modalBukti").style.display = "flex";
      });
  });
});
</script>

</body>
</html>
