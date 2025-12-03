<?php
include 'database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID missing.");
}

// Check if product exists
$stmt = $conn->prepare("SELECT productPhoto FROM product WHERE productID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Delete photo file
if (!empty($product['productPhoto']) && file_exists($product['productPhoto'])) {
    unlink($product['productPhoto']);
}

// Delete related order_items
$stmtDeleteItems = $conn->prepare("DELETE FROM order_items WHERE productID = ?");
$stmtDeleteItems->bind_param("i", $id);
$stmtDeleteItems->execute();

// Delete product
$stmt = $conn->prepare("DELETE FROM product WHERE productID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: product.php");
    exit();
} else {
    echo "Error deleting product: " . $stmt->error;
}
?>
