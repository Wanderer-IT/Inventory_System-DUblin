<?php
include 'database.php';

// Fetch customers
$customers = $conn->query("SELECT * FROM customers");

// Fetch products
$products = $conn->query("SELECT * FROM product");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customerID = $_POST['customerID'];
  $orderDate = date("Y-m-d H:i:s");
  $total = 0;

  // Calculate total
  foreach ($_POST['products'] as $productID => $quantity) {
    if ($quantity > 0) {
      $stmt = $conn->prepare("SELECT productPrice FROM product WHERE productID = ?");
      $stmt->bind_param("i", $productID);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $total += $row['productPrice'] * $quantity;
    }
  }

  // Insert order
  $stmt = $conn->prepare("INSERT INTO orders (orderDate, totalAmount, customerID) VALUES (?, ?, ?)");
  $stmt->bind_param("sdi", $orderDate, $total, $customerID);
  $stmt->execute();
  $orderID = $stmt->insert_id;

  // Insert order items
  foreach ($_POST['products'] as $productID => $quantity) {
    if ($quantity > 0) {
      $stmt = $conn->prepare("SELECT productPrice FROM product WHERE productID = ?");
      $stmt->bind_param("i", $productID);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $price = $row['productPrice'];

      $stmtItem = $conn->prepare("INSERT INTO order_items (OrderQuantity, price, ordersID, productID) VALUES (?, ?, ?, ?)");
      $stmtItem->bind_param("idii", $quantity, $price, $orderID, $productID);
      $stmtItem->execute();
    }
  }

  echo "<p class='success'>Order created successfully!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Order</title>
  <link rel="stylesheet" href="product.css">
</head>
<body>
<div class="container">
  <h2>Create New Order</h2>
  <form method="POST" class="add-product-form">
    <label>Customer:</label>
    <select name="customerID" required>
      <?php while ($c = $customers->fetch_assoc()) { ?>
        <option value="<?php echo $c['customerID']; ?>"><?php echo $c['customerName']; ?></option>
      <?php } ?>
    </select>

    <h3>Select Products</h3>
    <?php while ($p = $products->fetch_assoc()) { ?>
      <div>
        <label><?php echo $p['productName']; ?> (₱<?php echo $p['productPrice']; ?>)</label>
        <input type="number" name="products[<?php echo $p['productID']; ?>]" min="0" value="0">
      </div>
    <?php } ?>

    <button type="submit">Place Order</button>
  </form>
</div>
</body>
</html>
