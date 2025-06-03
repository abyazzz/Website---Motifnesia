<?php
session_start();
require '../functions/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: halamanlogin2.php");
    exit;
}

$user_id = $_SESSION['user_id'];
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

$status_id = 1;

$stmt = $conn->prepare("INSERT INTO checkout (user_id, alamat, pengiriman, pembayaran, total_harga, ongkir, total_bayar, status_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssdddi", $user_id, $alamat, $pengiriman, $pembayaran, $total_harga, $ongkir, $total_bayar, $status_id);
$stmt->execute();

$checkout_id = $stmt->insert_id;

for ($i = 0; $i < count($produk_id); $i++) {
    $subtotal = $harga[$i] * $qty[$i];
    $stmt_item = $conn->prepare("INSERT INTO checkout_items (checkout_id, product_id, ukuran, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_item->bind_param("iisidd", $checkout_id, $produk_id[$i], $ukuran[$i], $qty[$i], $harga[$i], $subtotal);
    $stmt_item->execute();

    $del = $conn->prepare("DELETE FROM keranjang WHERE user_id = ? AND product_id = ? AND ukuran = ?");
    $del->bind_param("iis", $user_id, $produk_id[$i], $ukuran[$i]);
    $del->execute();
}

$stmt_log = $conn->prepare("INSERT INTO status_log (checkout_id, status_id, waktu) VALUES (?, ?, NOW())");
$stmt_log->bind_param("ii", $checkout_id, $status_id);
$stmt_log->execute();

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

header("Location: ../pages/transaksi.php");
exit;
?>
