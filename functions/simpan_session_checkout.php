<?php
session_start();

header("Content-Type: application/json");
$input = json_decode(file_get_contents('php://input'), true);

$_SESSION['checkout_data'] = $input;
?>
