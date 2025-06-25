<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    
    <link rel="stylesheet" href="contact_uss.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> <!--Add this line for Ionic Icons -->
</head>
<body>
    <header>
        <h2>IKSHAK JEWELLERS</h2>
        <p style="margin: 0; padding-left: 5px; text-align: left;">
            <a href="home.php" style="color: white; text-decoration: none;">Home</a>
        </p>
    </header>
    <div class="main">
        <form method="post" action="contact_us.php">
            <h2><center>Enter Here!</center></h2>
            Name:<input type="text" id="name" name="name" required><br>
            Email:<input type="email" id="email" name="email" required><br><br>
            Message:<textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
            
            <h2 class="rating-heading">Rate Us</h2>
            <div class="rating">
                <input type="radio" name="rating" id="rating-1" value="1"><label for="rating-1" class="star">&#9733;</label>
                <input type="radio" name="rating" id="rating-2" value="2"><label for="rating-2" class="star">&#9733;</label>
                <input type="radio" name="rating" id="rating-3" value="3"><label for="rating-3" class="star">&#9733;</label>
                <input type="radio" name="rating" id="rating-4" value="4"><label for="rating-4" class="star">&#9733;</label>
                <input type="radio" name="rating" id="rating-5" value="5"><label for="rating-5" class="star">&#9733;</label>
            </div>
            
            <input type="submit" class="btnn" value="SUBMIT">
        </form>
    </div>

    <!--footer section-->
    <footer>
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h3>EXTRA LINKS</h3>
                    <a href="contact.php"><i class="ion-arrow-right-c"></i> ASK QUESTIONS</a>
                    <a href="about.php"><i class="ion-arrow-right-c"></i> ABOUT US</a>
                    <a href="home.php"><i class="ion-arrow-right-c"></i> HOME</a>
                    <a href="logout.php"><i class="ion-arrow-right-c"></i> LOGOUT</a>
                </div>
                <div class="box">
                    <h3>CONTACT INFO</h3>
                    <a href="tel:1234567890"><i class="icon ion-ios-telephone"></i> +123-456-7890</a>
                    <a href="tel:1112223333"><i class="icon ion-ios-telephone"></i> +111-222-3333</a>
                    <a href="mailto:IKSHAK10@gmail.com"><i class="ion-ios-email"></i> IKSHAK10@gmail.com</a>
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
        <p class="copyrite">&copy; 2024 Jewellery Shop. All rights reserved.</p>
    </footer>

    <!--footer section ends-->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
