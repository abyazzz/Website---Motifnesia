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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="stylesheet" href="../asstes/css/header.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    
  <?php require '../asstes/header-footer/header.php'; ?>

<main>
  <form method="POST" action="proses_checkout.php">
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
          <button class="btn-minus" data-id="<?= $item['product_id'] ?>" data-ukuran="<?= $item['ukuran'] ?>">-</button>
          <span class="quantity"><?= $item['qty'] ?></span>
          <button class="btn-plus" data-id="<?= $item['product_id'] ?>" data-ukuran="<?= $item['ukuran'] ?>">+</button>
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
});
</script>

</body>
</html>
