<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../asstes/header-footer/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alamat'])) {
    $_SESSION['checkout_data'] = [
        'alamat' => $_POST['alamat'],
        'pengiriman' => $_POST['pengiriman'],
        'pembayaran' => $_POST['pembayaran'],
        'total_harga' => $_POST['total_harga'],
        'ongkir' => $_POST['ongkir'],
        'total_bayar' => $_POST['total_bayar'],
        'produk_id' => $_POST['produk_id'],
        'ukuran' => $_POST['ukuran'],
        'qty' => $_POST['qty'],
        'harga' => $_POST['harga'],
        'produk_nama' => $_POST['produk_nama'] // ✅ ini yang belum ada sebelumnya
    ];
}

if (!isset($_SESSION['checkout_data'])) {
    header("Location: checkOut.php");
    exit;
}

if (!isset($_SESSION['checkout_id'])) {
    $_SESSION['waktu_transaksi'] = date("Y-m-d H:i:s");
}

$data = $_SESSION['checkout_data'];
$metode = $data['pembayaran'];

$_SESSION['metode_pengiriman'] = $data['pengiriman'];
$_SESSION['metode_pembayaran'] = $data['pembayaran'];

$waktuTransaksi = strtotime($_SESSION['waktu_transaksi']);
$tanggal = date("d M Y, H:i", $waktuTransaksi);
$deadline = $waktuTransaksi + (24 * 60 * 60);
$nomorPembayaran = match($metode) {
    'mandiri' => '00384394',
    'bca' => '00129832',
    'gopay' => '085777xxxxxx',
    'cod' => 'BAYAR DI TEMPAT',
    default => '00000000',
};

$totalTagihan = $_SESSION['total_tagihan'] ?? $_SESSION['checkout_data']['total_bayar'] ?? 0;

$labelMetode = match($metode) {
    'mandiri' => 'Mandiri Virtual Account',
    'bca' => 'BCA Virtual Account',
    'gopay' => 'GoPay',
    'cod' => 'Bayar di Tempat (COD)',
    default => 'Metode Tidak Dikenal',
};

$labelPengiriman = match($data['pengiriman']) {
    'reguler' => 'Reguler (Rp15.000)',
    'ekspres' => 'Ekspres (Rp20.000)',
    'ekonomis' => 'Ekonomis (Rp10.000)',
    default => 'Tidak diketahui',
};
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Halaman Pembayaran</title>
  <link rel="stylesheet" href="../asstes/css/transaksi.css"/>
  <style>
    .modal-bg {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal {
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 300px;
      text-align: center;
    }
    .modal h2 { color: green; }
  </style>
</head>
<body>

<main>
  <div class="card">
    <div class="deadline">
      <div>
        <p>Bayar sebelum</p>
        <span class="tanggal"><?= $tanggal ?></span>
      </div>
      <div class="timer" id="countdown"></div>
    </div>

    <div class="info">
      <p><strong>Nomor metode pembayaran dengan <?= $labelMetode ?>:</strong><br><?= $nomorPembayaran ?></p>
      <p><strong>Total Tagihan:</strong><br>Rp. <?= $totalTagihan ? number_format($totalTagihan, 0, ',', '.') : '-' ?></p>
    </div>

    <div class="input-area">
      <p>Masukan nomor metode pembayaran untuk melakukan pembayaran</p>
      <input type="text" name="nomor_input" id="inputNomor" placeholder="Masukkan nomor">
      <button id="btnBayar">Bayar</button> 
    </div>
  </div>
</main>

<div class="modal-bg" id="modalSuccess">
  <div class="modal">
    <h2>Pembayaran Berhasil!</h2>
    <p>Pembayaran sedang dikonfirmasi admin.</p>
    <div class="produk-list" style="text-align:left; font-size: 14px; margin: 10px 0;"></div>
    <p class="pengiriman">Metode Pengiriman: <?= $labelPengiriman ?></p>
    <p class="metode">Metode Pembayaran: <?= $labelMetode ?></p>
    <p class="total">Total Bayar: Rp <?= number_format($totalTagihan, 0, ',', '.') ?></p>
    <button onclick="resetCheckout()">Tutup</button>
  </div>
</div>

<?php require '../asstes/header-footer/footer.php'; ?>

<script>
const deadline = <?= $deadline ?> * 1000;

function updateCountdown() {
  const now = new Date().getTime(); 
  const diff = deadline - now;
  if (diff <= 0) {
    document.getElementById("countdown").textContent = "00 : 00 : 00";
    return;
  }
  const hours = Math.floor(diff / (1000 * 60 * 60)).toString().padStart(2, "0");
  const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, "0");
  const seconds = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, "0");
  document.getElementById("countdown").textContent = `${hours} : ${minutes} : ${seconds}`;
}
setInterval(updateCountdown, 1000);
updateCountdown();

document.getElementById("btnBayar").addEventListener("click", function () {
  const input = document.getElementById("inputNomor").value.trim();
  const benar = "<?= $nomorPembayaran ?>".trim();

  if (input === benar) {
    fetch("../functions/proses_transaksi.php")
      .then(response => response.json())
      .then(result => {
        if (result.status === "sukses") {
          document.querySelector("#modalSuccess .metode").textContent = result.metode_label;
          document.querySelector("#modalSuccess .pengiriman").textContent = result.pengiriman_label;
          document.querySelector("#modalSuccess .total").textContent = "Rp " + Number(result.total_bayar).toLocaleString("id-ID");

          const daftarProduk = result.produk_dibeli.map(p => `- ${p.nama} (x${p.qty})`).join('<br>');
          document.querySelector("#modalSuccess .produk-list").innerHTML = daftarProduk;

          document.getElementById("modalSuccess").style.display = "flex";
        } else {
          alert("Gagal: " + result.message);
        }
      })
      .catch(err => alert("Gagal terhubung ke server: " + err));
  } else {
    alert("Nomor pembayaran tidak valid.");
  }
});

function resetCheckout() {
  fetch("../functions/reset_checkout.php")
    .then(() => window.location.href = "../index.php");
}
</script>

</body>
</html>
