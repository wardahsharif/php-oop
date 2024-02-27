<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Document</title>
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
 
 
  }

    .error-message {
        color: red;
         font-family: 'Courier New', Courier, monospace;
        margin-top: 10px;
        border-radius: 40px;
        width:50%;
       margin-left: 200px;
       background-color: white;
       text-align: center;

    }
  </style>
<body>
 

 <?php include_once('navbar.php'); ?>
<div class="container border rounded p-4">


<h1 class="text-center">Login</h1>
<form action="login.php" method="POST">

  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username"  placeholder="Enter username">
   </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
  </div>


  <div class="form-input btn rounded">
                <input type="submit" name="login" value="login" class="btn rounded border button ">
            </div>
</form>
</div>
</body>
</html>

<?php
include_once 'db-connect.php';
include_once './classes/user.php';
include_once './classes/admin.php';
include_once './classes/customer.php';

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials against the database
    $user = validateCredentials($username, $password, $database_connection);

    if ($user) {
        // Login successful
        $_SESSION['user'] = $user;
         $_SESSION['username'] = $user->getUsername(); 

        if ($user instanceof Admin) {
            header("Location: admin_dashboard.php");
        } elseif ($user instanceof Customer) {
            header("Location: customer_dashboard.php");
        } else {
            // Handle other user types as needed
            echo "Invalid user type";
        }

        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password";
    }
}

function validateCredentials($username, $password, $connection) {
    // Replace this with actual validation logic
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {
                return new Admin(null, $user['username'], '', ''); // Pass dummy values for email and password
            } elseif ($user['role'] === 'customer') {
                return new Customer(null, $user['username'], '', ''); // Pass dummy values for email and password
            }
        }
    }

    return null;
}
?>


