<?php
require '../functions/function.php';

$id = $_GET["id"];
$dataProduk = query("SELECT * FROM produk WHERE id = $id")[0];

if (isset($_POST["submit"])) {
    if (editProduk($_POST, $_FILES) > 0) {
        echo "<script>
                alert('Data berhasil diedit!');
                document.location.href='penjualan.php';
              </script>";
    } else {
        echo "<script>alert('Data gagal diedit!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../asstes/edit.css" />
</head>
<body>
    <main>
        <div class="container">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $dataProduk["id"]; ?>">
                <div>
                    <p>Gambar Produk:</p>
                    <input type="file" name="gambar" required value="<?= $dataProduk["gambar"]; ?>" />
                </div>
                <div>
                    <p>Nama Produk:</p>
                    <input type="text" name="nama_produk" required value="<?= $dataProduk["nama_produk"]; ?>" />
                </div>

                <div>
                    <p>Harga:</p>
                    <input type="number" name="harga" required value="<?= $dataProduk["harga"]; ?>" />
                </div>

                <div>
                    <p>Material:</p>
                    <input type="text" name="material" required value="<?= $dataProduk["material"]; ?>" />
                </div>

                <div>
                    <p>Proses:</p>
                    <input type="text" name="proses" required value="<?= $dataProduk["proses"]; ?>" />
                </div>

                <div>
                    <p>SKU:</p>
                    <input type="text" name="sku" required value="<?= $dataProduk["sku"]; ?>" />
                </div>

                <div>
                    <p>Tags:</p>
                    <input type="text" name="tags" required value="<?= $dataProduk["tags"]; ?>" />
                </div>

                <div>
                    <p>Stok:</p>
                    <input type="number" name="stok" value="<?= $dataProduk["stok"]; ?>">
                </div>

                <div>
                    <p>Kategori:</p>
                    <select name="kategori" required>
                        <option value="pria" <?= $dataProduk["kategori"] == "pria" ? "selected" : "" ?>>Pria</option>
                        <option value="wanita" <?= $dataProduk["kategori"] == "wanita" ? "selected" : "" ?>>Wanita</option>
                        <option value="anak_anak" <?= $dataProduk["kategori"] == "anak_anak" ? "selected" : "" ?>>Anak-anak</option>
                    </select>
                </div>

                <div>
                    <p>Jenis Lengan:</p>
                    <select name="jenis_lengan" required>
                        <option value="panjang" <?= $dataProduk["jenis_lengan"] == "panjang" ? "selected" : "" ?>>Panjang</option>
                        <option value="pendek" <?= $dataProduk["jenis_lengan"] == "pendek" ? "selected" : "" ?>>Pendek</option>
                    </select>
                </div>

                <button type="submit" name="submit">Simpan Perubahan</button>
            </form>
        </div>
    </main>
</body>
</html>
