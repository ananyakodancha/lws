<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($conn);
$user_id = $user_data['user_id'];

// Fetch user's orders excluding cancelled ones
$sql = "SELECT o.*, p.name AS product_name, p.image AS product_image
        FROM orders o
        JOIN products p ON o.product_id = p.product_id
        WHERE o.user_id = ? AND o.order_status != 'cancelled'
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$steps = array('pending', 'processing', 'shipped', 'delivered');
$reviewed = array();

// Fetch products already reviewed by the user
$review_result = $conn->query("SELECT product_id FROM product_review WHERE user_id = {$user_data['user_id']}");
while ($r = $review_result->fetch_assoc()) {
    $reviewed[] = $r['product_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body { font-family: Arial; background-image:url(image/plain.jpg); color: #333; }
        .order-container { width: 80%; margin: 20px auto; background: color rgba(238, 110, 206, 0.62);; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        .order-item { border-bottom: 1px solid #ddd; padding: 15px 0; }
        .status { font-weight: bold; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .pending { background: orange; color: white; }
        .processing { background: dodgerblue; color: white; }
        .shipped { background: purple; color: white; }
        .delivered { background: green; color: white; }
        img { width: 80px; height: auto; margin-right: 15px; vertical-align: middle; }
        .tracking-steps {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .step {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            margin: 0 5px;
            background: #ddd;
            border-radius: 5px;
            color: #555;
            font-weight: bold;
            position: relative;
            font-size: 0.9em;
        }
        .step.active {
            background: #4CAF50;
            color: white;
        }
        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -10px;
            width: 20px;
            height: 4px;
            background: #ddd;
            transform: translateY(-50%);
            z-index: -1;
        }
        .step.active:not(:last-child)::after {
            background: #4CAF50;
        }
        form { display: inline; }
        button {
            margin-top: 10px;
            padding: 6px 12px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #d32f2f;
        }
        .home-btn {
            background-color:rgba(136, 3, 103, 0.17);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            margin-left:900px;
        }
        .home-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="order-container">
    <h2>My Orders <a href="index.php" class="home-btn">HOME</a></h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="order-item">
<img src="image/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="width: 100px; height: auto;">

            <strong><?php echo htmlspecialchars($row['product_name']); ?></strong><br>
            Quantity: <?php echo $row['quantity']; ?><br>
            Total: ₹<?php echo $row['total_amount']; ?><br>
            Ordered on: <?php echo date("d M Y, h:i A", strtotime($row['order_date'])); ?><br>
            <span class="status <?php echo htmlspecialchars($row['order_status']); ?>">
                <?php echo ucfirst(htmlspecialchars($row['order_status'])); ?>
            </span>

            <div class="tracking-steps">
                <?php 
                $current_status = strtolower($row['order_status']);
                foreach ($steps as $step): 
                    $active = (array_search($step, $steps) <= array_search($current_status, $steps));
                ?>
                    <div class="step <?php echo $active ? 'active' : ''; ?>">
                        <?php echo ucfirst($step); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (in_array($row['order_status'], array('pending', 'processing'))): ?>
                <form method="post" action="cancel_order.php" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Cancel Order</button>
                </form>
            <?php endif; ?>

            <?php if ($row['order_status'] === 'delivered' && !in_array($row['product_id'], $reviewed)): ?>
                <button onclick="openReviewPopup(<?php echo $row['product_id']; ?>)">Leave a Review</button>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<!-- Review Popup Modal -->
<div id="reviewModal" style="display:none; position:fixed; top:20%; left:30%; background:#fff; padding:20px; border:2px solid #333;">
    <h3>Rate and Review</h3>
    <form method="post" action="submit_review.php">
        <input type="hidden" name="product_id" id="reviewProductId">
        <label>Rating:</label><br>
        <select name="rating" required>
            <option value="">Select</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?> ★</option>
            <?php endfor; ?>
        </select><br><br>
        <label>Review:</label><br>
        <textarea name="review" rows="4" cols="40" required></textarea><br><br>
        <button type="submit">Submit</button>
        <button type="button" onclick="closeReviewPopup()">Cancel</button>
    </form>
</div>

<script>
function openReviewPopup(productId) {
    document.getElementById("reviewProductId").value = productId;
    document.getElementById("reviewModal").style.display = "block";
}

function closeReviewPopup() {
    document.getElementById("reviewModal").style.display = "none";
}
</script>

</body>
</html>
