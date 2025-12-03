<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container container-box">
    <h2 class="text-center mb-4">Add New Product</h2>

    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-control" required>

        <label class="mt-3">Quantity</label>
        <input type="number" name="quantity" class="form-control" required>

        <label class="mt-3">Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>

        <button type="submit" name="save" class="btn btn-primary mt-3">Save</button>
        <a href="index.php" class="btn btn-secondary mt-3">Back</a>
    </form>

    <?php
    if (isset($_POST['save'])) {
        $name = $_POST['product_name'];
        $qty  = $_POST['quantity'];
        $price = $_POST['price'];

        mysqli_query($conn, "INSERT INTO products (product_name, quantity, price)
                             VALUES ('$name', '$qty', '$price')");

        echo "<script>alert('Product Added Successfully'); window.location='index.php';</script>";
    }
    ?>

</div>
</body>
</html>
