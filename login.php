<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Prepare SQL query
    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $row['user_id']; // Assuming the column name is 'id'

    header("Location: index.php");
    exit();
}

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="stylesheet" href="logstl.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="main">
                       

        

        <form method="post" action="">
            <h2>LOGIN HERE</h2>
            <input type="text" name="email" placeholder="Enter email" required>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <input type="submit" class="btnn" value="SUBMIT">
            <p class="forgot"><br>
                <a href="forgot-password.html">Forgot password?</a>
            </p>
            <p class="link">Don't have an account?<br>
                <a href="register.php">Sign up</a> here!
            </p>
            <div class="footer">
                <small><a href="index.php">SKIP</a></small>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>