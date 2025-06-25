<?php
// Connect to the database
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "ecommerce_db"; // Change this to your database name

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
                            
    // Prepare and bind SQL statement to insert data into the database
    $sql = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    if($conn->query($sql)===TRUE){
        echo "Thank you for contacting us! We will get back to you shortly.";
    } else {
        // Error inserting data
        echo "Sorry, there was an error processing your request. Please try again later.";
    }

   /* // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "Thank you for contacting us! We will get back to you shortly.";
    } else {
        // Error inserting data
        echo "Sorry, there was an error processing your request. Please try again later.";
    }

    // Close the statement
    $stmt->close();*/
} else {
    // If the form is not submitted, redirect to the contact page
    header("Location: contact.html");
}

// Close the database connection
$conn->close();
?>