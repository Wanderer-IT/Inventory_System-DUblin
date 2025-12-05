<?php
session_start();
include 'database.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='product.php'>Go back to shop</a></p>";
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - My Sari-Sari Store</title>
<link rel="stylesheet" href="cheakout.css">
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
      <a href="cheakout.php">Check Out</a>
      <a href="view_orders.php">View Orders</a>
      <a href="about.php">About Me</a>
    </div>
  </nav>

  <h1>Your Cart</h1>

  <table class="checkout-table">
    <tr>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Subtotal</th>
      <th>Action</th>
    </tr>

    <?php
    foreach ($_SESSION['cart'] as $productID => $quantity) {
        $stmt = $conn->prepare("SELECT * FROM product WHERE productID = ?");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $subtotal = $product['productPrice'] * $quantity;
            $total += $subtotal;

            echo "<tr>
                    <td>{$product['productName']}</td>
                    <td>₱{$product['productPrice']}</td>
                    <td>{$quantity}</td>
                    <td>₱{$subtotal}</td>
                    <td>
                      <form method='POST' action='remove_from_cart.php'>
                        <input type='hidden' name='productID' value='{$productID}'>
                        <button type='submit' class='btn-delete'>Remove</button>
                      </form>
                    </td>
                  </tr>";
        }
    }
    ?>

    <tr>
      <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
      <td colspan="2"><strong>₱<?php echo $total; ?></strong></td>
    </tr>
  </table>

  <form method="POST" action="place_order.php">
    <button type="submit" class="btn-checkout">Place Order</button>
  </form>

</div>

</body>
</html>
