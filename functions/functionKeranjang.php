<?php
require 'koneksi.php';

function tambahKeKeranjang($product_id, $ukuran) {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $cek = $conn->query("SELECT * FROM keranjang 
                         WHERE user_id = $user_id AND product_id = $product_id AND ukuran = '$ukuran'");

    if ($cek->num_rows > 0) {
        $conn->query("UPDATE keranjang 
                      SET qty = qty + 1, updated_at = NOW() 
                      WHERE user_id = $user_id AND product_id = $product_id AND ukuran = '$ukuran'");
    } else {
        $conn->query("INSERT INTO keranjang (user_id, product_id, ukuran, qty, created_at, updated_at)
                      VALUES ($user_id, $product_id, '$ukuran', 1, NOW(), NOW())");
    }
}

function getIsiKeranjang() {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $query = "SELECT 
                k.*, 
                p.nama_produk, 
                p.harga, 
                p.diskon_persen,
                p.gambar 
              FROM keranjang k
              JOIN produk p ON k.product_id = p.id
              WHERE k.user_id = $user_id";

    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function hapusDariKeranjang($product_id) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $conn->query("DELETE FROM keranjang WHERE user_id = $user_id AND product_id = $product_id");
}

function updateQty($product_id, $ukuran, $delta) {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $res = $conn->query("SELECT qty FROM keranjang 
                         WHERE user_id = $user_id AND product_id = $product_id AND ukuran = '$ukuran'");
    $row = $res->fetch_assoc();
    $qty_sekarang = $row['qty'];

    $qty_baru = $qty_sekarang + $delta;

    if ($qty_baru <= 0) {
        $conn->query("DELETE FROM keranjang 
                      WHERE user_id = $user_id AND product_id = $product_id AND ukuran = '$ukuran'");
    } else {
        $conn->query("UPDATE keranjang 
                      SET qty = $qty_baru, updated_at = NOW() 
                      WHERE user_id = $user_id AND product_id = $product_id AND ukuran = '$ukuran'");
    }
}
