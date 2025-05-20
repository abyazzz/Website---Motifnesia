<?php
// HAPUS session_start() di sini karena sudah dipanggil di keranjang.php
    require 'koneksi.php';

    // Tambah produk ke keranjang
    function tambahKeKeranjang($product_id) {
        global $conn;
        $user_id = $_SESSION['user_id'];

        // Cek apakah produk udah ada di keranjang
        $cek = $conn->query("SELECT * FROM keranjang WHERE user_id = $user_id AND product_id = $product_id");

        if ($cek->num_rows > 0) {
            // Kalau udah ada, tambahkan qty
            $conn->query("UPDATE keranjang 
                            SET qty = qty + 1, updated_at = NOW() 
                            WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            // Kalau belum ada, tambahkan entri baru
            $conn->query("INSERT INTO keranjang (user_id, product_id, qty, created_at, updated_at)
                            VALUES ($user_id, $product_id, 1, NOW(), NOW())");
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