<?php
session_start();
require 'functionKeranjang.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'User not logged in']));
}

if (isset($_POST['product_id'], $_POST['ukuran'], $_POST['action'])) {
    $product_id = $_POST['product_id'];
    $ukuran = $_POST['ukuran'];
    $action = $_POST['action'];

    if ($action === 'increase') {
        updateQty($product_id, $ukuran, 1);
    } elseif ($action === 'decrease') {
        updateQty($product_id, $ukuran, -1);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
