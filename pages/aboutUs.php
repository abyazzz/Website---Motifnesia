<?php
require '../functions/koneksi.php';
$about = mysqli_query($conn, "SELECT * FROM about_us LIMIT 1");
$data = mysqli_fetch_assoc($about);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="../asstes/css/aboutUs.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
</head>
<body>
  <header>
    <section class="atas">
      <h1></h1>
      <p>NusantaraBatik</p>
      <a href="inedk.html">SHOP NOW</a>
    </section>

    <!-- Background Banner -->
    <section class="iklan" style="
      background-image: url('<?= $data['bg_banner'] ?>');
      background-size: cover;
      background-position: center;
      height: 300px;">
    </section>
  </header>

  <div class="containerrr">
    <main>
      <aside></aside>
      <article>
        <!-- Tentang Kami -->
        <section class="ttg">
          <div class="foto">
            <?php if (!empty($data['img_ttg_kami'])): ?>
              <img src="<?= $data['img_ttg_kami'] ?>" alt="Tentang Kami" width="300" />
            <?php endif; ?>
          </div>
          <aside class="aside">
            <h2>Tentang kami</h2>
            <p><?= nl2br(htmlspecialchars($data['desc_ttg_kami'])) ?></p>
          </aside>
        </section>

        <!-- Visi Misi -->
        <section class="visi-misi">
          <aside class="aside">
            <h2>Visi & Misi</h2>
            <p><?= nl2br(htmlspecialchars($data['desc_visi_misi'])) ?></p>
          </aside>
          <div class="foto">
            <?php if (!empty($data['img_visi_misi'])): ?>
              <img src="<?= $data['img_visi_misi'] ?>" alt="Visi Misi" width="300" />
            <?php endif; ?>
          </div>
        </section>

        <!-- Nilai-Nilai -->
        <section class="nilai-nilai">
          <div class="foto">
            <?php if (!empty($data['img_nilai'])): ?>
              <img src="<?= $data['img_nilai'] ?>" alt="Nilai-Nilai" width="300" />
            <?php endif; ?>
          </div>
          <aside class="aside">
            <h2>Nilai-nilai</h2>
            <p><?= nl2br(htmlspecialchars($data['desc_nilai'])) ?></p>
          </aside>
        </section>

        <!-- Sejarah Batik -->
        <div class="sejarah">
          <h2>Sejarah Batik</h2>
          <p><?= nl2br(htmlspecialchars($data['sejarah_batik'])) ?></p>
        </div>
      </article>
    </main>

    <?php require '../asstes/header-footer/footer.php'; ?>
  </div>
</body>
</html>
