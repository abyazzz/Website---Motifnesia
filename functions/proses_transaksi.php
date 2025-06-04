<?php
session_start();
require '../functions/koneksi.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['checkout_data'])) {
    http_response_code(400);
    echo 'Session tidak valid';
    exit;
}

$data = $_SESSION['checkout_data'];
$user_id = $_SESSION['user_id'];
$status_id = 1;

// Insert ke tabel checkout
$stmt = $conn->prepare("INSERT INTO checkout (user_id, alamat, pengiriman, pembayaran, total_harga, ongkir, total_bayar, status_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssdddi", $user_id, $data['alamat'], $data['pengiriman'], $data['pembayaran'], $data['total_harga'], $data['ongkir'], $data['total_bayar'], $status_id);
$stmt->execute();
$checkout_id = $stmt->insert_id;

// Insert ke tabel checkout_items dan hapus dari keranjang
for ($i = 0; $i < count($data['produk_id']); $i++) {
    $subtotal = $data['harga'][$i] * $data['qty'][$i];

    $stmt_item = $conn->prepare("INSERT INTO checkout_items (checkout_id, product_id, ukuran, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_item->bind_param("iisidd", $checkout_id, $data['produk_id'][$i], $data['ukuran'][$i], $data['qty'][$i], $data['harga'][$i], $subtotal);
    $stmt_item->execute();

    $del = $conn->prepare("DELETE FROM keranjang WHERE user_id = ? AND product_id = ? AND ukuran = ?");
    $del->bind_param("iis", $user_id, $data['produk_id'][$i], $data['ukuran'][$i]);
    $del->execute();
}

// Catat status awal ke status_log
$stmt_log = $conn->prepare("INSERT INTO status_log (checkout_id, status_id, waktu) VALUES (?, ?, NOW())");
$stmt_log->bind_param("ii", $checkout_id, $status_id);
$stmt_log->execute();

// Simpan checkout_id ke session
$_SESSION['checkout_id'] = $checkout_id;

echo 'sukses';
?>