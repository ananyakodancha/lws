<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if form data exists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Quantities array: product_id => quantity
    $quantities = $_POST['quantities'] ?? [];
    // Array of product_ids to remove
    $remove = $_POST['remove'] ?? [];

    // Remove items from cart
    if (!empty($remove)) {
        // Prepare placeholders for IN clause
        $placeholders = implode(',', array_fill(0, count($remove), '?'));

        // Build dynamic types string
        $types = str_repeat('i', count($remove));
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id IN ($placeholders)");

        // Build parameters array (user_id + product_ids)
        $params = array_merge([$user_id], $remove);

        // Bind params dynamically
        $stmt->bind_param('i' . $types, ...$params);

        $stmt->execute();
        $stmt->close();
    }

    // Update quantities
    if (!empty($quantities)) {
        foreach ($quantities as $product_id => $qty) {
            $product_id = intval($product_id);
            $qty = intval($qty);
            if ($qty < 1) $qty = 1; // Minimum quantity is 1

            // If product not removed, update quantity
            if (!in_array($product_id, $remove)) {
                $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param('iii', $qty, $user_id, $product_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Redirect back to cart page after update
header("Location: cart.php");
exit;
