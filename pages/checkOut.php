<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="Zcart.css" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="stylesheet" href="../asstes/css/checkOut.css">
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
      <div class="cart-item">
        <input class="button-co" type="checkbox">
        <img src="FotoBatik/batik (1).jpg" alt="Dress Batik" />
        <div class="product-details">Batik Arya Timur - BIRU, SS</div>
        <div class="product-price">Rp300.000</div>
        <div class="product-quantity">
          <button>-</button>
          <span>1</span>
          <button>+</button>
        </div>
        <div class="product-subtotal">Rp300.000</div>
      </div>
      <div class="update-cart">
        <button>PERBARUI KERANJANG</button>
      </div>
    </div>
      <div class="container">
        <div class="header">TOTAL KERANJANG BELANJA</div>

        <div class="row">
          <div class="label">Subtotal</div>
          <div class="value">Rp300.000</div>
        </div>

        <div class="section-header">PENGIRIMAN</div>
        <div class="instructions">
          <p>Masukan alamat Anda untuk melihat opsi pengiriman.</p>
          <details class="alamat">
            <summary>Hitung Biaya pengiriman</summary>

            <input
              type="text"
              id="provinsi"
              name="provinsi"
              class="form-input"
              placeholder="Provinsi"
              required
            />

            <input
              type="text"
              id="kota"
              name="kota" 
              class="form-input"
              placeholder="Kota" 
              required
            />

            <input
              type="number"
              id="kodepos"
              name="kodepos"
              class="form-input"
              placeholder="Kode pos"
              required
            />

            <button type="button" class="update-button">PERBARUI TOTAL</button>
          </details>
        </div>
        <div class="total">
          <p>Total<span class="spasi">Rp315.000</span></p>
          <a href="Zco.html"><button type="button" class="lanjut-button">Checkout</button></a>
        </div>
        </div>
      </div>
</main>
      <?php require '../asstes/header-footer/footer.php'; ?>
  </body>
</html>
