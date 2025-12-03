<?php
session_start();
include 'database.php';

$sqlOrders = "SELECT * FROM orders ORDER BY orderDate DESC";
$orders = $conn->query($sqlOrders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Orders - My Sari-Sari Store</title>
  <link rel="stylesheet" href="view_orders.css">
</head>
<body>

<div class="container">

  <nav class="nav">
    <div class="nav-logo">
      <h1>My Sari-Sari Store</h1>
    </div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="product.php">Shop</a>
      <a href="checkout.php">Check Out</a>
      <a href="view_orders.php">View Orders</a>
    </div>
  </nav>

  <h1>Order History</h1>

  <?php
  if ($orders->num_rows > 0) {
    echo "<table class='checkout-table'>
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Total Amount</th>
              <th>Details</th>
            </tr>";
    while ($order = $orders->fetch_assoc()) {
      echo "<tr>
              <td>{$order['orderID']}</td>
              <td>{$order['orderDate']}</td>
              <td>₱{$order['totalAmount']}</td>
              <td><a href='order_details.php?id={$order['orderID']}' class='btn'>View Items</a></td>
            </tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No orders found.</p>";
  }
  ?>

</div>

</body>
</html>
