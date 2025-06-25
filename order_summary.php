<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($conn);
$user_id = $user_data['user_id'];

// Validate product_name in URL
if (!isset($_GET['product_name']) || trim($_GET['product_name']) === '') {
    die("❌ Product Name is required in the URL.");
}
$product_name = trim($_GET['product_name']);

// Fetch product details securely
$sql = "SELECT product_id, name, description, category, price, image FROM products WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $product_name);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("❌ Product not found: " . htmlspecialchars($product_name));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'pay_now') {
    // Sanitize and get form inputs
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $pin = trim($_POST['pincode']);
    $payment_method = $_POST['payment_method'];
    $quantity = max(1, intval($_POST['quantity']));
    $total_amount = $quantity * floatval($product['price']);
    $date = date("Y-m-d H:i:s");

    // Insert customer info
    $stmt = $conn->prepare("INSERT INTO customer_info (customer_name, phone, address, city, state, pincode, payment_method, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $phone, $address, $city, $state, $pin, $payment_method, $date);
    if (!$stmt->execute()) {
        die("❌ Customer insert failed: " . $stmt->error);
    }
    $customer_id = $stmt->insert_id;

    // Insert order with initial status 'pending'
    $order_status = 'pending';

    $stmt = $conn->prepare("INSERT INTO orders (
        user_id, product_id, quantity, total_amount, payment_method,
        shipping_name, shipping_phone, shipping_address, shipping_city,
        shipping_state, shipping_pincode, order_status, order_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $product_id = $product['product_id'];

    $stmt->bind_param(
        "iiidsssssssss",
        $user_id, $product_id, $quantity, $total_amount, $payment_method,
        $name, $phone, $address, $city, $state, $pin,
        $order_status,
        $date
    );

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Redirect depending on payment method
        if (in_array($payment_method, array('online', 'debit', 'credit'))) {
            echo ("<script>
                alert('Please complete your payment on the next page.');
                window.location.href = 'fake_payment.php?order_id=$order_id';
            </script>");
            exit;
        } else {
            // COD orders
            echo ("<script>
                alert('✅ Order placed successfully! Your order status is: Pending (COD)');
                window.location.href = 'my_orders.php';
            </script>");
            exit;
        }
    } else {
        die("❌ Order insert failed: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order Summary</title>
    <style>
        body {
            background:url(image/plain.jpg);
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color:rgba(239, 174, 244, 0.56);
            border-radius: 8px;
            box-shadow:#efaef4;
        }
        h1 {
            text-align: center;
            color: #880367;
        }
        .product-details, .customer-details {
            margin-bottom: 30px;
            color:#880367;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color:#880367;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 4px;
            background-color:rgba(244, 151, 251, 0.71);
            color: #000;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            background-color:rgba(239, 174, 244, 0.78);
        }
        .btn-group {
            margin-top: 20px;
            text-align: center;
        }
        .btn-group button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            background-color: #880367;
            color: #fff;
            cursor: pointer;
        }
        .btn-group button:hover {
            background-color:rgb(248, 76, 205);
        }
        .total-amount {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
            text-align: center;
            color:#880367;
        }
    </style>
    <script>
        function calculateTotal() {
            const price = <?php echo $product['price']; ?>;
            const quantity = document.getElementById('quantity').value;
            const totalAmount = price * quantity;
            document.getElementById('totalAmount').innerText = 'Total Amount: ₹' + totalAmount.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Product Details</h1>
        <div class="product-details">
            <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
            <p><strong>Price:</strong> ₹<?php echo number_format($product['price'], 2); ?></p>
            <!-- Optional product image -->
            <!-- <p><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="200" /></p> -->
        </div>

        <h1>Customer Details</h1>
        <form method="post" oninput="calculateTotal()">
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required />
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required />
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required />
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required />
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required />
            </div>
            <div class="form-group">
                <label for="pincode">Pincode:</label>
                <input type="text" id="pincode" name="pincode" required />
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="online">Online Payment</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="debit">Debit Card</option>
                    <option value="credit">Credit Card</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required />
            </div>
            <div id="totalAmount" class="total-amount">Total Amount: ₹<?php echo number_format($product['price'], 2); ?></div>

            <div class="btn-group">
                <button type="submit" name="action" value="pay_now">Pay Now</button>
                <button type="button" onclick="cancelOrder()">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        function cancelOrder() {
            alert('❌ Your order has been canceled.');
            window.location.href = 'cart.php?status=cancelled';
        }
        calculateTotal(); // Initialize total amount on page load
    </script>
</body>
</html>
