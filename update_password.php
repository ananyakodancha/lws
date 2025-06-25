<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['verified_email'];
    $new_password = $_POST['new_password'];

    // Encrypt password using sha1 (works on old WAMP)
    $new_password = ($new_password);

    // Check if email exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if ($result->num_rows == 1) {
        // Update the password
        $update = "UPDATE users SET password='$new_password' WHERE email='$email'";
        if ($conn->query($update)) {
            echo "<script>alert('Password updated successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "<script>alert('Email not found!'); window.location.href='rigister.php';</script>";
    }

    $conn->close();
}
?>