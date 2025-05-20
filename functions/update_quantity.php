<?php
session_start();
require 'functionKeranjang.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'User not logged in']));
}

if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    
    // Ambil quantity saat ini
    global $conn;
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT qty FROM keranjang WHERE user_id = $user_id AND product_id = $product_id");
    
    if ($result->num_rows > 0) {
        $current_qty = $result->fetch_assoc()['qty'];
        
        // Update quantity berdasarkan action
        if ($action == 'increase') {
            $new_qty = $current_qty + 1;
        } else {
            $new_qty = $current_qty - 1;
        }
        
        // Panggil fungsi update quantity
        updateQty($product_id, $new_qty);
        
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found in cart']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>