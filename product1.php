<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
$loggedIn = false;
if (isset($_SESSION['username'])) {
    $user_data = check_login($conn);
    $loggedIn = true;
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Cards</title>
  <link rel="stylesheet" href="prd.css">
</head>
<body>
<header>
    <div class="dropdown">
        <button class="dropbtn"><b>&#9776;Categories</b></button>
        <div class="dropdown-content">
            <a href="index.php">HOME</a>
            <a href="product1.php">All Products</a>
            <a href="skincare.php">Skincare</a>
            <a href="clothes.php">Clothes</a>
            <a href="food.php">Food</a>
            <a href="hygiene.php">Hygiene</a>
            <a href="toys.php">Toys</a>
            <a href="others.php">Others</a>
        </div>
    </div>
    <div class="center-align">
        <div class="welcome">
            <p>Our Products</p>      
        </div>
        <a href="index.php">HOME</a>
        <a href="wishlist.php">WISHLIST</a>
        <a href="cart.php">CART</a>
    </div>
</header>
<div class="content">
    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            $products_per_row = 3;
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                if ($count % $products_per_row === 0) {
                    echo '<div class="product-row">';
                }

                echo '<div class="product-card">';

// Image zoom container
echo '<div class="image-container">';
echo '<img src="image/' . $row["image"] . '" alt="' . $row["name"] . '" class="product-img">';
echo '</div>';



                echo '<h2>' . $row["name"] . '</h2>';
                echo '<p>' . $row["description"] . '</p>';
                echo '<p>Rs' . $row["price"] . '</p>';
                echo '<p>Category: ' . $row["category"] . '</p>';
                echo '<p>Status: ' . $row["stock_status"] . '</p>';
                echo '<div class="buttons">';
                echo '<button type="button"class="wishlist-btn" onclick="addToCart(' . $row["product_id"] . ')"> Cart</button>';
                
                echo '<form class="add-to-cart-form" method="post">';
                echo '<input type="hidden" name="name" value="' . $row["name"] . '">';
                echo '<input type="hidden" name="price" value="' . $row["price"] . '">';
                echo '<input type="hidden" name="image" value="' . $row["image"] . '">';
                echo '<button type="button" class="wishlist-btn" onclick="addtowish(' . $row["product_id"] . ')">&#x2665; Wishlist</button>';

                echo '</form>';
                echo '<form action="order_summary.php" method="post">';
                echo '<a href="order_summary.php?product_name=' . urlencode($row['name']) . '" class="buy-now">Buy</a>';
                echo '</form>';


                echo '</div>'; // buttons
                // **Add Review link here**
echo '<a href="product_review.php?product_id=' . $row["product_id"] . ' style="margin-left:10px;">Reviews</a>';

                echo '</div>'; // product-card

                $count++;
                if ($count % $products_per_row === 0) {
                    echo '</div>'; // product-row
                }
            }
            if ($count % $products_per_row !== 0) {
                echo '</div>'; // close last row
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
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

function addtowish(product_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let response = this.responseText.trim();
                if (response === "Item added successfully!") {
                    alert("Item added successfully!");
                } else if (response === "Please login first!") {
                    alert("Please login first!");
                    window.location.href = "login.php";
                } else {
                    alert(response);
                }
            }
        }
    };
    xhttp.open("POST", "add_to_wishlist.php", true); // Make sure file name matches here
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("product_id=" + product_id);
}

</script>
</body>
</html>
