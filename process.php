<?php

include_once 'db-connect.php';

include_once './classes/user.php';
include_once './classes/admin.php';
include_once './classes/customer.php';

session_start();


// Check if the form is submitted
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];


      // Check if the email is already registered
    $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $database_connection->query($emailCheckQuery);

      if ($result->num_rows > 0) {
        // Email already registered
        $error_message = "Email is already registered. Please use a different email.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $insertQuery = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";

        if ($database_connection->query($insertQuery) === TRUE) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $database_connection->error;
        }

        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
}
?>