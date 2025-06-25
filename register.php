<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed:" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name= $_POST['full_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE  email='$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>
                alert('Username or Email already exists');
                window.location.href='register.php';
                </script>";
    } else {
        // Validate phone number length
        if (strlen($mobile_number) != 10 || !is_numeric($mobile_number)) {
            echo "<script>
            alert('Phone number should contain exactly 10 digits');
            window.location.href='register.php';
            </script>";
        // } else if ($pass != $cpass) {
            // echo "<script>
            // alert('Password does not match');
            // window.location.href='register.php';
            // </script>";
        } else {
            $sql = "INSERT INTO users(full_name, email, mobile_number, address, password) VALUES('$full_name', '$email', '$mobile_number', '$address', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                alert('Registration Successful');
                window.location.href='index.php';
                </script>";
            } else {
                echo "<script>
                alert('Invalid credentials');
                window.location.href='register.php';
                </script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SIGNUP</title>
    <meta charset="UTF_8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="reg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      

</head>
<body>
    <div class="main">
        <h2 class="logo">LITTLE WONDERS SHOP</h2>       

        
        <form method="post" action="">
            <h2>SIGNUP HERE</h2>

            <input type="text" placeholder="Enter your name" name="full_name"  required/>
            <input type="email" placeholder="Enter email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required/>
            <input type="text" id="phone" name="mobile_number" placeholder="Enter 10-digit phone number" minlength="10" maxlength="10" required>
            <input type="text" id="address" name="address" placeholder="Enter address" required>
            <input type="password" placeholder="Enter Password" name="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-<>]).{8,}" title="Password must be at least 8 characters long and contain at least one uppercase letter,one lowercase letter,one number, and one special character" required/>
            
            
            <input type="submit" class="btnn" value="SIGNUP">

            <p class="link">Already have an account?<br>
                <a href="login.php">Login</a> here!</a></p>
            <div class="footer">
                <small><a href="index.php">SKIP</a></small>
            </div>            
        </form>
    </div>
</body>
</html>