<?php
error_log("product_id = $product_id, rating = $rating, ulasan = $ulasan");
session_start();
require '../functions/koneksi.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  echo "Unauthorized";
  exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
  $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
  $ulasan = trim($_POST['ulasan'] ?? '');

  // Validasi input
  if ($product_id <= 0 || $rating < 1 || $rating > 5 || $ulasan === '') {
    http_response_code(400);
    echo "Input tidak valid.";
    exit;
  }

  // Cek apakah user sudah pernah beri ulasan untuk produk ini
  $cek = $conn->prepare("SELECT id FROM ulasan_pelanggan WHERE user_id = ? AND product_id = ?");
  $cek->bind_param("ii", $user_id, $product_id);
  $cek->execute();
  $cek_result = $cek->get_result();

  if ($cek_result->num_rows > 0) {
    http_response_code(409);
    echo "Kamu sudah pernah mengulas produk ini.";
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO ulasan_pelanggan (user_id, product_id, rating, ulasan, waktu) VALUES (?, ?, ?, ?, NOW())");
  $stmt->bind_param("iiis", $user_id, $product_id, $rating, $ulasan);

  if ($stmt->execute()) {
    echo "sukses";
  } else {
    http_response_code(500);
    echo "Gagal menyimpan ulasan.";
  }
} else {
  http_response_code(405);
  echo "Method tidak diizinkan.";
}
?>
