<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../functions/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: halamanlogin2.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil semua data dari form transaksi
$alamat = $_POST['alamat'];
$pengiriman = $_POST['pengiriman'];
$pembayaran = $_POST['pembayaran'];
$total_harga = $_POST['total_harga'];
$ongkir = $_POST['ongkir'];
$total_bayar = $_POST['total_bayar'];
 
$produk_id = $_POST['produk_id'];
$ukuran = $_POST['ukuran'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];

// Tentukan status awal (pending = 1)
$status_id = 1;

// Insert ke tabel checkout
$stmt = $conn->prepare("INSERT INTO checkout (user_id, alamat, pengiriman, pembayaran, total_harga, ongkir, total_bayar, status_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssdddi", $user_id, $alamat, $pengiriman, $pembayaran, $total_harga, $ongkir, $total_bayar, $status_id);
$stmt->execute();

// Ambil ID transaksi terakhir
$checkout_id = $stmt->insert_id;

// Simpan produk-produk ke tabel checkout_items
for ($i = 0; $i < count($produk_id); $i++) {
    $subtotal = $harga[$i] * $qty[$i];
    $stmt_item = $conn->prepare("INSERT INTO checkout_items (checkout_id, product_id, ukuran, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_item->bind_param("iisidd", $checkout_id, $produk_id[$i], $ukuran[$i], $qty[$i], $harga[$i], $subtotal);
    $stmt_item->execute();

    // Hapus dari keranjang setelah dibayar
    $del = $conn->prepare("DELETE FROM keranjang WHERE user_id = ? AND product_id = ? AND ukuran = ?");
    $del->bind_param("iis", $user_id, $produk_id[$i], $ukuran[$i]);
    $del->execute();
}

// Tambah ke status_log
$stmt_log = $conn->prepare("INSERT INTO status_log (checkout_id, status_id) VALUES (?, ?)");
$stmt_log->bind_param("ii", $checkout_id, $status_id);
$stmt_log->execute();

// Simpan data ke sesi untuk transaksi.php
$_SESSION['checkout_id'] = $checkout_id;
$_SESSION['waktu_transaksi'] = date("Y-m-d H:i:s");
$_SESSION['nomor_pembayaran'] = match($pembayaran) {
    'mandiri' => '00384394',
    'bca' => '00129832',
    'gopay' => '085777xxxxxx',
    'cod' => 'BAYAR DI TEMPAT',
    default => '00000000',
};
$_SESSION['total_tagihan'] = $total_bayar;
$_SESSION['metode_pembayaran'] = $pembayaran;

// Redirect ke transaksi.php
header("Location: ../pages/transaksi.php");
exit;
?>