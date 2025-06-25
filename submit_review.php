
<?php
session_start();
include("connection.php");
include("function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_data = check_login($conn);
    $user_id = $user_data['user_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $stmt = $conn->prepare("INSERT INTO product_review (user_id, product_id, rating, review, review_date) VALUES (?, ?, ?, ?, NOW())");

    if ($stmt) {
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review);
        $stmt->execute();
        $stmt->close();
        header("Location: my_orders.php");
        exit();
    } else {
        echo "Failed to prepare statement: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
