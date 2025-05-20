<?php
session_start();

if (!isset($_SESSION['user_id'])) { // <-- GANTI dari 'id' ke 'user_id'
  header("Location: halamanlogin2.php");
  exit;
}

// Misalnya lo mau ambil data user buat ditampilkan:
require 'functions/function.php';
$id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <link rel="stylesheet" href="profileUser.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
  <link rel="stylesheet" href="asstes/css/header.css">
  <link rel="stylesheet" href="asstes/css/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <header>
    <div class="logo">NusantaraBatik</div>
    <nav class="huhu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="dasbord.html">About Us</a></li>
        <li><a href="ZZcontact2.html">Contact</a></li>
        <li><a href="ZZlayanankami.html">Service</a></li>
        <li><a href="Zcart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
        <li><a href="#"><i class="fa-regular fa-bell"></i></a></li>
        <li>
          <div class="profill"></div>
        </li>
      </ul>
    </nav>
    <div class="burger">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
  </header>

  <div class="container">
    <div class="sidebar">
      <div class="profile-info">
        <?php if (!empty($user['foto'])): ?>
          <img src="uploads/<?= htmlspecialchars($user['foto']); ?>" alt="Profile Picture" class="profile-picture" />
        <?php else: ?>
          <img src="PP.png" alt="Profile Picture" class="profile-picture" />
        <?php endif; ?>
        <h3><?= htmlspecialchars($user['username']); ?></h3>
      </div>
      <div class="sidebar-section">
        <h4>PLUS</h4>
        <p>Nikmatin Bebas Ongkir tanpa batas!</p>
      </div>
      <div class="sidebar-links">
        <p><strong>GoPay:</strong><a href="#"> Aktifkan</a></p>
        <p><strong>ShopeePay:</strong><a href="#"> Aktifkan</a></p>
        <p><strong>Saldo:</strong> Rp500.000 <a href="#">Isi Saldo</a></p>
      </div>
    </div>

    <div class="main-content">
      <div class="tabs">
        <button class="tab active">Biodata Diri</button>
      </div>
      <div class="content">
        <div class="content-section">
          <h3>Ubah Biodata Diri</h3>
          <p><strong>Nama:</strong> <?= htmlspecialchars($user['username']); ?></p>
          <p><strong>Tanggal Lahir:</strong>
            <?= !empty($user['tanggal_lahir']) ? htmlspecialchars($user['tanggal_lahir']) : '-'; ?></p>
          <p><strong>Jenis Kelamin:</strong>
            <?= !empty($user['jenis_kelamin']) ? htmlspecialchars($user['jenis_kelamin']) : '-'; ?></p>
        </div>

        <div class="content-section">
          <h3>Ubah Kontak</h3>
          <p><strong>Email:</strong> <?= !empty($user['email']) ? htmlspecialchars($user['email']) : '-'; ?></p>
          <p><strong>Nomor HP: </strong> <?= !empty($user['nomor_hp']) ? htmlspecialchars($user['nomor_hp']) : '-'; ?>
          </p>
        </div>

        <a href="editProfile.php" class="btn btn-warning mt-3">Edit Profil</a>

        <form action="logoutUser.php" method="post">
          <button type="submit" onclick="return confirm('Yakin mau logout?')">Logout</button>
        </form>

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
</body>

</html>