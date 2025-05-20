<?php
session_start();
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login($_POST)) {
        // Redirect kalau login berhasil
        header("Location: index.php"); 
        exit;
    } else {
        // Login gagal, kembali ke login
        echo "<script>
            alert('Username atau Password salah!');
            window.location.href = 'halamanlogin2.php';
        </script>";
    }
} else {
    header("Location: halamanlogin2.php");
    exit;
}
?>