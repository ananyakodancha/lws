<?php
// Connect to the database
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "ecommerce_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $rating = $_POST["rating"];

    if(empty($name) || empty($email) || empty($message) || empty($rating)) {
        echo("<script language='javascript'>
        window.alert('Please fill in all the fields.')
        window.location.href='contact.php'
        </script>");
        exit();
    }
    
    // Prepare and bind SQL statement to insert data into the database
    $sql = "INSERT INTO feedback (name, email, message, rating) VALUES ('$name', '$email', '$message', $rating)";

    if($conn->query($sql) === TRUE){
        echo("<script language='javascript'>
        window.alert('Thank you for contacting us! We will get back to you shortly.')
        window.location.href='contact.php'
        </script>");
        exit();
    } else {
        // Error inserting data
        echo("<script language='javascript'>
        window.alert('Sorry, there was an error processing your request. Please try again later.')
        window.location.href='contact.php'
        </script>");
        exit();
    }
} else {
    // If the form is not submitted, redirect to the contact page
    header("Location: contact.php");
}

// Close connection
$conn->close();
?>
