<?php
require __DIR__ . '/../../functions/koneksi.php';

// Ambil data slideshow
$query = $conn->query("SELECT * FROM konten_slideshow WHERE id = 1");
$data = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Slideshow</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="containerr">
  <div id="carouselExampleIndicators" class="carousel slide huu" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/admin/uploads_slideshow/<?= $data['link_banner_1'] ?>" class="d-block w-100 h-100" alt="<?= $data['nama_banner_1'] ?>">
      </div>
      <div class="carousel-item">
        <img src="/admin/uploads_slideshow/<?= $data['link_banner_2'] ?>" class="d-block w-100 h-100" alt="<?= $data['nama_banner_2'] ?>">
      </div>
      <div class="carousel-item">
        <img src="/admin/uploads_slideshow/<?= $data['link_banner_3'] ?>" class="d-block w-100 h-100" alt="<?= $data['nama_banner_3'] ?>">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

</body>
</html>
