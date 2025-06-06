<?php
require '../functions/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkout_id = $_POST['checkout_id'];
    $status_id = $_POST['status_id'];
    $user_id = $_POST['user_id'];
    $nama_produk = $_POST['nama_produk'];
    $ukuran = $_POST['ukuran'];
    $harga = $_POST['harga'];

    $update = $conn->prepare("UPDATE checkout SET status_id = ? WHERE id = ?");
    $update->bind_param("ii", $status_id, $checkout_id);
    $update->execute();

    $insert_log = $conn->prepare("INSERT INTO status_log (checkout_id, status_id, waktu) VALUES (?, ?, NOW())");
    $insert_log->bind_param("ii", $checkout_id, $status_id);
    $insert_log->execute();

    $query_status = $conn->query("SELECT nama_status FROM status_transaksi WHERE id = $status_id");
    $nama_status = $query_status->fetch_assoc()['nama_status'];

    $judul = "📦 Pesanan kamu $nama_status.";
    $deskripsi = "Pesanan untuk produk sedang $nama_status.";

    $stmt = $conn->prepare("INSERT INTO notifikasi (user_id, judul, deskripsi, waktu, checkout_id) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("issi", $user_id, $judul, $deskripsi, $checkout_id);
    $stmt->execute();

    header("Location: status.php");
    exit;
}
?>
