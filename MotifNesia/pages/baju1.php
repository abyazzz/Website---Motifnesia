<?php 
  require '../functions/function.php';
  $baju = query("SELECT * FROM produk");

  
  $id = $_GET["id"];
  $dataProduk = query("SELECT * FROM produk WHERE id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>baju1</title>
    <link rel="stylesheet" href="../asstes/css/baju1.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="../asstes/css/header.css" />
    <link rel="stylesheet" href="../asstes/css/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
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
              <li><a href="indexLogin.html">Home</a></li>
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
    <div class="container">
      <div class="atas">
        <div class="images">
          <img
            src="../asstes/img/<?= $dataProduk["gambar"]; ?> ?>"
            alt="Dress Batik"
            class="main-image"
          />
        </div>
        <div class="deskripsi">
          <h1><?= $dataProduk["nama_produk"]; ?></h1>
          <div class="harga"><?= $dataProduk["harga"]; ?></div>
          <ul class="info">
            <li><strong>Material:</strong><?= $dataProduk["material"]; ?></li>
            <li><strong>Proses:</strong> <?= $dataProduk["proses"]; ?></li>
            <li><em>Harga belum termasuk ongkos kirim</em></li>
          </ul>
          <p><strong>SKU:</strong> <?= $dataProduk["sku"]; ?></p>
          <p>
            <strong>Kategori:</strong>  <?= $dataProduk["kategori"]; ?>
          </p>
          <p><strong>Tags:</strong><?= $dataProduk["tags"]; ?></p>
          <div class="options">
            <div class="size-options">
              <p><strong>Ukuran:</strong></p>
              <button class="size">SS</button>
              <button class="size">S</button>
              <button class="size">M</button>
              <button class="size">L</button>
              <button class="size">XL</button>
            </div>
          </div>
          <div class="add-to-cart">
            <input type="number" value="1" min="1" />
            <a href="Zcart.php">Tambah ke Keranjang</a>
          </div>
          <div class="additional-info">
            <p><strong>WhatsApp:</strong> +62 812-2272-6808</p>
          </div>
        </div>
      </div>
      <div class="bawah">
        <div class="barang-barang">
        <?php foreach ($baju as $row) : ?>
          <a href="baju1.php?id=<?= $row['id']; ?>" class="barang">
            <img src="../asstes/img/<?php echo $row['gambar']; ?>" class="foto"></img >
            <div class="">
              <p><?php echo $row['nama_produk']; ?></p>
              <h2><?php echo $row['harga']; ?></h2>
              <section>
                <i class="fa-solid fa-star"></i>
                <p>5.0</p>
                <i class="fa-regular fa-heart"></i>
              </section>
            </div>
          </a>
          <?php endforeach ?>
        </div>
      </div>
    </div>
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
    <script>const burger = document.querySelector('.burger');
      const nav = document.querySelector('.huhu ul');
      
      burger.addEventListener('click', () => {
          nav.classList.toggle('nav-active');
      });</script>
  </body>
</html>
