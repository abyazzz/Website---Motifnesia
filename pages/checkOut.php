<?php
session_start();
require '../functions/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: halamanlogin2.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['checkout_items']) || empty($_POST['checkout_items'])) {
    echo "<p>Tidak ada produk yang dipilih untuk checkout.</p>";
    exit;
}

$checkout_items = $_POST['checkout_items'];
$produk_data = [];
$total_harga = 0;

foreach ($checkout_items as $item) {
    list($product_id, $ukuran) = explode('|', $item);
    
    $stmt = $conn->prepare("SELECT k.qty, p.nama_produk, p.harga, p.gambar FROM keranjang k JOIN produk p ON k.product_id = p.id WHERE k.user_id = ? AND k.product_id = ? AND k.ukuran = ?");
    $stmt->bind_param("iis", $user_id, $product_id, $ukuran);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $subtotal = $row['harga'] * $row['qty'];
        $produk_data[] = [
            'id' => $product_id,
            'nama' => $row['nama_produk'],
            'gambar' => $row['gambar'],
            'ukuran' => $ukuran,
            'qty' => $row['qty'],
            'harga' => $row['harga'],
            'subtotal' => $subtotal
        ];
        $total_harga += $subtotal;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran</title>
  <link rel="stylesheet" href="../asstes/css/checkOut.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php require '../asstes/header-footer/header.php'; ?>

<main>
  <form action="../functions/functionCheckOut.php" method="POST">
    <div class="checkout-container">
      <div class="section alamat">
        <label>Alamat:</label>
        <input type="text" name="alamat" required />
      </div>

      <div class="section produk">
        <?php foreach ($produk_data as $produk): ?>
          <div class="produk-item">
            <img src="../asstes/img/<?= $produk['gambar'] ?>" alt="produk">
            <div class="produk-detail">
              <p class="nama"><?= $produk['nama'] ?></p>
              <p class="ukuran">Ukuran: <?= $produk['ukuran'] ?></p>
              <p class="qty">Jumlah: <?= $produk['qty'] ?></p>
              <p class="harga">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
            </div>
          </div>
          <input type="hidden" name="produk_id[]" value="<?= $produk['id'] ?>">
          <input type="hidden" name="ukuran[]" value="<?= $produk['ukuran'] ?>">
          <input type="hidden" name="qty[]" value="<?= $produk['qty'] ?>">
          <input type="hidden" name="harga[]" value="<?= $produk['harga'] ?>">
        <?php endforeach; ?>
      </div>

      <div class="section pengiriman">
        <h4>Metode Pengiriman</h4>
        <label><input type="radio" name="pengiriman" value="reguler" data-ongkir="15000" required> Reguler (2-5 hari) - Rp15.000</label>
        <label><input type="radio" name="pengiriman" value="ekspres" data-ongkir="20000"> Ekspres (1-2 hari) - Rp20.000</label>
        <label><input type="radio" name="pengiriman" value="ekonomis" data-ongkir="10000"> Ekonomis (4-7 hari) - Rp10.000</label>
      </div>

      <div class="section pembayaran">
        <h4>Metode Pembayaran</h4>
        <label><input type="radio" name="pembayaran" value="mandiri" required> Mandiri Virtual Account</label>
        <label><input type="radio" name="pembayaran" value="bca"> BCA Virtual Account</label>
        <label><input type="radio" name="pembayaran" value="gopay"> GoPay</label>
        <label><input type="radio" name="pembayaran" value="cod"> Bayar di Tempat (COD)</label>
      </div>

      <div class="section rincian">
        <h4>Rincian Belanja</h4>
        <?php foreach ($produk_data as $produk): ?>
          <div class="row">
            <span><?= $produk['nama'] ?> (x<?= $produk['qty'] ?>)</span>
            <span>Rp<?= number_format($produk['subtotal'], 0, ',', '.') ?></span>
          </div>
        <?php endforeach; ?>
        <div class="row">
          <span>Total Harga:</span>
          <span id="total-harga">Rp<?= number_format($total_harga, 0, ',', '.') ?></span>
        </div>
        <div class="row">
          <span>Ongkos Kirim:</span>
          <span id="total-ongkir">Rp0</span>
        </div>
        <div class="row total">
          <strong>Total Bayar:</strong>
          <strong id="total-bayar">Rp<?= number_format($total_harga, 0, ',', '.') ?></strong>
        </div>
        <input type="hidden" name="total_harga" value="<?= $total_harga ?>">
        <input type="hidden" name="ongkir" id="input-ongkir" value="0">
        <input type="hidden" name="total_bayar" id="input-total-bayar" value="<?= $total_harga ?>">
        <button type="submit" class="btn-bayar">Bayar</button>
      </div>
    </div>
  </form>
</main>

<script>
  $(document).ready(function() {
    $('input[name="pengiriman"]').change(function() {
      const ongkir = parseInt($(this).data('ongkir'));
      const totalHarga = <?= $total_harga ?>;
      const totalBayar = ongkir + totalHarga;

      $('#total-ongkir').text('Rp' + ongkir.toLocaleString('id-ID'));
      $('#total-bayar').text('Rp' + totalBayar.toLocaleString('id-ID'));

      $('#input-ongkir').val(ongkir);
      $('#input-total-bayar').val(totalBayar);
    });
  });
</script>

<?php require '../asstes/header-footer/footer.php'; ?>
</body>
</html>