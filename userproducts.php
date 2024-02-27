<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <style>


          button {
            font-family: 'Courier New', Courier, monospace;
               background-color:rgba(199, 207, 200, 0.755);
            padding: 10px;
            margin: 0 auto;
            border: none;
            box-shadow: 1px 1px 2px;
            border-radius: 5px;
            display: block;
            margin-bottom: 20px;
           padding-left:20px;
            padding-right:20px;
            }

              a {
    color: black;
    text-decoration: none;
  }

  a:hover {
   color: grey;
    text-decoration: none;
  }

  .card {
    width: 300px;
    height: 400px;
 
  }

  .edit-delete {
    margin:10px;
   background-color:rgba(199, 207, 200, 0.755);
 
  }



    </style>
</head>
<body>

</body>
</html>
  <div class="row">
        <?php
        $database_connection = mysqli_connect('localhost', 'root', '', 'oop-project');

        if ($database_connection->connect_error) {
            echo $database_connection->connect_error;
        }

        $sql = "SELECT id, product_image, product_name FROM products";

        $result = $database_connection->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo
            
            
            "<div class='col-md-3 mb-4  m-1 card-form mx-5'>
                    <div class='card my-3 '>
                       <img src='uploads/" . $row['product_image'] . "' class='card-img-top' alt='Product Image''>

                        <div class='card-body text-center'>
                            <h5 class='card-title text-center'>" . $row['product_name'] . "</h5>
             
                        </div>
                    </div>
                </div>";
        }
        ?>
    </div>
</body>
</html>