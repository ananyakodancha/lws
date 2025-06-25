<?php
session_start();
include("connection.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_GET['product_id'])) {
    die("Product ID is missing.");
}

$product_id = intval($_GET['product_id']);

// Get product info
$product_stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

if ($product_result->num_rows === 0) {
    die("Product not found.");
}

$product = $product_result->fetch_assoc(); // ✅ Now $product is defined

// Get reviews
$review_stmt = $conn->prepare("SELECT pr.rating, pr.review, pr.review_date, u.full_name
                               FROM product_review pr
                               JOIN users u ON pr.user_id = u.user_id
                               WHERE pr.product_id = ?");
$review_stmt->bind_param("i", $product_id);
$review_stmt->execute();
$reviews = $review_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews for <?php echo htmlspecialchars($product['name']); ?></title>
    <a href="product1.php" style="
    display: inline-block;
    padding: 10px 20px;
    background-color: #880367;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    margin-bottom: 20px;
"> Back to Products</a>

    <style>
        body { font-family: Arial; background: url(image/plain.jpg); padding: 20px; }
        .review { border: 1px solid #ccc; padding: 15px; margin: 10px 0; border-radius: 5px; background: white; }
        .username { font-weight: bold; }
        .rating { color: orange; }
        .date { font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <h2>Reviews for "<?php echo htmlspecialchars($product['name']); ?>"</h2>

    <?php if ($reviews->num_rows > 0): ?>
        <?php while ($row = $reviews->fetch_assoc()): ?>
            <div class="review">
                <div class="username"><?php echo htmlspecialchars($row['full_name']); ?></div>
                <div class="rating"><?php echo str_repeat("*", $row['rating']); ?></div>
                <div class="date"><?php echo htmlspecialchars($row['review_date']); ?></div>
                <p><?php echo nl2br(htmlspecialchars($row['review'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews yet for this product.</p>
    <?php endif; ?>
</body>
</html>
