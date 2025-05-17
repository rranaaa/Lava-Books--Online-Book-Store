<?php
include "./header.php";

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booklr";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all items from the cart
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Calculate total amount
    $total_amount = 0;
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row['price'];  // assuming quantity is always 1
        $cartItems[] = $row;
    }

    // Insert order into ordering table
    $order_date = date('Y-m-d H:i:s');
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO ordering (order_date, total_amount, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $order_date, $total_amount, $status);
    $stmt->execute();

    // Get the inserted order id
    $order_id = $stmt->insert_id;

    // Insert each cart item into order_items
    $stmtItems = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cartItems as $item) {
        $book_id = $item['book_ID'];
        $quantity = 1;  // If you want quantity support, update this accordingly
        $price = $item['price'];

        $stmtItems->bind_param("iiid", $order_id, $book_id, $quantity, $price);
        $stmtItems->execute();
    }

    // Clear the cart after placing order
    $conn->query("DELETE FROM cart");

    $stmt->close();
    $stmtItems->close();
} else {
    // No items in cart
    echo "<script>alert('Your cart is empty!'); window.location.href = 'cart.php';</script>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Confirmed</title>
</head>
<body>
    <div style="text-align: center; height: 300px;">
        <h1 style="color: orangered;">Order Confirmed</h1>
        <h2>Thanks for Ordering</h2>
        <p>Your order number is: <strong><?= $order_id ?></strong></p>
    </div>

<?php include "./footer.php" ?>
</body>
</html>
