<?php

class Admin extends User {
    public function __construct($id, $username, $email, $password) {
        parent::__construct($id, $username, $email, $password);
    }

        public function getUsername() {
        return $this->username;
    }

    public function uploadProduct($productName, $productImageURL) {
        // Implement product upload logic here, e.g., storing in the database
        // You should use prepared statements to prevent SQL injection in a real-world scenario

        // Connect to the database
        include_once 'db-connect.php';

        // Sanitize input
        $productName = mysqli_real_escape_string($database_connection, $productName);
        $productImageURL = mysqli_real_escape_string($database_connection, $productImageURL);

        // Insert the product into the products table
        $insertQuery = "INSERT INTO products (product_name, image_url) VALUES ('$productName', '$productImageURL')";

        if ($database_connection->query($insertQuery) === TRUE) {
            echo "Admin '$this->username' uploaded product '$productName' with image: $productImageURL";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $database_connection->error;
        }
    }
}
