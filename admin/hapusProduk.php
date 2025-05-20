<?php
require '../functions/function.php';

$id = $_GET["id"];

if (hapusProduk($id) > 0) {
    echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'penjualan.php'; 
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = 'penjualan.php';
        </script>
    ";
}
?>