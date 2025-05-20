<?php 
  require '../functions/function.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="../asstes/css/Zcart.css" />
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
  </head>
  <body>
    <header>
    <div class="logo">NusantaraBatik</div>
    <nav class="huhu">
      <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="dasbord.html">About Us</a></li>
          <li><a href="ZZcontact2.html">Contact</a></li>
          <li><a href="ZZlayanankami.html">Service</a></li>
          <li><a href="Zcart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
          <li><a href="#"><i class="fa-regular fa-bell"></i></a></li>
          <li><div class="profill"></div></li>
      </ul>
    </nav>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</header>
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
      <footer>
        <div class="cont">
          <section class="satu">
            <h1>NusantaraBatik</h1>
            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
          </section>
          <section class="dua">
            <h3>Information</h3>
            <a href="#">About Us</a>
            <a href="#">Blog</a>
            <a href="#">Batik Insights</a>
            <a href="#">Events & Workshops</a>
          </section>
          <section class="tiga">
            <h3>Helpful Links</h3>
            <a href="#">Service</a>
            <a href="#">Pupports</a>
            <a href="#">Pravicy Policy</a>
            <a href="#">Service</a>
          </section>
          <section class="empat">
            <h3>Get App</h3>
            <img src="Screenshot 2024-11-22 015718.png" alt="playstore" />
            <img src="Screenshot 2024-11-22 015745.png" alt="appstore" />
          </section>
        </div>
        <p>© 2024 NusantaraBatik. All rights reserved.</p>
      </footer>
  </body>
</html>
