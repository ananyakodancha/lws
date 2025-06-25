<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    echo "Please login first!";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

// Validate product ID
if ($product_id <= 0) {
    echo "Invalid product ID!";
    exit;
}

// Check if product already exists in favorites
$query = "SELECT * FROM favorites WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo "Database error: " . $conn->error;
    exit;
}

$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    // If already in favorites, optionally skip or increase quantity
    echo "Already in your wishlist!";
} else {
    // Insert into favorites table
    $insert = "INSERT INTO favorites (user_id, product_id, quantity) VALUES (?, ?, 1)";
    $insert_stmt = $conn->prepare($insert);

    if (!$insert_stmt) {
        echo "Insert error: " . $conn->error;
        exit;
    }

    $insert_stmt->bind_param("ii", $user_id, $product_id);
    $insert_stmt->execute();

    echo "Item added successfully!";
}
?>
