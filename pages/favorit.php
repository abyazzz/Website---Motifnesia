<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../functions/functionFavorit.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../pages/halamanlogin2.php");
    exit;
}

$favorit = getIsiFavorit($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit</title>
    <link rel="stylesheet" href="../asstes/css/favorit.css" />
    <link rel="stylesheet" href="../asstes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="stylesheet" href="../asstes/css/header.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</head>
<body>
    
    <?php require '../asstes/header-footer/header.php'; ?>
    
    <div class="container">
        <main>
            <?php if (empty($favorit)): ?>
                <div class="empty-favorit">
                    <i class="fa-regular fa-heart"></i>
                    <p>Belum ada produk favorit</p>
                </div>
            <?php else: ?>
                <?php foreach ($favorit as $item): ?>
                    <div class="favorit-item">
                        <img src="../asstes/img/<?= $item['gambar'] ?>" alt="<?= $item['nama_produk'] ?>">
                        <div class="product-details">
                            <h3><?= $item['nama_produk'] ?></h3>
                            <p>Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        </div>
                        <form method="post" action="../functions/functionHapusFavorit.php">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn-hapus-favorit">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>

    <?php require '../asstes/header-footer/footer.php'; ?>
    
</body>
</html>