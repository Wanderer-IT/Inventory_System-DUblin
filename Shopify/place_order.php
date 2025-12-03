<?php
session_start();
include 'database.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Checkout - My Sari-Sari Store</title>
      <link rel='stylesheet' href='product.css'>
    </head>
    <body>
    <div class='container'>
      <nav class='nav'>
        <div class='nav-logo'><h1>My Sari-Sari Store</h1></div>
        <div class='nav-links'>
          <a href='index.php'>Home</a>
          <a href='product.php'>Shop</a>
          <a href='checkout.php'>Check Out</a>
            <a href='view_orders.php'>View Orders</a>
        </div>
      </nav>
      <h2>Your cart is empty.</h2>
      <a href='product.php' class='btn'>Go back to shop</a>
    </div>
    </body>
    </html>";
    exit;
}

$orderDate = date("Y-m-d H:i:s");
$total = 0;

// Calculate total
foreach ($_SESSION['cart'] as $productID => $quantity) {
    $stmt = $conn->prepare("SELECT productPrice FROM product WHERE productID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $total += $row['productPrice'] * $quantity;
    }
}

$stmt = $conn->prepare("INSERT INTO orders (orderDate, totalAmount) VALUES (?, ?)");
$stmt->bind_param("sd", $orderDate, $total);

if ($stmt->execute()) {
    $ordersID = $stmt->insert_id;

    foreach ($_SESSION['cart'] as $productID => $quantity) {
        $stmtProduct = $conn->prepare("SELECT productPrice FROM product WHERE productID = ?");
        $stmtProduct->bind_param("i", $productID);
        $stmtProduct->execute();
        $resultProduct = $stmtProduct->get_result();
        $product = $resultProduct->fetch_assoc();
        $price = $product['productPrice'];

        $stmtItem = $conn->prepare("INSERT INTO order_items (OrderQuantity, price, ordersID, productID) VALUES (?, ?, ?, ?)");
        $stmtItem->bind_param("idii", $quantity, $price, $ordersID, $productID);
        $stmtItem->execute();

        $stmtUpdate = $conn->prepare("UPDATE product SET productQuantity = productQuantity - ? WHERE productID = ?");
        $stmtUpdate->bind_param("ii", $quantity, $productID);
        $stmtUpdate->execute();
    }

    unset($_SESSION['cart']);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Order Confirmation</title>
      <link rel='stylesheet' href='place_order.css'>
    </head>
    <body>
    <div class='container'>
      <nav class='nav'>
        <div class='nav-logo'><h1>My Sari-Sari Store</h1></div>
        <div class='nav-links'>
          <a href='index.php'>Home</a>
          <a href='product.php'>Shop</a>
          <a href='checkout.php'>Check Out</a>
        </div>
      </nav>
      <div class='confirmation'>
        <h2>Order placed successfully!</h2>
        <p>Your order ID is <strong>$ordersID</strong>.</p>
        <p>Total Amount: <strong>₱$total</strong></p>
        <a href='product.php' class='btn-back'>Continue Shopping</a>
      </div>
    </div>
    </body>
    </html>";

} else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Order Error</title>
      <link rel='stylesheet' href='product.css'>
    </head>
    <body>
    <div class='container'>
      <nav class='nav'>
        <div class='nav-logo'><h1>My Sari-Sari Store</h1></div>
        <div class='nav-links'>
          <a href='index.php'>Home</a>
          <a href='product.php'>Shop</a>
          <a href='checkout.php'>Check Out</a>
        </div>
      </nav>
      <h2>Error placing order</h2>
      <p>" . $stmt->error . "</p>
      <a href='checkout.php' class='btn-back'>Try Again</a>
    </div>
    </body>
    </html>";
}
?>
