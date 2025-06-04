<?php
require 'koneksi.php';

if (!isset($_GET['checkout_id'])) {
    echo "ID tidak valid.";
    exit;
}

$checkout_id = (int) $_GET['checkout_id'];

// Ambil data checkout
$stmt = $conn->prepare("SELECT c.alamat, c.total_bayar, c.pengiriman, c.pembayaran FROM checkout c WHERE c.id = ?");
$stmt->bind_param("i", $checkout_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

// Konversi pengiriman dan ongkir
$labelPengiriman = match($data['pengiriman']) {
    'reguler' => 'Reguler (Rp15.000)',
    'ekspres' => 'Ekspres (Rp20.000)',
    'ekonomis' => 'Ekonomis (Rp10.000)',
    default => 'Tidak diketahui',
};

$labelPembayaran = match($data['pembayaran']) {
    'mandiri' => 'Mandiri Virtual Account',
    'bca' => 'BCA Virtual Account',
    'gopay' => 'GoPay',
    'cod' => 'Bayar di Tempat (COD)',
    default => 'Tidak diketahui',
};

// Ambil data produk
$stmtItems = $conn->prepare("SELECT ci.qty, ci.ukuran, ci.harga_satuan, p.nama_produk FROM checkout_items ci JOIN produk p ON ci.product_id = p.id WHERE ci.checkout_id = ?");
$stmtItems->bind_param("i", $checkout_id);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();

echo "<ul style='padding-left: 1.2em;'>";
while ($item = $resultItems->fetch_assoc()) {
    echo "<li>{$item['nama_produk']} (Uk: {$item['ukuran']}) × {$item['qty']} - Rp " . number_format($item['harga_satuan'], 0, ',', '.') . "</li>";
}
echo "</ul>";

echo "<p><strong>Metode Pembayaran:</strong> {$labelPembayaran}</p>";
echo "<p><strong>Metode Pengiriman:</strong> {$labelPengiriman}</p>";
echo "<p><strong>Total Bayar:</strong> Rp " . number_format($data['total_bayar'], 0, ',', '.') . "</p>";
