<?php
include 'database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID missing.");
}

$stmt = $conn->prepare("SELECT productPhoto FROM product WHERE productID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();


if (!empty($product['productPhoto']) && file_exists($product['productPhoto'])) {
    unlink($product['productPhoto']);
}


$stmtDeleteItems = $conn->prepare("DELETE FROM order_items WHERE productID = ?");
$stmtDeleteItems->bind_param("i", $id);
$stmtDeleteItems->execute();

$stmt = $conn->prepare("DELETE FROM product WHERE productID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: product.php");
    exit();
} else {
    echo "Error deleting product: " . $stmt->error;
}
?>
