<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Add Product</title>
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
  padding:15px;
  padding-left: 30px;
   padding-right: 30px;
   border: none;
  }

  a {
    color: black;
    text-decoration: none;
  }

    .back-button:hover {
  padding:15px;
  padding-left: 30px;
   padding-right: 30px;
   border: none;
   color:white;
    background-color: rgba(181, 187, 215, 0.845);
  }
</style>
<body>
<div class="container border rounded p-4">
    <h1 class="text-center">Add Product</h1>
    <form action="upload_product.php" method="POST" enctype="multipart/form-data"> 
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" placeholder="Enter product name" required>
        </div>

           <div class="mb-3">
            <label for="productimage" class="form-label">Product Image</label>
            <input type="file" class="form-control" name="productImage"  accept="image/*" aria-describedby="emailHelp" required>
        </div>


        <div class="form-input btn rounded">
            <input type="submit" name="upload" value="upload" class="btn rounded border button px-4">
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
<?php
include_once 'db-connect.php';

if (isset($_POST['upload'])) {
    $productName = $_POST['product_name'];

    // Handle product image upload
    $uploadDir = "uploads/";
    $targetFile = $uploadDir . uniqid('product_') . '_' . basename($_FILES["productImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    
    if ($check !== false) {
        // Move the uploaded file to the "uploads" directory
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
            // Insert product details into the database
            $insertQuery = "INSERT INTO products (product_name, product_image) VALUES ('$productName', '$targetFile')";
            
            if ($database_connection->query($insertQuery) === TRUE) {
                header("Location:admin_dashboard.php?id=products");
                exit();
            } else {
                echo "Error: " . $insertQuery . "<br>" . $database_connection->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not a valid image.";
    }
}
?>


