<?php

$database_connection = mysqli_connect('localhost', 'root', '', 'oop-project');

if ($database_connection->connect_error) {
    die("Connection failed: " . $database_connection->connect_error);
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $checkUserQuery = "SELECT * FROM products WHERE id = $product_id";
    $result = $database_connection->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $deleteQuery = "DELETE FROM products WHERE id = $product_id";

        if ($database_connection->query($deleteQuery) === TRUE) {
            echo "Product deleted successfully!";
        } else {
            echo "Error deleting product: " . $database_connection->error;
        }
    } else {
        echo "Error: Product not found.";
    }

    
    header("Location: admin_dashboard.php?id=products");
    exit();
} else {
    echo "Error: Product ID not provided.";
}
?>
