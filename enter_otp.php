<?php
session_start();
include("db.php"); // Include your database connection file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $otp_entered = $_POST['otp'];
    $email = $_SESSION['email']; // Retrieve email from session

    // Verify OTP
    $query = "SELECT * FROM otps WHERE email='$email' AND otp='$otp_entered'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_time = date("Y-m-d H:i:s");

        if ($current_time <= $row['expiry_time']) {
            // OTP is valid and not expired
            // Redirect to reset password page
            header("Location: reset_password.php");
            exit();
        } else {
            // OTP has expired
            $_SESSION['error_message'] = "OTP has expired. A new OTP has been sent to your email.";
            header("Location: resend_otp.php");
            exit();
        }
    } else {
        // Invalid OTP
        $_SESSION['error_message'] = "Invalid OTP.";
    }

    header("Location: enter_otp.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enter OTP</title>
  <link rel="stylesheet" href="index1.css"> <!-- Include your CSS file -->
</head>
<body>
<div class="login-form-container">
  <form action="enter_otp.php" method="post">
    <p style="color:black;font-size:2.2rem;font-weight:600;margin:0;padding:0;">OTP Verification</p>
    <input style="text-align:center;" type="text" id="otp" name="otp" class="box" required>
    <?php
    if(isset($_SESSION['error_message'])) {
        echo "<p style='padding:0;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>
    <p style="padding:0;color:black;">OTP has been sent to your Email</p>
    <input type="submit" value="Verify OTP" class="btn">
  </form>
</div>
</body>
</html>