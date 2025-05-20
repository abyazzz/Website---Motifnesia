<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../functions/functionKeranjang.php'; // Ganti dengan path fungsi yang sesuai

// Ambil ID user dari session (pastikan user sudah login)
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../pages/halamanlogin2.php");
    exit;
}

// Ambil data produk di keranjang berdasarkan user
$keranjang = getIsiKeranjang($user_id);

// Fungsi untuk hitung subtotal dan total
$total_harga = 0;
foreach ($keranjang as $item) {
    $subtotal = $item['harga'] * $item['qty'];
    $total_harga += $subtotal;
}
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
    <div class="cart-container">
      <div class="cart-header">
        <div>PRODUK</div>
        <div>HARGA</div>
        <div>JUMLAH</div>
        <div>SUBTOTAL</div>
      </div>

      <?php foreach ($keranjang as $item): ?>
        <div class="cart-item">
          <img src="../asstes/img/<?php echo $item['gambar']; ?>" alt="Product Image" />
          <div class="product-details"><?php echo $item['nama_produk']; ?></div>
          <div class="product-price">Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></div>
          <div class="product-quantity">
              <button class="btn-minus" data-id="<?= $item['product_id'] ?>">-</button>
              <span class="quantity"><?= $item['qty'] ?></span>
              <button class="btn-plus" data-id="<?= $item['product_id'] ?>">+</button>
          </div>
          <div class="product-subtotal">Rp<?php echo number_format($item['harga'] * $item['qty'], 0, ',', '.'); ?></div>
        </div>
      <?php endforeach; ?>

      <div class="update-cart">
        <!-- Arahkan button ke index.php untuk update keranjang -->
        <a href="../index.php">
          <button>PERBARUI KERANJANG</button>
        </a>
      </div>
    </div>

    <div class="container">
        <div class="header">TOTAL KERANJANG BELANJA</div>

        <div class="row">
          <div class="label">Subtotal</div>
          <div class="value">Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></div>
        </div>

        <div class="total">
          <p>Total<span class="spasi">Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></span></p>
          <a href="Zco.html"><button type="button" class="lanjut-button">Checkout</button></a>
        </div>
    </div>
</main>


<?php require '../asstes/header-footer/footer.php'; ?>

<script>
$(document).ready(function() {
    // Tombol Plus
    $('.btn-plus').click(function() {
        const productId = $(this).data('id');
        updateQuantity(productId, 'increase');
    });

    // Tombol Minus
    $('.btn-minus').click(function() {
        const productId = $(this).data('id');
        updateQuantity(productId, 'decrease');
    });

    function updateQuantity(productId, action) {
        $.ajax({
            url: '../functions/update_quantity.php',
            type: 'POST',
            data: {
                product_id: productId,
                action: action
            },
            success: function(response) {
                // Refresh halaman setelah update
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
});
</script>

</body>
</html>
