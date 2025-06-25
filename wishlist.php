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

    $delete_query = "DELETE FROM favorites WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($delete_query);
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $user_id, $product_id_to_delete);
    $stmt->execute();

    // Redirect to avoid resubmission on refresh
    header("Location: wishlist.php");
    exit();
}

// Fetch favorite items (wishlist)
$query = "SELECT p.product_id, p.name, p.price, p.image 
          FROM favorites c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = array();
$total_amount = 0;

while ($row = $result->fetch_assoc()) {
    $row['item_total'] = $row['price']; // No quantity for wishlist
    $total_amount += $row['item_total'];
    $cart_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Favorites</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background-image:url(image/plain.jpg) }
        .container { max-width: 800px; margin: 40px auto; background:rgba(136, 3, 103, 0.36); padding: 20px; border-radius: 10px; }
        h2 { margin-bottom: 20px; }
        .cart-item { display: flex; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 15px; }
        .cart-item img { width: 100px; height: 100px; object-fit: cover; margin-right: 20px; border-radius: 8px; }
        .item-info { flex: 1; }
        .item-info h3 { margin: 0 0 10px; }
        .item-info p { margin: 4px 0; }
        .item-total { font-weight: bold; color: #333; }
        .cart-total { text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px; }
        .remove-btn {
            background-color:#f44336;
            color:white;
            border:none;
            padding:8px 12px;
            border-radius:5px;
            cursor:pointer;
            font-size: 14px;
        }
        .add-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .home-btn {
            background-color: #880367;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Favorites
        <a href="index.php" class="home-btn">HOME</a></h2>
        <?php if (empty($cart_items)) : ?>
            <p>Your wishlist is empty.</p>
        <?php else : ?>
            <?php foreach ($cart_items as $item) : ?>
                <div class="cart-item">
<img src="image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100px; height: auto;">
                    <div class="item-info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Price: Rs <?php echo number_format($item['price'], 2); ?></p>
                        <p class="item-total">Total: Rs <?php echo number_format($item['item_total'], 2); ?></p>
                        <button class="add-btn" onclick="addToCart(<?php echo $item['product_id']; ?>)">Add to Cart</button>
                    </div>
                    <form method="post" action="wishlist.php" style="margin-left: 15px;">
                        <input type="hidden" name="delete_product_id" value="<?php echo $item['product_id']; ?>">
                        <button type="submit" name="delete_item" class="remove-btn" onclick="return confirm('Remove this item from wishlist?');">
                            Remove
                        </button>
                        
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                Total Value of Favorites: Rs <?php echo number_format($total_amount, 2); ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function addToCart(product_id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText.trim() === "Item added successfully!") {
                        alert("Item added successfully!");
                    } else if (this.responseText.trim() === "Please login first!") {
                        alert("Please login first!");
                        window.location.href = "login.php";
                    } else {
                        alert(this.responseText);
                    }
                }
            }
        };
        xhttp.open("POST", "add_to_cart.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("product_id=" + product_id);
    }
    </script>
</body>
</html>
