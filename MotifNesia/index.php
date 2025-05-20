<?php 
  require 'functions/function.php';
  session_start();
  
  $baju = query("SELECT * FROM produk");

  if (isset($_POST['filter'])) {
    $kategori = $_POST['kategori'];
    $jenis_lengan = $_POST['jenis_lengan'];
    $baju = filterProduk($kategori, $jenis_lengan);
  } 
  else {
        $baju = query("SELECT * FROM produk");
  }

  if (isset($_POST['harga'])) {
    $range = explode('-', $_POST['harga']);
    $min = (int)$range[0];
    $max = (int)$range[1];
  
    $baju = filterProdukByHarga($min, $max); 
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="asstes/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="stylesheet" href="asstes/css/header.css">
    <link rel="stylesheet" href="asstes/css/footer.css">
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

  <?php require 'asstes/header-footer/header.php'; ?>


  <?php require 'asstes/Slideshow/slideShow.php'; ?>
    
    
      <main>
        <div class="kategori-harga">
        <div class="kategori">
          <form action="" method="POST">
            <section><p>Gender</p>
              <select name="kategori">
                <option value="">Semua</option>
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
                <option value="anak_anak">Anak-anak</option>
              </select>
            </section>
            <section><p>Jenis Lengan</p>
              <select name="jenis_lengan">
                <option value="">Semua</option>
                <option value="panjang">Panjang</option>
                <option value="pendek">Pendek</option>
              </select>
            </section> 
            <button class="filter-kategori" type="submit" name="filter">Filter</button>
          </form>
        </div>

        <div class="harga">
          <h2>Harga</h2>
          <hr />
          <form action="" method="POST">
            <button type="submit" name="harga" value="200000-400000">200.000 - 400.000</button>
            <button type="submit" name="harga" value="400000-600000">400.000 - 600.000</button>
            <button type="submit" name="harga" value="600000-800000">600.000 - 800.000</button>
            <button type="submit" name="harga" value="800000-1000000">800.000 - 1.000.000</button>
          </form>
        </div>
        </div>
  
        <div class="barang-barang">
          <?php foreach ($baju as $row) : ?>
            <a href="pages/baju1.php?id=<?= $row['id']; ?>" class="barang">
            <img src="asstes/img/<?php echo $row['gambar']; ?>" class="foto" />
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
      </main>
    </div>
  
  <?php require 'asstes/header-footer/footer.php'; ?>

    <script>const burger = document.querySelector('.burger');
      const nav = document.querySelector('.huhu ul');
      
      burger.addEventListener('click', () => {
          nav.classList.toggle('nav-active');
      });</script>
  </body>
</html>
