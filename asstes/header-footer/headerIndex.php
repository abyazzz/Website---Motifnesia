<?php
require './functions/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM konten_statis LIMIT 1");
$konten = mysqli_fetch_assoc($query);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="asstes/css/header.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <header>
         <div class="logo">
            <?php if (!empty($konten['logo'])): ?>
            <img src="<?= $konten['logo'] ?>" alt="Logo" style="height: 40px;">

            <?php else: ?>
            MotifNesia
            <?php endif; ?>
        </div>
        <nav class="huhu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="pages/aboutUs.php">About Us</a></li>
                <li><a href="pages/notifikasi.php">Notif</a></li>
                <li><a href="pages/keranjang.php"><i class="<?= $konten['keranjang'] ?>"></i></a></li>
                <li><a href="pages/favorit.php"><i class="<?= $konten['favorit'] ?>"></i></a></li>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="./pages/profileUser.php">
                            <img src="../uploads/<?= $_SESSION['profile_picture'] ?? 'default.jpg'; ?>" alt="Profile" class="profile-img">
                        </a>
                    <?php else: ?>
                        <a class="btn-login" href="./pages/halamanlogin2.php"><button>Login</button></a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </header>
</body>

</html>