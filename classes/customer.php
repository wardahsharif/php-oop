<?php
class Customer extends User {
    public function __construct($id, $username, $email, $password) {
        parent::__construct($id, $username, $email, $password);
    }

       public function getUsername() {
        return $this->username;
    }

    public function viewProducts() {
        // Implement product viewing logic here, e.g., fetching products from the database

        // Connect to the database
        include_once 'db-connect.php';

        // Fetch all products from the products table
        $selectQuery = "SELECT * FROM products";
        $result = $database_connection->query($selectQuery);

        if ($result->num_rows > 0) {
            echo "Customer '$this->username' is viewing products:<br>";

            while ($row = $result->fetch_assoc()) {
                echo "Product: " . $row['product_name'] . ", Image: " . $row['image_url'] . "<br>";
            }
        } else {
            echo "No products available.";
        }
    }
}
