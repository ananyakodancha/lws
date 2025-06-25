<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="updateProfile.css"> <!-- Link to external CSS file -->
    <title>Admin Panel</title>
</head>
<body>
<body>
    <div class="wrapper">
        <div class="left">
             <p class="para">YOU CAN UPDATE YOUR DETAILS HRER!!</p>
            <br><br> 
             <a href="index.php"><button class="btn1">Cancel</button></a> 
        </div> 
        <div class="right">
        <form action=" " method="post">
        <h2>Update User Details</h2>
        
        <input type="text" name="full_name" placeholder="Enter Name" required><br><br>

        <input type="password" id="password" name="password" placeholder="Enter New Password" required><br><br>
    
        <input type="submit" class="update" name="update" value="Update">
        </form>
            
        </div>
    </div>

    
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecommerce_db";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['update'])) {
            $full_name = $_POST['full_name'];
            $password = $_POST['password'];
             
            // Update user in the database
            $sql_update = "UPDATE users SET password='$password' WHERE full_name='$full_name'";
            
            if ($conn->query($sql_update) === TRUE) {
                echo("<script language='javascript'>
                window.alert('User updated successfully.')
                window.location.href='profile.php'
                </script>");
                exit();

            } else {
                echo "Error updating user: " . $conn->error;
            }
        }

        $conn->close();
    ?>
</body>
</html>
