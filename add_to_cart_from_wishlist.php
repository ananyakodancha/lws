<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = $_POST['index'];

    // Check if index exists in wishlist array
    if (isset($_SESSION['wishlist'][$index])) {
        // Get item details from wishlist
        $item = $_SESSION['wishlist'][$index];

        // Add item to cart (similar logic as add_to_cart.php)
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'][] = $item;
        } else {
            $_SESSION['cart'] = [$item];
        }

        // Remove item from wishlist using index
        unset($_SESSION['wishlist'][$index]);

        // Re-index wishlist array to prevent gaps
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);

        echo "Item added to cart from wishlist successfully";
    } else {
        echo "Item not found in wishlist";
    }
} else {
    echo "Invalid request method";
}
?>
