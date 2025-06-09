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
    $ukuran = $_POST['ukuran'] ?? '';
    tambahKeKeranjang($id, $ukuran);
    echo "<script>
            alert('berhasil menambah produk ke keranjang');
        </script>";
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
  echo "<script>
            alert('berhasil menambah produk ke Fvorite');
        </script>";
}

$ulasanQuery = "SELECT u.nama_lengkap, ul.rating, ul.deskripsi
FROM ulasan_pelanggan ul
JOIN users u ON ul.user_id = u.id
WHERE ul.product_id = $id";
$ulasan = mysqli_query($conn, $ulasanQuery);

$rataRating = 0;
$jumlahUlasan = mysqli_num_rows($ulasan);
if ($jumlahUlasan > 0) {
    $total = 0;
    $ulasanData = [];
    while ($row = mysqli_fetch_assoc($ulasan)) {
        $ulasanData[] = $row;
        $total += $row['rating'];
    }
    $rataRating = round($total / $jumlahUlasan, 1);
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
            <form method="post" style="display: inline;">
                <div class="size-options">
                    <p><strong>Ukuran:</strong></p>
                    <label><input type="radio" name="ukuran" value="SS"> SS</label>
                    <label><input type="radio" name="ukuran" value="S"> S</label>
                    <label><input type="radio" name="ukuran" value="M"> M</label>
                    <label><input type="radio" name="ukuran" value="L"> L</label>
                    <label><input type="radio" name="ukuran" value="XL"> XL</label>
                  </div>
                </div>
                <div class="add-to-cart">
            
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
      <div class="ulasan">
        <h2>Ulasan Produk</h2>
        <?php if ($jumlahUlasan === 0): ?>
          <p>Belum ada ulasan untuk produk ini.</p>
        <?php else: ?>
          <div class="rata-rata">
            <i class="fa-solid fa-star"></i>
            <span><?= $rataRating ?></span> dari <?= $jumlahUlasan ?> ulasan
          </div>
          <div class="ulasan-list">
            <?php foreach ($ulasanData as $ul): ?>
              <div class="ulasan-item">
                <p><strong><?= htmlspecialchars($ul['nama_lengkap']) ?></strong></p>
                <p><i class="fa-solid fa-star"></i> <?= $ul['rating'] ?></p>
                <p><?= htmlspecialchars($ul['deskripsi']) ?></p>

              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
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

    <script>
      const burger = document.querySelector('.burger');
      const nav = document.querySelector('.huhu ul');
      
      burger.addEventListener('click', () => {
          nav.classList.toggle('nav-active');
      });
      
      document.querySelector('.btn-tambah-keranjang').addEventListener('click', function(e) {
          const ukuranDipilih = document.querySelector('input[name="ukuran"]:checked');
          if (!ukuranDipilih) {
              alert('Silakan pilih ukuran terlebih dahulu!');
              e.preventDefault();
          }
      });
      
    </script>
  </body>
</html>
