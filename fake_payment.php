<?php
session_start();
include("connection.php");
include("function.php");

// Check login and get user data
$user_data = check_login($conn);
$user_id = $user_data['user_id'];

// Get order id from GET param
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid order ID.");
}
$order_id = intval($_GET['order_id']);

// Fetch order details (assuming your orders table has 'id' as PK)
$sql = "SELECT o.*, p.name AS product_name, p.price AS product_price 
        FROM orders o 
        JOIN products p ON o.product_id = p.product_id 
        WHERE o.id = ? AND o.user_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$order = $result->fetch_assoc();
if (!$order) {
    die("Order not found or you don't have permission.");
}

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $password_input = $_POST['password'];

    // Verify password matches logged-in user's password (hashed)
    $stmt2 = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $user = $res2->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }

   // ... fetch $user['password']

// For old PHP or plain-text password
if ($password_input === $user['password']) {
    // Update order status
    $update_stmt = $conn->prepare("UPDATE orders SET order_status = 'processing' WHERE id = ? AND user_id = ?");
    $update_stmt->bind_param("ii", $order_id, $user_id);
    if ($update_stmt->execute()) {
        echo "<script>alert('Payment successful!'); window.location.href='my_orders.php';</script>";
        exit;
    } else {
        die("Failed to update order status: " . $update_stmt->error);
    }
} else {
    $error = "Incorrect password. Payment failed.";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Make Payment</title>
<style>
    body { background:url(image/plain.jpg); font-family: Arial, sans-serif; padding: 20px; }
    .container { max-width: 600px; margin: auto; background:rgba(248, 178, 250, 0.51); padding: 20px; border-radius: 8px; }
    h1 { text-align: center; color: #880367; }
    label { display: block; margin: 10px 0 5px; }
    input[type="password"] { width: 100%; padding: 10px; border-radius: 4px; border: none; }
    button { margin-top: 15px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #218838; }
    .error { color: #ff4444; margin-top: 10px; }
    .details { margin-bottom: 20px; }
</style>
</head>
<body>
<div class="container">
    <h1>Make Online Payment</h1>

    <div class="details">
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
        <p><strong>Total Price:</strong> ₹<?php echo htmlspecialchars($order['total_amount']); ?></p>
        <p><strong>Current Status:</strong> <?php echo ucfirst(htmlspecialchars($order['order_status'])); ?></p>
    </div>

    <form method="post">
        <label for="password">Enter your account password to confirm payment:</label>
        <input type="password" id="password" name="password" required />

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <button type="submit" name="pay">Pay Now</button>
    </form>
</div>
</body>
</html>
