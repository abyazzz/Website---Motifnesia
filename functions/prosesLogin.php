<?php
session_start();
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek kalau input tidak kosong
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        if (login($_POST)) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "<script>
                alert('Username atau Password salah!');
                window.location.href = '../pages/halamanlogin2.php';
            </script>";
            exit;
        }
    } else {
        echo "<script>
            alert('Username dan Password tidak boleh kosong!');
            window.location.href = '../pages/halamanlogin2.php';
        </script>";
        exit;
    }
} else {
    header("Location: ../pages/halamanlogin2.php");
    exit;
}
?>
