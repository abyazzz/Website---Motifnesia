<?php
require '../functions/function.php';

$id = $_GET["id"];

if (tambahStok($id) > 0) {
    echo "
        <script>
            alert('Stok berhasil ditambah!');
            document.location.href = 'penjualan.php'; 
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal menambah stok!');
            document.location.href = 'penjualan.php';
        </script>
    ";
}
?>