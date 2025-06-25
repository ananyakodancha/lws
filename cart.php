<?php 
session_start();
include("connection.php");

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle delete item request
if (isset($_POST['delete_item']) && isset($_POST['delete_product_id'])) {
    $product_id_to_delete = $_POST['delete_product_id'];

    $delete_query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $user_id, $product_id_to_delete);
    $stmt->execute();

    // Redirect to avoid resubmission on refresh
    header("Location: cart.php");
    exit();
}

// Fetch cart items with product_id included
$query = "SELECT c.quantity, p.product_id, p.name, p.price, p.image 
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = array();
$total_amount = 0;

while ($row = $result->fetch_assoc()) {
    $row['item_total'] = $row['price'] * $row['quantity'];
    $total_amount += $row['item_total'];
    $cart_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: url(image/plain.jpg) ;}
        .container { max-width: 800px; margin: 40px auto; background:rgba(239, 174, 244, 0.19); padding: 20px; border-radius: 10px; }
        h2 { margin-bottom: 20px; }
        .cart-item { display: flex; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 15px; }
        .cart-item img { width: 100px; height: 100px; object-fit: cover; margin-right: 20px; border-radius: 8px; }
        .item-info { flex: 1; }
        .item-info h3 { margin: 0 0 10px; }
        .item-info p { margin: 4px 0; }
        .item-total { font-weight: bold; color: #333; }
        .cart-total { text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px; }
        #buy-now-btn { margin-top: 20px; padding: 12px 30px; background: #ef952e; color: white; border: none; border-radius: 25px; cursor: pointer; }
        #buy-now-btn:hover { background: #e68a2e; }
        .remove-btn {
            background-color:#f44336;
            color:white;
            border:none;
            padding:8px 12px;
            border-radius:5px;
            cursor:pointer;
            font-size: 14px;
        }
        .buttons-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .home-btn {
            background-color:rgba(161, 23, 171, 0.53);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            margin-left:700px;
        }
        .home-btn:hover {
            background-color: #555;
        }
        .buy-now {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: opacity 0.3s;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
  }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Shopping Cart                  <a href="index.php" class="home-btn">HOME</a></h2>
        <?php if (empty($cart_items)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <?php if (isset($_GET['status']) && $_GET['status'] === 'cancelled') : ?>
    <div style="background: #ffe0e0; color: #d8000c; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        ❌ Your order has been canceled.
    </div>
<?php endif; ?>

            <?php foreach ($cart_items as $item) : ?>
                <div class="cart-item">
<img src="image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100px; height: auto;">
                    <div class="item-info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Price: Rs <?php echo number_format($item['price'], 2); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p class="item-total">Total: Rs <?php echo number_format($item['item_total'], 2); ?></p>
                    </div>
                    <form method="post" action="cart.php" style="margin-left: 15px;">
                        <input type="hidden" name="delete_product_id" value="<?php echo $item['product_id']; ?>">
                        <button type="submit" name="delete_item" class="remove-btn" onclick="return confirm('Remove this item from cart?');">
                            Remove
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                Grand Total: Rs <?php echo number_format($total_amount, 2); ?>
            </div>
            
<form action="order_summary.php" method="get">
  <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
  <button type="submit" class="buy-now">Buy</button>
</form>


           
        <?php endif; ?>
         
    </div>
</body>
</html>
