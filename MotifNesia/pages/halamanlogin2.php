<?php
session_start(); // WAJIB ADA DI PALING ATAS

require '../functions/function.php';

if (isset($_POST["login"])) {
    if (login($_POST) > 0) {
        echo "<script>
                alert('Login berhasil!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>alert('Login gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../asstes/css/halamanlogin2.css" />
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="halamanlogin2.php" method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <div class="remember-forget">
                <label><input type="checkbox" name="remember" /> Remember Me</label>
                <p><a href="forgot.php">Lupa Password?</a></p>
            </div>

            <button type="submit" class="btn" name="login">Login</button>
            <div class="register">
                <p>Don't have an account?</p>
                <a href="halamanRegister.php">Register</a>
            </div>
        </form>
    </div>
</body>
</html>
