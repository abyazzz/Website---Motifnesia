
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
        <div class="logo">MotifNesia</div>
        <nav class="huhu">
            <ul>
                <li><a href=".index.php">Home</a></li>
                <li><a href="dasbord.html">About Us</a></li>
                <li><a href="ZZcontact2.html">Contact</a></li>
                <li><a href="ZZlayanankami.html">Service</a></li>
                <li><a href="Website---Motifnesia/pages/keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="../Motifnesia/pages/favorit.php"><i class="fa-regular fa-heart"></i></a></li>
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