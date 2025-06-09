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
  <style>
    .star-rating i {
      font-size: 24px;
      cursor: pointer;
      color: gray;
    }
    .star-rating .selected {
      color: orange;
    }
  </style>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="riwayatModalLabel">Riwayat Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $q = $conn->query("SELECT ci.product_id, p.nama_produk, p.gambar,
          (SELECT rating FROM ulasan_pelanggan WHERE user_id = $id AND product_id = ci.product_id) AS user_rating,
          (SELECT deskripsi FROM ulasan_pelanggan WHERE user_id = $id AND product_id = ci.product_id) AS user_ulasan
          FROM checkout_items ci
          JOIN produk p ON ci.product_id = p.id
          JOIN checkout c ON ci.checkout_id = c.id
          WHERE c.user_id = $id
          GROUP BY ci.product_id
          ORDER BY c.created_at DESC");
        while ($row = $q->fetch_assoc()):
          $sudahUlasan = !is_null($row['user_rating']);
        ?>
        <div class="d-flex align-items-center justify-content-between mb-3 p-2" style="background:#f5f5f5; border-radius:6px;">
          <div class="d-flex align-items-center">
            <img src="../asstes/img/<?= $row['gambar'] ?>" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
            <div><?= $row['nama_produk'] ?></div>
          </div>
          <?php if ($sudahUlasan): ?>
            <button 
              class="btn btn-secondary lihat-ulasan-btn"
              data-bs-toggle="modal"
              data-bs-target="#lihatUlasanModal"
              data-produk="<?= htmlspecialchars($row['nama_produk']) ?>"
              data-rating="<?= $row['user_rating'] ?>"
              data-ulasan="<?= htmlspecialchars($row['user_ulasan']) ?>">
              Lihat Ulasan
            </button>
          <?php else: ?>
            <button 
              class="btn btn-warning beri-ulasan-btn" 
              data-bs-toggle="modal" 
              data-bs-target="#ulasanModal"
              data-produk="<?= htmlspecialchars($row['nama_produk']) ?>"
              data-produkid="<?= $row['product_id'] ?>">
              Beri Ulasan
            </button>
          <?php endif; ?>
        </div>
        <?php endwhile; ?>
        <div id="ulasanSuccessMsg" class="alert alert-success d-none mt-2">
          Ulasan berhasil dikirim!
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ulasan Pelanggan -->
<div class="modal fade" id="ulasanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formUlasan">
        <div class="modal-header">
          <h5 class="modal-title">Beri Ulasan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="product_id" id="ulasanProductId">
          <div class="mb-3 text-center">
            <h6 id="ulasanNamaProduk">Nama Produk</h6>
          </div>
          <div class="mb-3">
            <label class="form-label">Beri Rating:</label><br>
            <div class="star-rating">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fa fa-star" data-value="<?= $i ?>"></i>
              <?php endfor; ?>
            </div>
            <input type="hidden" name="rating" id="ratingValue" required>
          </div>
          <div class="mb-3">
            <label for="ulasan">Deskripsi Ulasan:</label>
            <textarea name="ulasan" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Lihat Ulasan -->
<div class="modal fade" id="lihatUlasanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ulasan Kamu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="lihatNamaProduk">Nama Produk</h6>
        <div class="mb-2" id="lihatRating"></div>
        <p id="lihatDeskripsi"></p>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star-rating i');
    stars.forEach(star => {
      star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        document.getElementById('ratingValue').value = value;
        stars.forEach(s => s.classList.remove('selected'));
        for (let i = 0; i < value; i++) stars[i].classList.add('selected');
      });
    });

    document.querySelectorAll('.beri-ulasan-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const nama = btn.getAttribute('data-produk');
        const id = btn.getAttribute('data-produkid');
        document.getElementById('ulasanNamaProduk').textContent = nama;
        document.getElementById('ulasanProductId').value = id;
        document.getElementById('ratingValue').value = '';
        stars.forEach(s => s.classList.remove('selected'));
      });
    });

    document.querySelectorAll('.lihat-ulasan-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const nama = btn.getAttribute('data-produk');
        const rating = parseInt(btn.getAttribute('data-rating'));
        const ulasan = btn.getAttribute('data-ulasan');

        document.getElementById('lihatNamaProduk').textContent = nama;

        const ratingContainer = document.getElementById('lihatRating');
        ratingContainer.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
          const star = document.createElement('i');
          star.className = 'fa fa-star' + (i <= rating ? ' text-warning' : ' text-secondary');
          ratingContainer.appendChild(star);
        }

        document.getElementById('lihatDeskripsi').textContent = ulasan;
      });
    });

    document.getElementById('formUlasan').addEventListener('submit', function (e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);

      fetch('../functions/simpan_ulasan.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.text())
        .then(result => {
          if (result.trim() === 'sukses') {
            bootstrap.Modal.getInstance(document.getElementById('ulasanModal')).hide();
            const successMsg = document.getElementById('ulasanSuccessMsg');
            successMsg.classList.remove('d-none');
            successMsg.textContent = 'Ulasan berhasil dikirim!';
            form.reset();
            stars.forEach(s => s.classList.remove('selected'));
            setTimeout(() => {
              successMsg.classList.add('d-none');
            }, 4000);
          } else {
            alert(result);
          }
        })
        .catch(err => {
          console.error('Error:', err);
          alert('Gagal mengirim ulasan.');
        });
    });
  });
</script>

<?php require '../asstes/header-footer/footer.php'; ?>
</body>
</html>
