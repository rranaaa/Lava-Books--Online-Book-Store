<?php
include('conn.php');

// Work 3 - Insert Product Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitProduct'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $price = $_POST['price'];


    // Handle image upload
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $img = $_FILES['p_image']['name'];
    $p_image = 'Images/BooksPage/uploads/' . $_FILES['p_image']['name'];
    move_uploaded_file($p_image_tmp_name, $p_image);

    $sql = "INSERT INTO `books` (`book name`, `category`, `image_filename`, `price`,`author`) VALUES ('$name', '$category', '$img', '$price','$author')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Work 4 - Display Product Data
$result = $conn->query("SELECT * FROM books");


if (isset($_GET['deleteProductId'])) {
    $deleteProductId = $_GET['deleteProductId'];
    $sql = "DELETE FROM books WHERE book_ID = $deleteProductId";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
        // Redirect back to the product page after deleting
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button {
            padding: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #updateForm {
            display: <?php echo isset($updateProductId) ? 'block' : 'none'; ?>;
            margin-top: 20px;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        select{
            width: 90px;
            height: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>Product Data</h2>

    <!-- Product Form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="category">Category:</label>
        <input type="text" name="category" required>

        <label for="category">Author:</label>
        <input type="text" name="author" required>

        <label for="p_image">Image:</label>
        <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg, image/webp" class="box" required>

        <label for="price">Price:</label>
        <input type="number" name="price" required>

        <input type="submit" name="submitProduct" value="Add Product">
    </form>

    <!-- Product Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Author</th>
            <th>Price</th>
            <th>Action</th>
        </tr>


        <?php
        while ($row = $result ->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['book_ID']}</td>
                    <td>{$row['book name']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <button onclick='deleteProduct({$row['book_ID']})'>Delete</button>
                    </td>
                  </tr>";
        }
        ?>

    </table>

    

    <!-- JavaScript for delete operations -->
    <script>
  
        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "products.php?deleteProductId=" + id;
            }
        }
    </script>
</body>

</html>
