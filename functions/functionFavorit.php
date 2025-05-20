<?php
require 'koneksi.php';

// Tambah produk ke favorit
function tambahFavorit($product_id) {
    global $conn;
    $user_id = $_SESSION['user_id'];

    // Cek apakah produk sudah ada di favorit
    $cek = $conn->query("SELECT * FROM favorit WHERE user_id = $user_id AND product_id = $product_id");

    if ($cek->num_rows == 0) {
        $conn->query("INSERT INTO favorit (user_id, product_id) VALUES ($user_id, $product_id)");
        return true;
    }
    return false;
}

// Hapus produk dari favorit
function hapusFavorit($product_id) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $conn->query("DELETE FROM favorit WHERE user_id = $user_id AND product_id = $product_id");
}

// Ambil semua favorit user
function getIsiFavorit($user_id) {
    global $conn;
    
    $query = "SELECT p.*, f.id as fav_id 
              FROM favorit f
              JOIN produk p ON f.product_id = p.id
              WHERE f.user_id = $user_id";
              
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Cek apakah produk sudah difavoritkan
function isFavorit($product_id) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT * FROM favorit WHERE user_id = $user_id AND product_id = $product_id");
    return ($result->num_rows > 0);
}
?>