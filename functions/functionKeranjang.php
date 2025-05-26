<?php
// HAPUS session_start() di sini karena sudah dipanggil di keranjang.php
    require 'koneksi.php';

    // Tambah produk ke keranjang
    function tambahKeKeranjang($product_id, $ukuran) {
    global $conn;
    $user_id = $_SESSION['user_id'];

    // Cek apakah produk + ukuran sudah ada
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

    // Fungsi ini TIDAK DIUBAH karena sudah benar
    function getIsiKeranjang() {
        global $conn;
        $user_id = $_SESSION['user_id'];
        
        $query = "SELECT k.*, p.nama_produk, p.harga, p.gambar
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

    // Hapus produk dari keranjang
    function hapusDariKeranjang($product_id) {
        global $conn;
        $user_id = $_SESSION['user_id'];

        $conn->query("DELETE FROM keranjang WHERE user_id = $user_id AND product_id = $product_id");
    }

    // Update jumlah qty produk
    function updateQty($product_id, $qty) {
        global $conn;
        $user_id = $_SESSION['user_id'];

        if ($qty <= 0) {
            hapusDariKeranjang($product_id);
        } else {
            $conn->query("UPDATE keranjang 
                            SET qty = $qty, updated_at = NOW() 
                            WHERE user_id = $user_id AND product_id = $product_id");
    }
}