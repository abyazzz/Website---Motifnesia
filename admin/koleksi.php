<?php 
  session_start();
  require '../functions/function.php';
  $baju = query("SELECT * FROM produk");
 
  if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
      header("Location: pages/halamanlogin2.php");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/koleksi.css" />
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
            <li><a href="inedk.html">Home</a></li>
            <li><a href="dasbord.html">About Us</a></li>
            <li><a href="ZZcontact2.html">Contact</a></li>
            <li><a href="ZZlayanankami.html">Service</a></li>
            <li><a href="Zcart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a href="#"><i class="fa-regular fa-bell"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </nav>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</header>
<script>const burger = document.querySelector('.burger');
  const nav = document.querySelector('.huhu ul');
  
  burger.addEventListener('click', () => {
      nav.classList.toggle('nav-active');
  });</script>
    <div class="container">
      <aside>
        <section class="profil">
          <i><svg xmlns="http://www.w3.org/2000/svg" height="110px" viewBox="0 -960 960 960" width="110px" fill="#e8eaed"><path d="M222-255q63-44
             125-67.5T480-346q71 0 133.5 23.5T739-255q44-54 62.5-109T820-480q0-145-97.5-242.5T480-820q-145 0-242.5 97.5T140-480q0 61 19 116t63 
             109Zm257.81-195q-57.81 0-97.31-39.69-39.5-39.68-39.5-97.5 0-57.81 39.69-97.31 39.68-39.5 97.5-39.5 57.81 0 97.31 39.69 39.5 39.68 
             39.5 97.5 0 57.81-39.69 97.31-39.68 39.5-97.5 39.5Zm.66 370Q398-80 325-111.5t-127.5-86q-54.5-54.5-86-127.27Q80-397.53 80-480.27
              80-563 111.5-635.5q31.5-72.5 86-127t127.27-86q72.76-31.5 155.5-31.5 82.73 0 155.23 31.5 72.5 31.5 127 86t86 127.03q31.5 72.53 
              31.5 155T848.5-325q-31.5 73-86 127.5t-127.03 86Q562.94-80 480.47-80Zm-.47-60q55 0 107.5-16T691-212q-51-36-104-55t-107-19q-54
               0-107 19t-104 55q51 40 103.5 56T480-140Zm0-370q34 0 55.5-21.5T557-587q0-34-21.5-55.5T480-664q-34 0-55.5 21.5T403-587q0 34
                21.5 55.5T480-510Zm0-77Zm0 374Z"/></svg></i>
          <p>Admin</p>
        </section>
        <div class="nav">
          <li>
            <a class="Pelanggan" href="Koleksi.php"><p>Koleksi</p></a>
          </li>
          <li>
            <a class="Pelanggan" href="penjualan.php"
              ><p>Penjualan & Stok</p></a
            >
          </li>
          <li>
            <a class="pelanggan" href="pelanggan.php"
              ><p>Pelanggan</p></a
            >
          </li>
          <li>
            <a class="Pelanggan" href="status.php"><p>Status</p></a>
          </li>
          <li>
            <a class="Pelanggan" href="tembah.php"
              ><p>Tambah Produk</p></a
            >
          </li>
        </div>
      </aside>
      <main>
        <section class="main">
          <div class="judul">Koleksi</div>
            <div class="barang-barang">
              <?php foreach ($baju as $row) : ?>
              <a href="baju2.html" class="barang">
              <img src="../asstes/img/<?php echo $row['gambar']; ?>" alt="" />
                <p><?php echo $row['nama_produk'] ?></p>
                <h2>Rp. <?php echo $row['harga'] ?></h2>
              </a>
            <?php endforeach ?>
            </div>
        </section>
      </main>
    </div>
    <footer class="admin-footer">
      <p>© 2024 NusantaraBatik Admin Dashboard | All rights reserved | Version 1.0.0</p>
    </footer>
  </body>
</html>
