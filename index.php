<?php 
  require 'functions/function.php';
  session_start();

  $baju = query("SELECT * FROM produk");

  $id_produk = $_GET['id'] ?? null;
  if ($id_produk) {
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id_produk");
    $produk = mysqli_fetch_assoc($query);
  }

  if (isset($_POST['filter'])) {
    $kategori = $_POST['kategori'];
    $jenis_lengan = $_POST['jenis_lengan'];
  } else {
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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - NusantaraBatik</title>
  <link rel="stylesheet" href="asstes/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com"> 
  <link rel="stylesheet" href="asstes/css/header.css">
  <link rel="stylesheet" href="asstes/css/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</head>

<body>
  <?php require 'asstes/header-footer/headerIndex.php'; ?>
  <?php require 'asstes/Slideshow/slideShow.php'; ?>

  <main>
    <div class="kategori-harga">
      <div class="kategori">
        <h2>Filter Kategori</h2>
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
        <h2>Filter Harga</h2>
        <hr />
        <form action="" method="POST">
          <button class="btn-harga" type="submit" name="harga" value="200000-400000">200.000 - 400.000</button>
          <button class="btn-harga" type="submit" name="harga" value="400000-600000">400.000 - 600.000</button>
          <button class="btn-harga" type="submit" name="harga" value="600000-800000">600.000 - 800.000</button>
          <button class="btn-harga" type="submit" name="harga" value="800000-1000000">800.000 - 1.000.000</button>
        </form>
      </div>
    </div>

    <div class="barang-barang">
      <?php foreach ($baju as $row) : ?>
        <a href="pages/baju1.php?id=<?= $row['id']; ?>" class="barang">
          <img src="asstes/img/<?= htmlspecialchars($row['gambar']); ?>" class="foto" />
          <div class="info-produk">
            <p class="nama-produk"><?= htmlspecialchars($row['nama_produk']); ?></p>

            <?php if ($row['diskon_persen'] > 0): ?>
              <h2 class="harga-diskon">Rp<?= number_format($row['harga_diskon'], 0, ',', '.') ?></h2>
              <div class="harga-normal-wrapper">
                <span class="harga-normal">Rp<?= number_format($row['harga'], 0, ',', '.') ?></span>
                <span class="diskon-label">Diskon <?= $row['diskon_persen'] ?>%</span>
              </div>
            <?php else: ?>
              <h2 class="harga-diskon">Rp<?= number_format($row['harga'], 0, ',', '.') ?></h2>
            <?php endif; ?>

            <section>
              <i class="fa-solid fa-star"></i>
              <?php 
                $produk_id = $row['id'];
                $rating_result = mysqli_query($conn, "SELECT ROUND(AVG(rating), 1) AS avg_rating FROM ulasan_pelanggan WHERE product_id = $produk_id");
                $rating_row = mysqli_fetch_assoc($rating_result);
                $avg_rating = $rating_row['avg_rating'] ?? 0;
              ?>
              <p><?= $avg_rating ?></p>
            </section>
          </div>
        </a>
      <?php endforeach ?> 
    </div>
  </main>

  <?php require 'asstes/header-footer/footer.php'; ?>

  <script>
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.huhu ul');

    burger.addEventListener('click', () => {
      nav.classList.toggle('nav-active');
    });
  </script>
</body>
</html>
