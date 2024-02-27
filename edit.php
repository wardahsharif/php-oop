<?php
$database_connection = mysqli_connect('localhost', 'root', '', 'oop-project');

if ($database_connection->connect_error) {
    die("Connection failed: " . $database_connection->connect_error);
}

$product = [];

if (isset($_GET['productid'])) {
    $productid = $_GET['productid'];

    $sql = "SELECT * FROM products WHERE id = $productid";
    $result = $database_connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found");
    }
} else {
    die("Productid parameter not set");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $product_name = $_POST['product_name'];

    // Check if a new image file is uploaded
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['productImage'];
        $imageFileName = $uploadedFile['name'];

        // Move the uploaded file to the "uploads" directory
        move_uploaded_file($uploadedFile['tmp_name'], 'uploads/' . $imageFileName);

        // Update the product data with the new image file name
        $updateSql = "UPDATE products SET product_name = '$product_name', product_image = '$imageFileName' WHERE id = $productid";
    } else {
        // Update the product data without changing the image
        $updateSql = "UPDATE products SET product_name = '$product_name' WHERE id = $productid";
    }

    $updateResult = $database_connection->query($updateSql);

    if ($updateResult) {
        echo "Product updated successfully!";
        header("Location: admin_dashboard.php?id=products");
        exit();
    } else {
        echo "Error updating product: " . $database_connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Edit Product</title>
</head>
<style>
    body {
         background-color:rgba(183, 197, 184, 0.645);
    }

    .container {
        background-color: white;
        margin-top: 150px;
    }

    h1 {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
    }

    label {
        font-family: 'Courier New', Courier, monospace;
    }

    .button {
        font-family: 'Courier New', Courier, monospace;
          background-color:rgba(199, 207, 200, 0.755);
        padding: 10px;
        margin: 0 auto;
        margin-top: 20px;
    }

    label {
        font-family: 'Courier New', Courier, monospace;
    }

    .back-button {
        padding: 15px;
        padding-left: 30px;
        padding-right: 30px;
        border: none;
    }

    .back-button:hover {
        padding: 15px;
        padding-left: 30px;
        padding-right: 30px;
        border: none;
        color: black;
        background-color:white;
    }
</style>
<body>

<div class="container border rounded p-4">
    <h1 class="text-center">Edit Product</h1>
    <form action="edit.php?productid=<?php echo $productid; ?>" method="POST" enctype="multipart/form-data"> 
          <div class="mb-3">
            <label for="product_id" class="form-label">Product Id</label>
            <input type="text" class="form-control" name="productid" placeholder="Enter product id" required value="<?php echo htmlspecialchars($product['ID']); ?>">
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" placeholder="Enter product name" required value="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>

          <div class="mb-3">
            <label for="productimage" class="form-label">Product Image</label>
            <input type="file" class="form-control" name="productImage"  accept="image/*" aria-describedby="emailHelp" required>
        </div>



        <div class="form-input btn rounded">
            <input type="submit" name="update" value="update" class="btn rounded border button px-4">
        </div>
    </form>
</div>

<div class="form-input btn rounded d-flex justify-content-center">
    <a href="admin_dashboard.php?id=products">
        <input type="submit" name="back" value="Back" class="btn rounded border button back-button">
    </a>
</div>
</body>
</html>

</body>
</html>