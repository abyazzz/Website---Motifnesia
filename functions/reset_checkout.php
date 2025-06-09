<?php
session_start();

// Hapus semua data transaksi biar user bisa transaksi ulang
unset($_SESSION['checkout_data']);
unset($_SESSION['checkout_id']);
unset($_SESSION['waktu_transaksi']);
unset($_SESSION['total_tagihan']);
unset($_SESSION['metode_pembayaran']);
unset($_SESSION['metode_pengiriman']);
unset($_SESSION['nomor_pembayaran']);

echo 'done';
