<?php
session_start();

include("connection.php");
include("function.php");

// Check if user is logged in
if(isset($_SESSION['username'])) {
    $user_data = check_login($conn);

}/*else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit; // Terminate script execution after redirect
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LITTLE WONDERS SHOP</title>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="stl2.css"> <!-- Link to external CSS file -->

    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> <!--off canvas-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"><!--animations-->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"><!--Add this line for Ionic Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"><!-- for star -->
    
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"> -->
    
</head>
<body>

<!-- Header Section -->
<header>

<div class="nav-logo">LITTLE WONDERS SHOP</div>
    <p class="welcome">Safe and secure e-commerce platform</p>
    <!-- header middle starts -->
    <div class="header_middel">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="home_contact">
                            <div class="contact_icone">
                                <img src="images/icon/icon_phone.png" alt="">
                            </div>
                            <div class="contact_box">
                                <p>Inquiry / Helpline : <a href="tel: 8618964754">8618964754</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo">
                            <img src="image/logo.png">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 col-6">
                        <div class="middel_right">
                             <div class="wishlist_btn">
                                <a href="my_orders.php"><i class="icon ion-clipboard"></i></a>
                            </div>
                  
                            <div class="wishlist_btn">
                                <a href="wishlist.php"><i class="ion-heart"></i></a>
                            </div>

                            <div class="cart_link">
                                <a href="cart.php"><i class="ion-android-cart"></i></a>
                            </div>

                            <div class="profile_btn">
                                <a href="profile.php" id="openSidebar"><i class="ion-person"></i></a>
                            </div>

                            <div id="sidebar" class="sidebar">
                                <h2>LITTLE WONDERS SHOP</h2>
                                <p>
                                    <?php 
                                    if(isset($_SESSION['email'])) {
                                        $user_data = check_login($conn);
                                        echo $user_data['email'];
                                    } else {
                                        echo "<ul>
                                                <li><a href='register.php'>Register</a></li>
                                                <li><a href='login.php'>Login</a></li>
                                            </ul>";
                                    }
                                    ?>
                                </p>
                                <ul>
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                    <li><a href="index.php">Back</a></li>
                                </ul>
                            </div>
                            <div id="overlay" class="overlay"></div>
                            <!-- <div class="search">
                                    <div class="search-bar"> 
                                        <input type="text" id="find" placeholder="Search here" onkeyup="search()">
                                        <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                    </div>
                                </div> -->
        
                            <script src="script.js"></script>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</header>

<!-- header middle ends -->

<!-- Navigation Menu -->
<div class="menu">
    <nav>
        <ul>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="product1.php">Products</a></li>
            <li><a href="about.php">About Us</a></li>
           
            <li><a href="logout.php">Logout</a></li>

        </ul>
    </nav>
</div>

<!-- Carousel Section -->
<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" dir="ltr">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
            <center><img src="image/img1.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img2.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img3.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img4.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img5.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img6.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img7.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img8.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
           <center> <img src="image/img9.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <center>  <img src="image/img10.jpg" class="d-block w-60" alt="..."></center>
            <div class="carousel-caption d-none d-md-block" style="color: #a8741a; left:8%; font-size: 35px; top: 87%; transform: translateY(-50%); text-align: left;">
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>



<!-- Script for Carousel Auto-slide -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function nextSlide() {
        $('#carouselExampleInterval').carousel('next');
    }
    setInterval(nextSlide, 3000);
</script>

<!-- Banner Section -->
<section class="banner_section banner_black">
    <h2 style="color:#880367"><center>Category</center></h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="skincare.php"><img src="image/skincare.png" alt="banner1"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="food.php"><img src="image/food.png" alt="banner2"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="clothes.php"><img src="image/clothes.png" alt="banner3"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
</div>
        <br>
        <br>
         <div class="row">
        <div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="hygiene.php"><img src="image/hygiene.png" alt="banner3"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="toys.php"><img src="image/toys.png" alt="banner3"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
        
<div class="col-lg-4 col-md-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="others.php"><img src="image/others.png" alt="banner3"></a>
                        <div class="banner_content">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
            
<br>
<br>


<!-- ends here -->


<!-- Footer Section -->
<footer>
    <section class="footer">
        <div class="box-container">
            <div class="box">
            <h3>EXTRA LINKS</h3>
               
                <a href="about.php"><i class="ion-arrow-right-c"></i> ABOUT US</a>
                <a href="index.php"><i class="ion-arrow-right-c"></i> HOME</a>
                <a href="logout.php"><i class="ion-arrow-right-c"></i> LOGOUT</a>
            </div>
            <div class="box">
                <h3>CONTACT INFO</h3>
                <a href="tel:1234567890"><i class="icon ion-ios-telephone"></i> +123-456-7890</a>
                <a href="tel:1112223333"><i class="icon ion-ios-telephone"></i> +111-222-3333</a>
                <a href="mailto:IKSHAK10@gmail.com"><i class="ion-ios-email"></i> lws@gmail.com</a>
                <a href="#"><i class="ion-ios-location"></i> Karnataka, India-560104</a>
            </div>


            <div class="box">
                <h3>FOLLOW US</h3>
                <a href="#"><i class="ion-social-facebook"></i> FACEBOOK</a>
                <a href="#"><i class="ion-social-twitter"></i> TWITTER</a>
                <a href="#"><i class="ion-social-linkedin"></i> LINKEDIN</a>
                <a href="#"><i class="ion-social-instagram"></i> INSTAGRAM</a>
            </div>
        </div>
        <div class="credit">THANK YOU<span> VISIT AGAIN</SPAN>!!</div>
    </section>
    <p class="copyrite">&copy; 2024 Lws Shop. All rights reserved.</p>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="main.js"></script>

</body>
</html>