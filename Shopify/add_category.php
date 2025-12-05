<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $categoryType = $_POST['categoryType'];

  $stmt = $conn->prepare("INSERT INTO category (categoryType) VALUES (?)");
  $stmt->bind_param("s", $categoryType);

  if ($stmt->execute()) {
    echo "<p class='success'>Category added successfully!</p>";
  } else {
    echo "<p class='error'>Error: " . $stmt->error . "</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Category</title>
  <link rel="stylesheet" href="product.css">
</head>
<body>

<div class="container">
  <nav class="nav">
    <div class="nav-logo"><h1>My Sari-Sari Store</h1></div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="product.php">Shop</a>
      <a href="cheakout.php">Check Out</a>
      <a href="view_orders.php">View Orders</a>
      <a href="about.php">About Me</a>
    </div>
  </nav>

  <form action="add_category.php" method="POST" class="add-product-form">
    <h2>Add New Category</h2>

    <label>Category Name:</label>
    <input type="text" name="categoryType" required>

    <button type="submit">Add Category</button>
  </form>
</div>

</body>
</html>
