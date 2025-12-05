<?php
session_start();
include 'database.php';

$orderID = $_GET['id'] ?? null;
if (!$orderID) {
  die("Order ID missing.");
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE orderID = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

$stmtItems = $conn->prepare("SELECT oi.OrderQuantity, oi.price, p.productName 
                             FROM order_items oi 
                             JOIN product p ON oi.productID = p.productID 
                             WHERE oi.ordersID = ?");
$stmtItems->bind_param("i", $orderID);
$stmtItems->execute();
$items = $stmtItems->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <link rel="stylesheet" href="order_detail.css">
</head>
<body>

<div class="container">
  <nav class="nav">
    <div class="nav-logo"><h1>My Sari-Sari Store</h1></div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="product.php">Shop</a>
      <a href="checkout.php">Check Out</a>
      <a href="view_orders.php">View Orders</a>
    </div>
  </nav>

  <h1>Order #<?php echo $order['orderID']; ?></h1>
  <p><strong>Date:</strong> <?php echo $order['orderDate']; ?></p>
  <p><strong>Total:</strong> ₱<?php echo $order['totalAmount']; ?></p>

  <table class="checkout-table">
    <tr>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>
    <?php
    while ($item = $items->fetch_assoc()) {
      $subtotal = $item['price'] * $item['OrderQuantity'];
      echo "<tr>
              <td>{$item['productName']}</td>
              <td>₱{$item['price']}</td>
              <td>{$item['OrderQuantity']}</td>
              <td>₱$subtotal</td>
            </tr>";
    }
    ?>
  </table>

  <a href="view_orders.php" class="btn">Back to Orders</a>
</div>

</body>
</html>
