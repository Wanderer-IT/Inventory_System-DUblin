<?php
include 'database.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Product ID missing.");

$stmt = $conn->prepare("SELECT * FROM product WHERE productID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['productName'];
  $price = $_POST['productPrice'];
  $quantity = $_POST['productQuantity'];
  $categoryID = $_POST['categoryID'];

  $photoPath = $product['productPhoto'];
  if (!empty($_FILES['productPhoto']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $photoPath = $targetDir . basename($_FILES["productPhoto"]["name"]);
    move_uploaded_file($_FILES["productPhoto"]["tmp_name"], $photoPath);
  }

  $stmt = $conn->prepare("UPDATE product SET productName=?, productPrice=?, productQuantity=?, productPhoto=?, categoryID=? WHERE productID=?");
  $stmt->bind_param("sdisii", $name, $price, $quantity, $photoPath, $categoryID, $id);

  if ($stmt->execute()) {
    header("Location: product.php");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }
}

$sqlCategories = "SELECT * FROM category ORDER BY categoryType ASC";
$categories = $conn->query($sqlCategories);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link rel="stylesheet" href="edit_products.css">
</head>
<body>
<div class="container">
  <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="add-product-form">
    <h2>Edit Product</h2>

    <label>Product Name:</label>
    <input type="text" name="productName" value="<?php echo $product['productName']; ?>" required>

    <label>Price (₱):</label>
    <input type="number" name="productPrice" step="0.01" value="<?php echo $product['productPrice']; ?>" required>

    <label>Quantity:</label>
    <input type="number" name="productQuantity" value="<?php echo $product['productQuantity']; ?>" required>

    <label>Photo:</label>
    <input type="file" name="productPhoto" accept="image/*">
    <?php if (!empty($product['productPhoto'])): ?>
      <p>Current: <img src="<?php echo $product['productPhoto']; ?>" width="80"></p>
    <?php endif; ?>

    <label>Category:</label>
    <select name="categoryID" required>
      <?php while ($cat = $categories->fetch_assoc()): ?>
        <option value="<?php echo $cat['categoryID']; ?>" <?php if ($cat['categoryID'] == $product['categoryID']) echo "selected"; ?>>
          <?php echo $cat['categoryType']; ?>
        </option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Update Product</button>
  </form