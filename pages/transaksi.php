<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../asstes/header-footer/header.php';

if (!isset($_SESSION['checkout_id']) || !isset($_SESSION['waktu_transaksi'])) {
    header("Location: checkOut.php");
    exit;
}

$waktuTransaksi = strtotime($_SESSION['waktu_transaksi']);
$tanggal = date("d M Y, H:i", $waktuTransaksi);
$deadline = $waktuTransaksi + (24 * 60 * 60); // +24 jam
$nomorPembayaran = trim((string)$_SESSION['nomor_pembayaran']);
$totalTagihan = $_SESSION['total_tagihan'];
$metode = $_SESSION['metode_pembayaran'];

$labelMetode = match($metode) {
    'mandiri' => 'Mandiri Virtual Account',
    'bca' => 'BCA Virtual Account',
    'gopay' => 'GoPay',
    'cod' => 'Bayar di Tempat (COD)',
    default => 'Metode Tidak Dikenal',
};
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    .modal h2 {
      color: green;
    }
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
      <p><strong>Total Tagihan:</strong><br>Rp. <?= number_format($totalTagihan, 0, ',', '.') ?></p>
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
    <button onclick="window.location.href='../index.php'">Tutup</button>
  </div>
</div>

<?php require '../asstes/header-footer/footer.php'; ?>

<script>
// Countdown
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

// Validasi nomor pembayaran
document.getElementById("btnBayar").addEventListener("click", function () {
  const input = document.getElementById("inputNomor").value.trim();
  const benar = "<?= $nomorPembayaran ?>".trim();
  if (input === benar) {
    document.getElementById("modalSuccess").style.display = "flex";

    // Tambahkan AJAX call kalau mau simpan notifikasi ke DB
    // contoh: fetch('notifikasi_konfirmasi.php?checkout_id=<?= $_SESSION['checkout_id'] ?>')
  } else {
    alert("Nomor pembayaran tidak valid.");
  }
});
</script>

</body>
</html>
