<?php 
// PASTIKAN SESSION START ADA DI AWAL
session_start();
require '../functions/function.php';
require '../functions/functionKeranjang.php'; // Jangan lupa include ini!
require '../functions/functionFavorit.php';

$baju = query("SELECT * FROM produk");
$id = $_GET["id"];
$dataProduk = query("SELECT * FROM produk WHERE id = $id")[0];

// PROSES TAMBAH KE KERANJANG JIKA ADA POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_keranjang'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: halamanlogin2.php");
        exit;
    }
    tambahKeKeranjang($id);
    header("Location: keranjang.php"); // Redirect ke keranjang
    exit;
}

// PROSES TAMBAH/HApus FAVORIT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_favorit'])) {
  if (!isset($_SESSION['user_id'])) {
      header("Location: halamanlogin2.php");
      exit;
  }
  
  if (isFavorit($id)) {
      hapusFavorit($id);
  } else {
      tambahFavorit($id);
  }
  header("Location: favorit.php");
  exit;
}

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
   
  <?php require '../asstes/header-footer/header.php'; ?>

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
            <form method="post" style="display: inline;">
                <input type="hidden" name="tambah_keranjang" value="1">
                <button type="submit" class="btn-tambah-keranjang">Tambah ke Keranjang</button>
            </form>
            <form method="post" style="display: inline;">
              <input type="hidden" name="tambah_favorit" value="1">
              <button type="submit" class="btn-favorit">
                  <i class="<?= isFavorit($id) ? 'fa-solid' : 'fa-regular' ?> fa-heart"></i>
              </button>
          </form>
        </div>
        </div>
        
        <div class="desk">
          <h2>Deskripsi</h2>
        <?= $dataProduk["deskripsi"]; ?>
        </div>
      </div>
      <div class="bawah">
        <div class="barang-barang">
        <?php foreach ($baju as $row) : ?>
          <a href="baju1.php?id=<?= $row['id']; ?>" class="barang">
            <img src="../asstes/img/<?php echo $row['gambar']; ?>" class="foto"></img >
            <div class="">
              <p><?php echo $row['nama_produk']; ?></p>
              <h2><?php echo number_format($row['harga'], 0, ',', '.'); ?></h2>
              <section>
                <i class="fa-solid fa-star"></i>
                <p>5.0</p>
                
              </section>
            </div>
          </a>
          <?php endforeach ?>
        </div>
      </div>
    </div>
          
    <?php require '../asstes/header-footer/footer.php'; ?>

    <script>const burger = document.querySelector('.burger');
      const nav = document.querySelector('.huhu ul');
      
      burger.addEventListener('click', () => {
          nav.classList.toggle('nav-active');
      });</script>
  </body>
</html>
