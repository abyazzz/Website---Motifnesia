<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: halamanlogin2.php");
  exit;
}

require '../functions/function.php';
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
  <link rel="stylesheet" href="../asstes/css/profileUser.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
  <link rel="stylesheet" href="../asstes/css/header.css">
  <link rel="stylesheet" href="../asstes/css/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php require '../asstes/header-footer/header.php'; ?>

<div class="container">
  <div class="sidebar">
    <div class="profile-info">
      <?php if (!empty($user['foto'])): ?>
        <img src="../asstes/uploads/<?= htmlspecialchars($user['foto']); ?>" alt="Profile Picture" class="profile-picture" />
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
      <div class="tab active">Biodata Diri</div>
    </div>
    <div class="content">
      <div class="content-section">
        <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($user['nama_lengkap']); ?></p>
        <p><strong>Tanggal Lahir:</strong> <?= !empty($user['tanggal_lahir']) ? htmlspecialchars($user['tanggal_lahir']) : '-'; ?></p>
        <p><strong>Jenis Kelamin:</strong> <?= !empty($user['jenis_kelamin']) ? htmlspecialchars($user['jenis_kelamin']) : '-'; ?></p>
      </div>

      <div class="content-section">
        <h3>Kontak</h3>
        <p><strong>Email:</strong> <?= !empty($user['email']) ? htmlspecialchars($user['email']) : '-'; ?></p>
        <p><strong>Nomor HP:</strong> <?= !empty($user['nomor_hp']) ? htmlspecialchars($user['nomor_hp']) : '-'; ?></p>
      </div>

      <a href="editProfile.php" class="btn btn-warning mt-3">Edit Profil</a>
      <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#riwayatModal">Riwayat Pembelian</button>

      <form action="../functions/logoutUser.php" method="post">
        <button class="btn btn-danger mt-3" type="submit" onclick="return confirm('Yakin mau logout?')">Logout</button>
      </form>
    </div>
  </div>
</div>

<!-- Modal Riwayat Pembelian -->
<div class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="riwayatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="riwayatModalLabel">Riwayat Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $q = $conn->query("SELECT p.nama_produk, p.gambar FROM checkout_items ci
          JOIN produk p ON ci.product_id = p.id
          JOIN checkout c ON ci.checkout_id = c.id
          WHERE c.user_id = $id
          ORDER BY c.created_at DESC");
        while ($row = $q->fetch_assoc()): ?>
          <div class="d-flex align-items-center mb-3" style="background:#f5f5f5; padding: 10px; border-radius: 6px;">
            <img src="../asstes/img/<?= $row['gambar'] ?>" alt="gambar produk" style="width: 50px; height: 50px; object-fit:cover; margin-right: 10px;">
            <div><?= $row['nama_produk'] ?></div>
            <a href="" class="btn btn-warning mt-3">Beri Ulasan</a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>

<?php require '../asstes/header-footer/footer.php'; ?>
</body>

</html>