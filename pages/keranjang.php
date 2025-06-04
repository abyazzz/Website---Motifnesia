<?php
session_start();
require '../functions/functionKeranjang.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: halamanlogin2.php");
    exit;
}

$keranjang = getIsiKeranjang();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="../asstes/css/keranjang.css" />
    <link rel="stylesheet" href="../asstes/css/footer.css">
    <link rel="stylesheet" href="../asstes/css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <?php require '../asstes/header-footer/header.php'; ?>

<main>
  <form method="POST" action="checkOut.php">
    <div class="cart-container">
      <div class="cart-header">
        <div><input type="checkbox" id="checkAll" /> PRODUK</div>
        <div>HARGA</div>
        <div>JUMLAH</div>
        <div>SUBTOTAL</div>
      </div>

      <?php foreach ($keranjang as $item): ?>
      <div class="cart-item">
        <input type="checkbox" class="check-product" name="checkout_items[]" value="<?= $item['product_id'] ?>|<?= $item['ukuran'] ?>" />
        <img src="../asstes/img/<?= $item['gambar'] ?>" alt="Product Image" />
        <div class="product-details"><?= $item['nama_produk'] ?></div>
        <div class="product-size">Ukuran: <?= $item['ukuran'] ?></div>
        <div class="product-price">Rp<?= number_format($item['harga'], 0, ',', '.') ?></div>
        <div class="product-quantity">
          <button class="btn-minus" type="button" data-id="<?= $item['product_id'] ?>" data-ukuran="<?= $item['ukuran'] ?>">-</button>
          <span class="quantity"><?= $item['qty'] ?></span>
          <button class="btn-plus" type="button" data-id="<?= $item['product_id'] ?>" data-ukuran="<?= $item['ukuran'] ?>">+</button>
        </div>
        <div class="product-subtotal subtotal-item" data-harga="<?= $item['harga'] * $item['qty'] ?>">Rp<?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="container">
      <div class="header">TOTAL KERANJANG BELANJA</div>
      <div class="row">
        <div class="label">Subtotal</div>
        <div class="value total-belanja">Rp0</div>
      </div>
      <div class="total">
        <p>Total<span class="spasi total-belanja">Rp0</span></p>
        <button type="submit" class="lanjut-button">Checkout</button>
      </div>
    </div>
  </form>
</main>

<?php require '../asstes/header-footer/footer.php'; ?>

<script>
$(document).ready(function() {
  $(document).on('click', '.btn-plus', function() {
    const id = $(this).data('id');
    const ukuran = $(this).data('ukuran');
    updateQuantity(id, ukuran, 'increase');
  });

  $(document).on('click', '.btn-minus', function() {
    const id = $(this).data('id');
    const ukuran = $(this).data('ukuran');
    updateQuantity(id, ukuran, 'decrease');
  });

  function updateQuantity(productId, ukuran, action) {
    $.post('../functions/update_quantity.php', {
      product_id: productId,
      ukuran: ukuran,
      action: action
    }, function() {
      location.reload();
    });
  }

  function hitungTotal() {
    let total = 0;
    $('.check-product:checked').each(function() {
      const subtotal = $(this).closest('.cart-item').find('.subtotal-item').data('harga');
      total += subtotal;
    });
    $('.total-belanja').text('Rp' + total.toLocaleString('id-ID'));
  }

  $(document).on('change', '.check-product', hitungTotal);
  $('#checkAll').on('change', function() {
    $('.check-product').prop('checked', this.checked);
    hitungTotal();
  });

  // ✅ VALIDASI sebelum submit ke checkOut.php
  $("form").on("submit", function(e) {
    const checked = $(".check-product:checked");
    if (checked.length === 0) {
      e.preventDefault();
      alert("Pilih minimal satu produk untuk checkout.");
    }
  });
});
</script>

</body>
</html>
