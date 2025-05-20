<?php
require 'functions/function.php';

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $question = $_POST['secret_question'];
    $answer   = htmlspecialchars($_POST['secret_answer']);
    $newPass  = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Cek ke database
    $query = "SELECT * FROM users 
              WHERE username = '$username' 
              AND secret_question = '$question' 
              AND secret_answer = '$answer'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Update password
        $update = mysqli_query($conn, "UPDATE users SET password = '$newPass' WHERE username = '$username'");
        if ($update) {
            echo "<script>alert('Password berhasil diubah!'); window.location.href='halamanlogin2.php';</script>";
        } else {
            echo "<script>alert('Gagal mengubah password!');</script>";
        }
    } else {
        echo "<script>alert('Data tidak cocok!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot</title>
    <link rel="stylesheet" href="asstes/css/reset.css" />
  </head>
  <div class="wrapper">
  <h2>Reset Password</h2>
<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Pertanyaan Rahasia:</label><br>
    <select name="secret_question" required>
        <option value="">-- Pilih Pertanyaan --</option>
        <option value="makanan">Apa makanan favoritmu?</option>
        <option value="hewan">Apa hewan peliharaan pertamamu?</option>
        <option value="hobi">Apa hobimu?</option>
    </select><br><br>

    <label>Jawaban:</label><br>
    <input type="text" name="secret_answer" required><br><br>

    <label>Password Baru:</label><br>
    <input type="password" name="new_password" required><br><br>

    <button type="submit" name="submit">Reset Password</button>
</form>
