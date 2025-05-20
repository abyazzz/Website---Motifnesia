<?php
session_start();
require 'functionFavorit.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id'])) {
    header("Location: ../pages/halamanlogin2.php");
    exit;
}

$product_id = $_POST['product_id'];
hapusFavorit($product_id);

header("Location: ../pages/favorit.php");
exit;
?>