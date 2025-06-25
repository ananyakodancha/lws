<?php
session_start();

// Function to add item to cart
function addToCart($itemName, $price) {
    // Initialize cart session variable if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add item to cart array
    $item = array(
        'name' => $itemName,
        'price' => $price
    );
    array_push($_SESSION['cart'], $item);

    // Redirect back to the products page
    header("Location: products.html");
    exit;
}

// Function to add item to wishlist
function addToWishlist($itemName) {
    // Initialize wishlist session variable if not already set
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }

    // Add item to wishlist array
    array_push($_SESSION['wishlist'], $itemName);

    // Redirect back to the products page
    header("Location: products.html");
    exit;
}

// Function to initiate purchase process
function buyNow($itemName, $price) {
    // Here you can implement the logic to process the purchase,
    // such as storing the purchase details in the database, sending email confirmation, etc.
    // For demonstration purposes, let's just display a message
    echo "Thank you for purchasing $itemName for $price!";
}

// Check if action parameter is set in the URL
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Check which action is requested and call the corresponding function
    switch ($action) {
        case 'addToCart':
            if (isset($_GET['itemName']) && isset($_GET['price'])) {
                addToCart($_GET['itemName'], $_GET['price']);
            }
            break;
        case 'addToWishlist':
            if (isset($_GET['itemName'])) {
                addToWishlist($_GET['itemName']);
            }
            break;
        case 'buyNow':
            if (isset($_GET['itemName']) && isset($_GET['price'])) {
                buyNow($_GET['itemName'], $_GET['price']);
            }
            break;
        default:
            // Invalid action
            break;
    }
}
?>