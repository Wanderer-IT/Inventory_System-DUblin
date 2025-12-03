<?php
include 'database.php';

// Fetch categories
$sqlCategories = "SELECT * FROM category ORDER BY categoryType ASC";
$categories = $conn->query($sqlCategories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sari-Sari Store - Products</title>
  <link rel="stylesheet" href="product.css">
  <script src="product.js"></script>
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
    </div>
  </nav>

  <h1>Available Products</h1>

  <!-- Add Product Form -->
  <form action="add_product.php" method="POST" enctype="multipart/form-data" class="add-product-form">
    <h2>Add New Product</h2>

    <label>Product Name:</label>
    <input type="text" name="productName" required>

    <label>Price (₱):</label>
    <input type="number" name="productPrice" step="0.01" required>

    <label>Quantity:</label>
    <input type="number" name="productQuantity" required>

    <label>Photo:</label>
    <input type="file" name="productPhoto" accept="image/*">

    <label>Category:</label>
    <select name="categoryID" required>
      <?php
      $categories->data_seek(0);
      while ($cat = $categories->fetch_assoc()) {
        echo "<option value='" . $cat['categoryID'] . "'>" . $cat['categoryType'] . "</option>";
      }
      ?>
    </select>

    <button type="submit">Add Product</button>
  </form>

  <hr>

  <!-- Display Products by Category -->
  <?php
  $categories->data_seek(0);
  while ($cat = $categories->fetch_assoc()) {
    echo "<h2>" . $cat['categoryType'] . "</h2>";
    echo "<section class='products'>";

    $catID = $cat['categoryID'];
    $sqlProducts = "SELECT * FROM product WHERE categoryID = $catID";
    $products = $conn->query($sqlProducts);

    if ($products->num_rows > 0) {
      while ($row = $products->fetch_assoc()) {
        echo "<div class='product'>
                <div class='product-info'>
                  <h4>" . $row['productName'] . "</h4>
                  <p>Price: ₱" . $row['productPrice'] . "</p>
                  <p>Stock: " . $row['productQuantity'] . "</p>

                  <form action='add_to_cart.php' method='POST' class='quantity-controls'>
                    <input type='hidden' name='productID' value='" . $row['productID'] . "'>
                    <button type='button' onclick='decrement(this)'>-</button>
                    <input type='number' name='quantity' value='1' min='1' max='" . $row['productQuantity'] . "'>
                    <button type='button' onclick='increment(this)'>+</button>
                    <button type='submit'>Add to Cart</button>
                  </form>

                  <div class='product-actions'>
                    <a href='edit_product.php?id=" . $row['productID'] . "' class='btn-edit'>Edit</a>
                    <a href='delete_product.php?id=" . $row['productID'] . "' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </div>
                </div>
                <div class='product-image'>";
                  if (!empty($row['productPhoto'])) {
                    echo "<img src='" . $row['productPhoto'] . "' alt='' width='80' height='80'>";
                  } else {
                    echo "<img src='placeholder.png' alt='No Image' width='80' height='80'>";
                  }
        echo    "</div>
              </div>";
      }
    } else {
      echo "<p>No products in this category.</p>";
    }

    echo "</section>";
  }
  ?>

</div>

</body>
</html>
