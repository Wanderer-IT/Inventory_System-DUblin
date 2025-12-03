<?php include 'db.php'; 

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container container-box">
    <h2 class="text-center mb-4">Edit Product</h2>

    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-control" value="<?php echo $product['product_name']; ?>" required>

        <label class="mt-3">Quantity</label>
        <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>

        <label class="mt-3">Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>

        <button type="submit" name="update" class="btn btn-success mt-3">Update</button>
        <a href="index.php" class="btn btn-secondary mt-3">Back</a>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $name = $_POST['product_name'];
        $qty  = $_POST['quantity'];
        $price = $_POST['price'];

        mysqli_query($conn, 
            "UPDATE products SET product_name='$name', quantity='$qty', price='$price' WHERE id=$id"
        );

        echo "<script>alert('Product Updated'); window.location='index.php';</script>";
    }
    ?>

</div>
</body>
</html>
