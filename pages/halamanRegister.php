<?php
require '../functions/function.php';

if (isset($_POST["register"])) {
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  // Validasi panjang password
  if (strlen($password) < 6) {
    echo "<script>alert('Password minimal 6 karakter!');</script>";
  } elseif ($password !== $confirm_password) {
    echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
  } elseif (register($_POST) > 0) {
    echo "<script>
            alert('Registrasi berhasil!');
            window.location.href = 'halamanlogin2.php';
          </script>";
  } else {
    echo "<script>alert('Registrasi gagal!');</script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="../asstes/css/halamanRegister.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    <h1>Sign Up</h1>

    <!-- FORM MULAI DI SINI -->
    <form action="" method="POST">
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required />
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required />
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required />
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="confirm_password" required />
      </div>
      <select class="input-box" name="secret_question" required>
        <option value="">-- Pilih Pertanyaan Rahasia --</option>
        <option value="makanan">Apa makanan favoritmu?</option>
        <option value="hewan">Apa hewan peliharaan pertamamu?</option>
        <option value="hobi">Apa hobimu?</option>
      </select><br><br>
      <div class="input-box">
        <input type="text" name="secret_answer" placeholder="Jawaban" required><br><br>
        <button class="btn" type="submit" name="register">Sign Up</button>
      </div>  
    </form>

    <p class="texxx">Sign Up With</p>
    <div class="icon-app">
      <a href="#"><i class="fa-brands fa-google"></i></a>
      <a href="#"><i class="fa-brands fa-facebook"></i></a>
      <a href="#"><i class="fa-brands fa-github"></i></a>
    </div>
  </div>
  <script>
  const form = document.querySelector("form");
  form.addEventListener("submit", function(e) {
    const pw = document.getElementById("password").value;
    const cpw = document.getElementById("confirm_password").value;

    if (pw.length < 6) {
      alert("Password minimal 6 karakter!");
      e.preventDefault();
    } else if (pw !== cpw) {
      alert("Konfirmasi password tidak cocok!");
      e.preventDefault();
    }
  });
</script>
</body>

</html>