<?php
session_start();

if (!isset($_POST['productID']) || !isset($_POST['quantity'])) {
    header("Location: product.php");
    exit;
}

$productID = $_POST['productID'];
$quantity = $_POST['quantity'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart'][$productID])) {
    $_SESSION['cart'][$productID] = $quantity;
} else {
    $_SESSION['cart'][$productID] += $quantity; 
}

header("Location: cheakout.php");
exit;
?>
